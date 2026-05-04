<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AiChatController extends Controller
{
    private const SESSION_KEY = 'ai_chatbot_conversation';

    private function initializeConversation(): array
    {
        $messages = Session::get(self::SESSION_KEY, []);

        if (count($messages) === 0) {
            $messages[] = [
                'role' => 'assistant',
                'text' => 'Xin chào, tôi là trợ lý AI của HiusBlack Foods. Tôi chỉ tư vấn trong phạm vi cửa hàng này như chọn sản phẩm, mức giá, nhu cầu sức khỏe, sản phẩm bán chạy hoặc cách mua hàng trên web.',
                'products' => [],
                'created_at' => now()->format('H:i'),
            ];

            Session::put(self::SESSION_KEY, $messages);
        }

        return $messages;
    }

    private function normalizeText(string $text): string
    {
        $text = mb_strtolower(trim($text), 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text);

        return $text;
    }

    private function normalizeMoney(string $number, ?string $unit): int
    {
        $value = (int) preg_replace('/[^\d]/', '', $number);
        $unit = $unit ? mb_strtolower($unit, 'UTF-8') : '';

        if (in_array($unit, ['k', 'nghìn', 'ngan', 'ngàn'], true)) {
            return $value * 1000;
        }

        if (in_array($unit, ['tr', 'triệu'], true)) {
            return $value * 1000000;
        }

        return $value;
    }

    private function extractPricePreferences(string $message): array
    {
        $result = [];

        if (preg_match('/(dưới|duoi|không quá|khong qua|tối đa|toi da|max)\s*([\d\.,]+)\s*(k|nghìn|ngàn|tr|triệu)?/u', $message, $matches)) {
            $result['max_price'] = $this->normalizeMoney($matches[2], $matches[3] ?? null);
        }

        if (preg_match('/(trên|tren|từ|tu|ít nhất|it nhat|min)\s*([\d\.,]+)\s*(k|nghìn|ngàn|tr|triệu)?/u', $message, $matches)) {
            $result['min_price'] = $this->normalizeMoney($matches[2], $matches[3] ?? null);
        }

        if (preg_match('/(tầm|tam|khoảng|khoang)\s*([\d\.,]+)\s*(k|nghìn|ngàn|tr|triệu)?/u', $message, $matches)) {
            $targetPrice = $this->normalizeMoney($matches[2], $matches[3] ?? null);
            $result['min_price'] = max(0, (int) ($targetPrice * 0.75));
            $result['max_price'] = (int) ($targetPrice * 1.25);
        }

        return $result;
    }

    private function extractPreferenceContext(string $message, array $currentContext): array
    {
        $context = $currentContext;
        $message = $this->normalizeText($message);

        $categories = DB::table('tbl_category_product')
            ->where('category_status', 1)
            ->get(['category_id', 'category_name']);

        $matchedCategoryIds = [];
        $matchedCategoryNames = [];
        foreach ($categories as $category) {
            $categoryName = $this->normalizeText($category->category_name);
            if ($categoryName !== '' && str_contains($message, $categoryName)) {
                $matchedCategoryIds[] = (int) $category->category_id;
                $matchedCategoryNames[] = $category->category_name;
            }
        }

        if (count($matchedCategoryIds) > 0) {
            $context['category_ids'] = $matchedCategoryIds;
            $context['category_names'] = $matchedCategoryNames;
        }

        $keywordGroups = [
            'healthy' => ['sức khỏe', 'suc khoe', 'healthy', 'ăn kiêng', 'an kieng', 'detox', 'vitamin', 'giảm cân', 'giam can', 'ít ngọt', 'it ngot'],
            'sweet' => ['ngọt', 'ngot', 'đậm vị', 'dam vi'],
            'fresh' => ['tươi', 'tuoi', 'mát', 'mat', 'thanh mát', 'thanh mat'],
            'premium' => ['cao cấp', 'cao cap', 'quà', 'qua', 'biếu', 'bieu', 'tặng', 'tang'],
            'cheap' => ['giá rẻ', 'gia re', 'tiết kiệm', 'tiet kiem', 'rẻ', 're'],
            'popular' => ['bán chạy', 'ban chay', 'phổ biến', 'pho bien', 'nhiều người mua', 'nhieu nguoi mua'],
        ];

        $preferences = $context['preferences'] ?? [];
        foreach ($keywordGroups as $key => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    $preferences[$key] = true;
                }
            }
        }

        $context['preferences'] = $preferences;
        $context = array_merge($context, $this->extractPricePreferences($message));

        $stopwords = ['toi', 'tôi', 'muon', 'muốn', 'can', 'cần', 'loai', 'loại', 'san', 'sản', 'pham', 'phẩm', 'goi', 'gợi', 'y', 'ý', 'co', 'có', 'nao', 'nào', 'duoi', 'tren', 'tam', 'khoang', 'gia', 'giá', 'cho', 'voi', 'với'];
        $tokens = preg_split('/[^[:alnum:]\p{L}]+/u', $message);
        $keywords = collect($tokens)
            ->filter(fn ($token) => $token !== null && mb_strlen($token, 'UTF-8') >= 3)
            ->reject(fn ($token) => in_array($token, $stopwords, true))
            ->unique()
            ->values()
            ->all();

        if (count($keywords) > 0) {
            $context['keywords'] = array_values(array_unique(array_merge($context['keywords'] ?? [], $keywords)));
        }

        return $context;
    }

    private function shouldRecommendProducts(string $message, array $context): bool
    {
        $message = $this->normalizeText($message);

        if (!empty($context['category_ids']) || !empty($context['keywords']) || !empty($context['min_price']) || !empty($context['max_price'])) {
            return true;
        }

        $productIntentKeywords = [
            'sản phẩm', 'san pham', 'trái cây', 'trai cay', 'rau', 'quả', 'qua',
            'mua gì', 'mua gi', 'gợi ý', 'goi y', 'tư vấn', 'tu van', 'giá', 'gia',
            'ngọt', 'ngot', 'tươi', 'tuoi', 'healthy', 'detox', 'vitamin',
            'bán chạy', 'ban chay', 'khuyến mãi', 'khuyen mai',
        ];

        foreach ($productIntentKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }

        return false;
    }

    private function buildRecommendationQuery()
    {
        $salesSub = DB::table('tbl_oder')
            ->leftJoin('tbl_order_main', 'tbl_oder.order_id', '=', 'tbl_order_main.order_id')
            ->select(
                'tbl_oder.oder_id_product',
                DB::raw('COALESCE(SUM(CASE WHEN tbl_order_main.status != 5 THEN tbl_oder.oder_soluong ELSE 0 END), 0) as total_sold')
            )
            ->groupBy('tbl_oder.oder_id_product');

        return DB::table('tbl_product')
            ->leftJoin('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->leftJoinSub($salesSub, 'sales_stats', function ($join) {
                $join->on('tbl_product.product_id', '=', 'sales_stats.oder_id_product');
            })
            ->whereNull('tbl_product.deleted_at')
            ->where('tbl_product.product_status', 1)
            ->where('tbl_product.stock_quantity', '>', 0)
            ->select(
                'tbl_product.product_id',
                'tbl_product.product_name',
                'tbl_product.product_price',
                'tbl_product.product_desc',
                'tbl_product.product_content',
                'tbl_product.product_image',
                'tbl_product.stock_quantity',
                'tbl_product.category_id',
                'tbl_category_product.category_name',
                DB::raw('COALESCE(sales_stats.total_sold, 0) as total_sold')
            );
    }

    private function scoreProduct($product, array $context): int
    {
        $score = 0;
        $haystack = $this->normalizeText(
            $product->product_name . ' ' .
            $product->product_desc . ' ' .
            $product->product_content . ' ' .
            ($product->category_name ?? '')
        );

        if (!empty($context['category_ids']) && in_array((int) $product->category_id, $context['category_ids'], true)) {
            $score += 30;
        }

        foreach (($context['keywords'] ?? []) as $keyword) {
            if (str_contains($haystack, $this->normalizeText($keyword))) {
                $score += 10;
            }
        }

        $preferences = $context['preferences'] ?? [];
        if (!empty($preferences['healthy'])) {
            foreach (['healthy', 'vitamin', 'organic', 'tươi', 'tuoi', 'thanh', 'mát', 'mat'] as $keyword) {
                if (str_contains($haystack, $keyword)) {
                    $score += 8;
                }
            }
        }

        if (!empty($preferences['sweet'])) {
            foreach (['ngọt', 'ngot', 'đậm', 'dam'] as $keyword) {
                if (str_contains($haystack, $keyword)) {
                    $score += 8;
                }
            }
        }

        if (!empty($preferences['fresh'])) {
            foreach (['tươi', 'tuoi', 'mát', 'mat', 'thanh'] as $keyword) {
                if (str_contains($haystack, $keyword)) {
                    $score += 8;
                }
            }
        }

        if (!empty($preferences['premium'])) {
            $score += (int) ((int) $product->product_price / 100000);
        }

        if (!empty($preferences['popular'])) {
            $score += min(25, (int) $product->total_sold);
        }

        if (!empty($preferences['cheap'])) {
            $score += max(0, 20 - (int) ((int) $product->product_price / 50000));
        }

        if (!empty($context['min_price']) && (int) $product->product_price >= (int) $context['min_price']) {
            $score += 10;
        }

        if (!empty($context['max_price']) && (int) $product->product_price <= (int) $context['max_price']) {
            $score += 14;
        }

        if (!empty($context['max_price']) && (int) $product->product_price > (int) $context['max_price']) {
            $score -= 12;
        }

        return $score;
    }

    private function formatProducts($products): array
    {
        return collect($products)->map(function ($product) {
            return [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'product_price' => number_format((int) $product->product_price) . 'đ',
                'product_price_raw' => (int) $product->product_price,
                'product_image' => asset('upload/product/' . $product->product_image),
                'product_url' => url('/chi-tiet-san-pham/' . $product->product_id),
                'category_name' => $product->category_name,
                'product_desc' => mb_substr(strip_tags((string) $product->product_desc), 0, 140, 'UTF-8'),
                'product_content' => mb_substr(strip_tags((string) $product->product_content), 0, 160, 'UTF-8'),
                'stock_quantity' => (int) $product->stock_quantity,
                'total_sold' => (int) $product->total_sold,
            ];
        })->values()->all();
    }

    private function containsSensitiveIntent(string $message): bool
    {
        $message = $this->normalizeText($message);
        $patterns = [
            'api key', 'apikey', 'secret', 'password', 'mat khau', 'mật khẩu',
            'token', 'jwt', 'env', '.env', 'database', 'db_', 'smtp',
            'google_client_secret', 'mail_password', 'source code', 'mã nguồn',
            'admin login', 'dang nhap admin', 'đăng nhập admin', 'thông tin mật', 'thong tin mat',
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($message, $pattern)) {
                return true;
            }
        }

        return false;
    }

    private function isOutOfScopeRequest(string $message): bool
    {
        $message = $this->normalizeText($message);
        $allowKeywords = [
            'sản phẩm', 'san pham', 'trái cây', 'trai cay', 'rau', 'quả', 'qua',
            'giá', 'gia', 'mua', 'giỏ hàng', 'gio hang', 'đặt hàng', 'dat hang',
            'khuyến mãi', 'khuyen mai', 'đơn hàng', 'don hang', 'shop', 'cửa hàng', 'cua hang',
            'ngọt', 'ngot', 'tươi', 'tuoi', 'healthy', 'vitamin', 'detox', 'quà', 'qua',
            'gợi ý', 'goi y', 'tư vấn', 'tu van', 'bán chạy', 'ban chay',
        ];

        foreach ($allowKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return false;
            }
        }

        return mb_strlen($message, 'UTF-8') > 0;
    }

    private function getScopedProducts(array $context): array
    {
        return $this->formatProducts(
            $this->buildRecommendationQuery()
                ->get()
                ->map(function ($product) use ($context) {
                    $product->ai_score = $this->scoreProduct($product, $context);
                    return $product;
                })
                ->sortByDesc('ai_score')
                ->take(5)
                ->values()
        );
    }

    private function buildSystemInstruction(): string
    {
        return implode("\n", [
            'Bạn là trợ lý AI tư vấn bán hàng cho website HiusBlack Foods.',
            'Chỉ được trả lời trong phạm vi website này: sản phẩm, danh mục, mức giá, nhu cầu khách hàng, khuyến mãi, cách mua hàng, tình trạng chung của cửa hàng.',
            'Chỉ sử dụng dữ liệu sản phẩm được cung cấp trong prompt làm nguồn sự thật.',
            'Không được bịa thêm sản phẩm, giá, tồn kho, chính sách, mã giảm giá hoặc thông tin nội bộ.',
            'Không được tiết lộ bí mật, khóa API, token, mật khẩu, thông tin .env, cấu hình server, email nội bộ, dữ liệu quản trị hay bất kỳ thông tin nhạy cảm nào.',
            'Nếu người dùng hỏi ngoài phạm vi cửa hàng hoặc đòi thông tin bí mật, phải từ chối ngắn gọn và kéo họ quay lại nhu cầu mua sắm trên website.',
            'Nếu dữ liệu sản phẩm không đủ chắc chắn, hãy nói rõ giới hạn thay vì đoán.',
            'Ưu tiên câu trả lời ngắn gọn, thực dụng, tiếng Việt tự nhiên.',
        ]);
    }

    private function buildGeminiContents(array $messages, string $currentMessage, array $products, array $context): array
    {
        $history = collect($messages)
            ->filter(fn ($message) => in_array($message['role'], ['user', 'assistant'], true))
            ->take(-6)
            ->map(function ($message) {
                return [
                    'role' => $message['role'] === 'assistant' ? 'model' : 'user',
                    'parts' => [
                        ['text' => $message['text']],
                    ],
                ];
            })
            ->values()
            ->all();

        $history[] = [
            'role' => 'user',
            'parts' => [
                [
                    'text' => implode("\n\n", [
                        'Tin nhắn mới của khách:',
                        $currentMessage,
                        'Ngữ cảnh đã rút trích từ các câu trước:',
                        json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                        'Danh sách sản phẩm được phép dùng để tư vấn:',
                        json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                        'Hãy trả lời ngắn gọn. Nếu phù hợp, nêu 1-3 sản phẩm nổi bật từ danh sách trên và giải thích rất ngắn vì sao hợp nhu cầu.',
                    ]),
                ],
            ],
        ];

        return $history;
    }

    private function callGemini(array $messages, string $currentMessage, array $products, array $context): array
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-2.5-flash');

        if (!$apiKey) {
            return [
                'reply' => 'Chatbot AI chưa được cấu hình khóa Gemini. Hãy thêm `GEMINI_API_KEY` vào file môi trường để bật tư vấn AI thật.',
                'recommended_product_ids' => [],
            ];
        }

        $endpoint = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent',
            $model
        );

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $this->buildSystemInstruction()],
                ],
            ],
            'contents' => $this->buildGeminiContents($messages, $currentMessage, $products, $context),
            'generationConfig' => [
                'temperature' => 0.4,
                'topP' => 0.8,
                'topK' => 20,
                'maxOutputTokens' => 400,
                'responseMimeType' => 'application/json',
                'responseJsonSchema' => [
                    'type' => 'object',
                    'properties' => [
                        'reply' => [
                            'type' => 'string',
                            'description' => 'Câu trả lời ngắn gọn bằng tiếng Việt trong phạm vi cửa hàng.',
                        ],
                        'recommended_product_ids' => [
                            'type' => 'array',
                            'description' => 'Danh sách product_id thực sự phù hợp với câu trả lời. Chỉ chọn từ dữ liệu sản phẩm được cung cấp.',
                            'items' => [
                                'type' => 'integer',
                            ],
                        ],
                    ],
                    'required' => ['reply', 'recommended_product_ids'],
                ],
            ],
            'safetySettings' => [
                [
                    'category' => 'HARM_CATEGORY_HARASSMENT',
                    'threshold' => 'BLOCK_LOW_AND_ABOVE',
                ],
                [
                    'category' => 'HARM_CATEGORY_HATE_SPEECH',
                    'threshold' => 'BLOCK_LOW_AND_ABOVE',
                ],
                [
                    'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                    'threshold' => 'BLOCK_LOW_AND_ABOVE',
                ],
                [
                    'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                    'threshold' => 'BLOCK_LOW_AND_ABOVE',
                ],
            ],
        ];

        $response = Http::timeout(20)
            ->acceptJson()
            ->withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($endpoint, $payload);

        if (!$response->successful()) {
            Log::warning('Gemini API request failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return [
                'reply' => 'Tôi đang gặp lỗi khi kết nối AI. Tạm thời bạn hãy hỏi lại theo nhu cầu cụ thể hơn như loại trái cây, mức giá hoặc mục đích sử dụng.',
                'recommended_product_ids' => [],
            ];
        }

        $data = $response->json();
        $text = data_get($data, 'candidates.0.content.parts.0.text');

        if (!$text) {
            return [
                'reply' => 'Tôi chưa tạo được câu trả lời phù hợp. Bạn có thể diễn đạt lại nhu cầu như "dưới 100k", "ít ngọt" hoặc "loại bán chạy".',
                'recommended_product_ids' => [],
            ];
        }

        $decoded = json_decode($text, true);

        if (!is_array($decoded)) {
            return [
                'reply' => trim($text),
                'recommended_product_ids' => [],
            ];
        }

        return [
            'reply' => trim((string) ($decoded['reply'] ?? '')),
            'recommended_product_ids' => collect($decoded['recommended_product_ids'] ?? [])
                ->filter(fn ($id) => is_numeric($id))
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all(),
        ];
    }

    private function filterProductsByAiChoice(array $products, array $recommendedProductIds): array
    {
        if (count($recommendedProductIds) === 0) {
            return [];
        }

        $productMap = collect($products)->keyBy('product_id');

        return collect($recommendedProductIds)
            ->map(fn ($productId) => $productMap->get($productId))
            ->filter()
            ->values()
            ->all();
    }

    private function buildSafeRefusal(string $type): string
    {
        if ($type === 'sensitive') {
            return 'Tôi không thể cung cấp thông tin bí mật hoặc dữ liệu nội bộ. Nếu bạn cần, tôi có thể tiếp tục tư vấn sản phẩm, giá hoặc cách mua hàng trên website.';
        }

        return 'Tôi chỉ hỗ trợ trong phạm vi website HiusBlack Foods như tư vấn sản phẩm, mức giá, nhu cầu mua sắm và cách đặt hàng. Bạn hãy hỏi theo nhu cầu mua hàng cụ thể nhé.';
    }

    public function history()
    {
        return response()->json([
            'messages' => $this->initializeConversation(),
        ]);
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:2|max:1000',
        ]);

        $message = trim($validated['message']);
        $messages = $this->initializeConversation();
        $context = $this->extractPreferenceContext($message, []);

        $messages[] = [
            'role' => 'user',
            'text' => $message,
            'products' => [],
            'created_at' => now()->format('H:i'),
        ];

        if ($this->containsSensitiveIntent($message)) {
            $replyText = $this->buildSafeRefusal('sensitive');
            $formattedProducts = [];
        } elseif ($this->isOutOfScopeRequest($message) && !$this->shouldRecommendProducts($message, $context)) {
            $replyText = $this->buildSafeRefusal('scope');
            $formattedProducts = [];
        } else {
            $candidateProducts = $this->shouldRecommendProducts($message, $context)
                ? $this->getScopedProducts($context)
                : [];
            $aiResult = $this->callGemini($messages, $message, $candidateProducts, $context);
            $replyText = $aiResult['reply'] ?? 'Tôi chưa có câu trả lời phù hợp.';
            $formattedProducts = $this->filterProductsByAiChoice(
                $candidateProducts,
                $aiResult['recommended_product_ids'] ?? []
            );
        }

        $messages[] = [
            'role' => 'assistant',
            'text' => $replyText,
            'products' => $formattedProducts,
            'created_at' => now()->format('H:i'),
        ];

        if (count($messages) > 14) {
            $messages = array_slice($messages, -14);
        }

        Session::put(self::SESSION_KEY, $messages);

        return response()->json([
            'messages' => $messages,
            'context' => $context,
        ]);
    }

    public function reset()
    {
        Session::forget(self::SESSION_KEY);

        return response()->json([
            'messages' => $this->initializeConversation(),
        ]);
    }
}
