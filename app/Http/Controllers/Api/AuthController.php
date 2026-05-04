<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|max:50|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'rank' => 'Thường',
            'total_spent' => 0,
        ]);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, $user, 201, 'Đăng ký tài khoản thành công.');
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email hoặc mật khẩu không đúng.',
            ], 401);
        }

        return $this->respondWithToken($token, $this->currentUser(), 200, 'Đăng nhập thành công.');
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'user' => $this->currentUser(),
        ]);
    }

    public function refresh(): JsonResponse
    {
        $token = JWTAuth::parseToken()->refresh();

        return $this->respondWithToken($token, JWTAuth::setToken($token)->toUser(), 200, 'Làm mới token thành công.');
    }

    public function logout(): JsonResponse
    {
        JWTAuth::parseToken()->invalidate();

        return response()->json([
            'message' => 'Đăng xuất thành công.',
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $this->currentUser();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|min:2|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|max:50|confirmed',
        ]);

        if (array_key_exists('name', $validated)) {
            $user->name = $validated['name'];
        }

        if (array_key_exists('phone', $validated)) {
            $user->phone = $validated['phone'];
        }

        if (array_key_exists('address', $validated)) {
            $user->address = $validated['address'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'Cập nhật thông tin thành công.',
            'user' => $user->fresh(),
        ]);
    }

    private function respondWithToken(string $token, User $user, int $status = 200, ?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
        ], $status);
    }

    private function currentUser(): User
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user instanceof User) {
            throw new UnauthorizedHttpException('Bearer', 'Token không hợp lệ hoặc người dùng không tồn tại.');
        }

        return $user;
    }
}
