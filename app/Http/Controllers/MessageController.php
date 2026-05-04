<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    private function ensureAdminAuthenticated()
    {
        if (!Session::has('admin_id')) {
            abort(403, 'Admin chưa đăng nhập');
        }
    }

    private function formatMessage($message): array
    {
        return [
            'message_id' => $message->message_id,
            'user_id' => $message->user_id,
            'admin_id' => $message->admin_id,
            'sender_type' => $message->sender_type,
            'message_text' => $message->message_text,
            'is_read' => (bool) $message->is_read,
            'created_at' => optional($message->created_at)->format('d/m/Y H:i'),
            'created_at_raw' => (string) $message->created_at,
        ];
    }

    private function getConversationMessages(int $userId)
    {
        return DB::table('tbl_messages')
            ->where('user_id', $userId)
            ->orderBy('created_at')
            ->get()
            ->map(fn ($message) => $this->formatMessage($message))
            ->values();
    }

    private function markUserConversationAsRead(int $userId): void
    {
        DB::table('tbl_messages')
            ->where('user_id', $userId)
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now(),
            ]);
    }

    private function markAdminConversationAsRead(int $userId): void
    {
        DB::table('tbl_messages')
            ->where('user_id', $userId)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now(),
            ]);
    }

    private function getAdminConversationList()
    {
        $latestMessageSub = DB::table('tbl_messages')
            ->select('user_id', DB::raw('MAX(message_id) as latest_message_id'))
            ->groupBy('user_id');

        return DB::table('users')
            ->joinSub($latestMessageSub, 'latest_conversations', function ($join) {
                $join->on('users.id', '=', 'latest_conversations.user_id');
            })
            ->join('tbl_messages', 'tbl_messages.message_id', '=', 'latest_conversations.latest_message_id')
            ->leftJoin(DB::raw('(SELECT user_id, COUNT(*) as unread_count FROM tbl_messages WHERE sender_type = "user" AND is_read = 0 GROUP BY user_id) unread_stats'), 'users.id', '=', 'unread_stats.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'tbl_messages.message_text as latest_message_text',
                'tbl_messages.created_at as latest_message_created_at',
                DB::raw('COALESCE(unread_stats.unread_count, 0) as unread_count')
            )
            ->orderByDesc('tbl_messages.created_at')
            ->get();
    }

    public function userMessages()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập'], 401);
        }

        $this->markUserConversationAsRead(Auth::id());

        return response()->json([
            'messages' => $this->getConversationMessages(Auth::id()),
            'admin_name' => 'Admin HiusBlack Foods',
        ]);
    }

    public function userSendMessage(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập'], 401);
        }

        $validated = $request->validate([
            'message_text' => 'required|string|min:1|max:2000',
        ]);

        DB::table('tbl_messages')->insert([
            'user_id' => Auth::id(),
            'admin_id' => Session::get('admin_id'),
            'sender_type' => 'user',
            'message_text' => trim($validated['message_text']),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'messages' => $this->getConversationMessages(Auth::id()),
        ]);
    }

    public function adminMessagesPage(Request $request)
    {
        $this->ensureAdminAuthenticated();

        $conversations = $this->getAdminConversationList();
        $selectedUserId = (int) ($request->query('user_id') ?: ($conversations->first()->id ?? 0));
        $selectedUser = $selectedUserId
            ? DB::table('users')->where('id', $selectedUserId)->first()
            : null;

        if ($selectedUser) {
            $this->markAdminConversationAsRead($selectedUserId);
        }

        return view('pages_admin.admin_messages', [
            'conversations' => $conversations,
            'selectedUser' => $selectedUser,
            'selectedUserId' => $selectedUserId,
            'messages' => $selectedUser ? $this->getConversationMessages($selectedUserId) : collect(),
        ]);
    }

    public function adminConversation(int $userId)
    {
        $this->ensureAdminAuthenticated();

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng'], 404);
        }

        $this->markAdminConversationAsRead($userId);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'messages' => $this->getConversationMessages($userId),
            'conversations' => $this->getAdminConversationList(),
        ]);
    }

    public function adminSendMessage(Request $request, int $userId)
    {
        $this->ensureAdminAuthenticated();

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng'], 404);
        }

        $validated = $request->validate([
            'message_text' => 'required|string|min:1|max:2000',
        ]);

        DB::table('tbl_messages')->insert([
            'user_id' => $userId,
            'admin_id' => Session::get('admin_id'),
            'sender_type' => 'admin',
            'message_text' => trim($validated['message_text']),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'messages' => $this->getConversationMessages($userId),
            'conversations' => $this->getAdminConversationList(),
        ]);
    }
}
