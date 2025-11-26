<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIInsightService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('openai.api_key') ?? env('OPENAI_API_KEY');
    }

    /**
     * Generate AI insights from business data
     * 
     * @param array $data Business data (sales, products, trends)
     * @param int $cacheMinutes Cache duration in minutes
     * @return array
     */
    public function generateInsights(array $data, int $cacheMinutes = 60): array
    {
        $cacheKey = 'ai_insights_' . md5(json_encode($data));
        
        // return Cache::remember($cacheKey, now()->addMinutes($cacheMinutes), function () use ($data) {
            return $this->processInsights($data);
        // });
    }

    /**
     * Process data and generate insights
     * 
     * @param array $data
     * @return array
     */
    protected function processInsights(array $data): array
    {
        // Calculate metrics (these are data-driven, not AI-generated)
        $metrics = $this->calculateMetrics($data);
        
        // Generate AI-powered insights using ChatGPT
        $aiInsights = $this->callChatGPTAPI($data, $metrics);
        
        return [
            'metrics' => $metrics,
            'recommendations' => $aiInsights['recommendations'] ?? [],
            'summary' => $aiInsights['summary'] ?? '',
            'detailed_analysis' => $aiInsights['detailed_analysis'] ?? [],
            'generated_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Call ChatGPT API to generate insights
     * 
     * @param array $data
     * @param array $metrics
     * @return array
     */
    protected function callChatGPTAPI(array $data, array $metrics): array
    {
        if (empty($this->apiKey)) {
            Log::warning('OpenAI API key not configured, falling back to default insights');
            return $this->getFallbackInsights($data, $metrics);
        }

        try {
            $prompt = $this->buildPrompt($data, $metrics);
            
            $requestPayload = [
                'model' => 'gpt-3.5-turbo', // Use gpt-3.5-turbo for faster and cheaper responses
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah asisten AI analis bisnis. Analisis data bisnis dan berikan wawasan, rekomendasi, dan ringkasan dalam format JSON. SEMUA RESPONS HARUS DALAM BAHASA INDONESIA (BAHASA).'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ];
            
            // Log request
            Log::info('🤖 AI Insights: Sending request to ChatGPT API', [
                'model' => $requestPayload['model'],
                'prompt_length' => strlen($prompt),
                'data_summary' => [
                    'revenue' => $data['sales']['total_revenue'] ?? 0,
                    'profit_margin' => $metrics['profit_margin']['value'] ?? 0,
                    'trending_products_count' => count($data['trending_products'] ?? []),
                ]
            ]);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->apiUrl, $requestPayload);

            if ($response->successful()) {
                $responseData = $response->json();
                $content = $responseData['choices'][0]['message']['content'] ?? '';
                
                // Log successful response
                Log::info('✅ AI Insights: ChatGPT API response received', [
                    'usage' => $responseData['usage'] ?? [],
                    'response_length' => strlen($content),
                    'model' => $responseData['model'] ?? 'unknown',
                ]);
                
                // Log the raw AI response content
                Log::debug('📝 AI Insights: Raw ChatGPT response', [
                    'content' => $content
                ]);
                
                $parsedResponse = $this->parseAIResponse($content, $data, $metrics);
                
                // Log parsed response
                Log::info('📊 AI Insights: Parsed response', [
                    'has_summary' => !empty($parsedResponse['summary']),
                    'recommendations_count' => count($parsedResponse['recommendations'] ?? []),
                    'analysis_sections_count' => count($parsedResponse['detailed_analysis'] ?? []),
                ]);
                
                return $parsedResponse;
            } else {
                $errorBody = $response->body();
                Log::error('❌ AI Insights: OpenAI API error', [
                    'status' => $response->status(),
                    'body' => $errorBody,
                    'response' => $response->json(),
                ]);
                return $this->getFallbackInsights($data, $metrics);
            }
        } catch (\Exception $e) {
            Log::error('❌ AI Insights: Exception calling ChatGPT API', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->getFallbackInsights($data, $metrics);
        }
    }

    /**
     * Build prompt for ChatGPT
     * 
     * @param array $data
     * @param array $metrics
     * @return string
     */
    protected function buildPrompt(array $data, array $metrics): string
    {
        $sales = $data['sales'] ?? [];
        $trending = $data['trending_products'] ?? [];
        
        $prompt = "Analisis data bisnis berikut dan berikan wawasan dalam format JSON:\n\n";
        
        $prompt .= "METRIK BISNIS:\n";
        $prompt .= "- Pendapatan Periode Saat Ini: " . number_format($sales['current_period_revenue'] ?? 0, 2) . "\n";
        $prompt .= "- Pendapatan Periode Sebelumnya: " . number_format($sales['previous_period_revenue'] ?? 0, 2) . "\n";
        $prompt .= "- Perubahan Pendapatan: " . $metrics['revenue_trend']['value'] . "% (" . ($metrics['revenue_trend']['direction'] === 'up' ? 'naik' : 'turun') . ")\n";
        $prompt .= "- Total Pendapatan: " . number_format($sales['total_revenue'] ?? 0, 2) . "\n";
        $prompt .= "- Total Biaya: " . number_format($sales['total_cost'] ?? 0, 2) . "\n";
        $prompt .= "- Margin Laba: " . $metrics['profit_margin']['value'] . "%\n";
        $prompt .= "- Total Faktur: " . ($sales['total_invoices'] ?? 0) . "\n";
        $prompt .= "- Faktur Terbayar: " . ($sales['paid_invoices'] ?? 0) . "\n";
        $prompt .= "- Efisiensi Penagihan: " . $metrics['collection_efficiency']['value'] . "%\n";
        $prompt .= "- Skor Kesehatan Stok: " . $metrics['stock_health']['value'] . "%\n";
        $prompt .= "- Produk Stok Rendah: " . ($data['low_stock_count'] ?? 0) . " dari " . ($data['total_products'] ?? 0) . "\n";
        
        if (!empty($trending)) {
            $prompt .= "\nPRODUK TERLARIS:\n";
            foreach (array_slice($trending, 0, 5) as $index => $product) {
                $productName = explode(' - ', $product['name'])[0] ?? $product['name'];
                $prompt .= ($index + 1) . ". " . $productName . " - " . $product['quantity_sold'] . " " . ($product['unit'] ?? 'unit') . " terjual\n";
            }
        }
        
        $prompt .= "\nPENTING: Berikan respons JSON dengan struktur berikut DALAM BAHASA INDONESIA:\n";
        $prompt .= "{\n";
        $prompt .= '  "summary": "Ringkasan performa bisnis 2-3 paragraf yang ringkas",' . "\n";
        $prompt .= '  "recommendations": [' . "\n";
        $prompt .= '    {"type": "warning|info|success", "priority": "high|medium|low", "message": "teks rekomendasi"}' . "\n";
        $prompt .= '  ],' . "\n";
        $prompt .= '  "detailed_analysis": [' . "\n";
        $prompt .= '    {"title": "Judul Bagian", "content": "Konten analisis detail"}' . "\n";
        $prompt .= '  ]' . "\n";
        $prompt .= "}\n\n";
        $prompt .= "Berikan wawasan yang dapat ditindaklanjuti, rekomendasi spesifik, dan identifikasi peluang peningkatan. Ringkas namun informatif. SEMUA TEKS HARUS DALAM BAHASA INDONESIA.";
        
        return $prompt;
    }

    /**
     * Parse AI response from ChatGPT
     * 
     * @param string $content
     * @param array $data
     * @param array $metrics
     * @return array
     */
    protected function parseAIResponse(string $content, array $data, array $metrics): array
    {
        // Try to extract JSON from the response (ChatGPT sometimes wraps JSON in markdown)
        $originalContent = $content;
        $content = trim($content);
        
        // Remove markdown code blocks if present
        if (preg_match('/```json\s*(.*?)\s*```/s', $content, $matches)) {
            $content = $matches[1];
            Log::debug('📝 AI Insights: Extracted JSON from markdown code block');
        } elseif (preg_match('/```\s*(.*?)\s*```/s', $content, $matches)) {
            $content = $matches[1];
            Log::debug('📝 AI Insights: Extracted JSON from code block');
        }
        
        // Try to find JSON object
        if (preg_match('/\{.*\}/s', $content, $matches)) {
            $content = $matches[0];
            Log::debug('📝 AI Insights: Extracted JSON object from content');
        }
        
        $decoded = json_decode($content, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            Log::info('✅ AI Insights: Successfully parsed JSON response', [
                'has_summary' => isset($decoded['summary']),
                'recommendations_count' => count($decoded['recommendations'] ?? []),
                'analysis_count' => count($decoded['detailed_analysis'] ?? []),
            ]);
            
            return [
                'summary' => $decoded['summary'] ?? $this->generateSummary($data, $metrics),
                'recommendations' => $this->formatRecommendations($decoded['recommendations'] ?? []),
                'detailed_analysis' => $this->formatDetailedAnalysis($decoded['detailed_analysis'] ?? []),
            ];
        }
        
        // If JSON parsing fails, log the error and use fallback
        Log::warning('⚠️ AI Insights: Failed to parse ChatGPT JSON response', [
            'json_error' => json_last_error_msg(),
            'content_preview' => substr($originalContent, 0, 200),
            'content_length' => strlen($originalContent),
        ]);
        
        return $this->getFallbackInsights($data, $metrics);
    }

    /**
     * Format recommendations from AI response
     * 
     * @param array $recommendations
     * @return array
     */
    protected function formatRecommendations(array $recommendations): array
    {
        $formatted = [];
        foreach ($recommendations as $rec) {
            if (is_array($rec) && isset($rec['message'])) {
                $formatted[] = [
                    'type' => $rec['type'] ?? 'info',
                    'priority' => $rec['priority'] ?? 'medium',
                    'message' => $rec['message'],
                ];
            }
        }
        
        // Sort by priority
        usort($formatted, function ($a, $b) {
            $priorityOrder = ['high' => 3, 'medium' => 2, 'low' => 1];
            return ($priorityOrder[$b['priority']] ?? 2) - ($priorityOrder[$a['priority']] ?? 2);
        });
        
        return array_slice($formatted, 0, 5);
    }

    /**
     * Format detailed analysis from AI response
     * 
     * @param array $analysis
     * @return array
     */
    protected function formatDetailedAnalysis(array $analysis): array
    {
        $formatted = [];
        foreach ($analysis as $item) {
            if (is_array($item) && isset($item['title']) && isset($item['content'])) {
                $formatted[] = [
                    'title' => $item['title'],
                    'content' => $item['content'],
                ];
            }
        }
        
        return $formatted;
    }

    /**
     * Fallback insights if API fails
     * 
     * @param array $data
     * @param array $metrics
     * @return array
     */
    protected function getFallbackInsights(array $data, array $metrics): array
    {
        return [
            'summary' => $this->generateSummary($data, $metrics),
            'recommendations' => $this->generateRecommendations($data, $metrics),
            'detailed_analysis' => $this->generateDetailedAnalysis($data, $metrics),
        ];
    }

    /**
     * Calculate key metrics from data
     * 
     * @param array $data
     * @return array
     */
    protected function calculateMetrics(array $data): array
    {
        $sales = $data['sales'] ?? [];
        $trending = $data['trending_products'] ?? [];
        
        // Revenue trend
        $currentRevenue = $sales['current_period_revenue'] ?? 0;
        $previousRevenue = $sales['previous_period_revenue'] ?? 0;
        $revenueChange = $previousRevenue > 0 
            ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 
            : 0;
        
        // Profit margin
        $totalRevenue = $sales['total_revenue'] ?? 0;
        $totalCost = $sales['total_cost'] ?? 0;
        $profitMargin = $totalRevenue > 0 
            ? (($totalRevenue - $totalCost) / $totalRevenue) * 100 
            : 0;
        
        // Collection efficiency
        $totalInvoices = $sales['total_invoices'] ?? 0;
        $paidInvoices = $sales['paid_invoices'] ?? 0;
        $collectionEfficiency = $totalInvoices > 0 
            ? ($paidInvoices / $totalInvoices) * 100 
            : 0;
        
        // Stock health (based on low stock alerts)
        $lowStockCount = $data['low_stock_count'] ?? 0;
        $totalProducts = $data['total_products'] ?? 1;
        $stockHealthScore = max(0, 100 - (($lowStockCount / $totalProducts) * 100));

        return [
            'revenue_trend' => [
                'value' => round($revenueChange, 1),
                'direction' => $revenueChange >= 0 ? 'up' : 'down',
                'status' => $revenueChange >= 10 ? 'excellent' : ($revenueChange >= 5 ? 'good' : ($revenueChange >= 0 ? 'stable' : 'declining')),
            ],
            'profit_margin' => [
                'value' => round($profitMargin, 1),
                'status' => $profitMargin >= 25 ? 'excellent' : ($profitMargin >= 15 ? 'good' : ($profitMargin >= 10 ? 'fair' : 'low')),
            ],
            'collection_efficiency' => [
                'value' => round($collectionEfficiency, 1),
                'status' => $collectionEfficiency >= 90 ? 'excellent' : ($collectionEfficiency >= 75 ? 'good' : ($collectionEfficiency >= 60 ? 'fair' : 'needs_attention')),
            ],
            'stock_health' => [
                'value' => round($stockHealthScore, 1),
                'status' => $stockHealthScore >= 90 ? 'excellent' : ($stockHealthScore >= 75 ? 'good' : ($stockHealthScore >= 60 ? 'fair' : 'needs_attention')),
            ],
        ];
    }

    /**
     * Generate recommendations based on data and metrics
     * 
     * @param array $data
     * @param array $metrics
     * @return array
     */
    protected function generateRecommendations(array $data, array $metrics): array
    {
        $recommendations = [];
        
        // Revenue recommendations
        if ($metrics['revenue_trend']['value'] < 0) {
            $recommendations[] = [
                'type' => 'warning',
                'priority' => 'high',
                'message' => 'Pendapatan menurun. Fokus pada kampanye pemasaran dan strategi retensi pelanggan.',
            ];
        } elseif ($metrics['revenue_trend']['value'] > 15) {
            $recommendations[] = [
                'type' => 'success',
                'priority' => 'low',
                'message' => 'Pertumbuhan pendapatan yang kuat terdeteksi. Pertimbangkan untuk meningkatkan operasi dan memperluas lini produk.',
            ];
        }
        
        // Profit margin recommendations
        if ($metrics['profit_margin']['value'] < 10) {
            $recommendations[] = [
                'type' => 'warning',
                'priority' => 'high',
                'message' => 'Margin laba rendah. Tinjau strategi penetapan harga dan kurangi biaya operasional.',
            ];
        }
        
        // Collection efficiency recommendations
        if ($metrics['collection_efficiency']['value'] < 75) {
            $recommendations[] = [
                'type' => 'warning',
                'priority' => 'medium',
                'message' => 'Efisiensi penagihan perlu ditingkatkan. Terapkan pengingat pembayaran otomatis dan tinjau syarat kredit.',
            ];
        }
        
        // Stock recommendations
        if ($metrics['stock_health']['value'] < 75) {
            $recommendations[] = [
                'type' => 'warning',
                'priority' => 'medium',
                'message' => 'Beberapa produk stoknya rendah. Tinjau tingkat inventaris dan siapkan pemesanan ulang otomatis.',
            ];
        }
        
        // Trending products recommendations
        $trending = $data['trending_products'] ?? [];
        if (!empty($trending)) {
            $topProduct = $trending[0] ?? null;
            if ($topProduct) {
                $productName = explode(' - ', $topProduct['name'])[0] ?? $topProduct['name'];
                $recommendations[] = [
                    'type' => 'info',
                    'priority' => 'low',
                    'message' => "Produk terlaris: {$productName}. Pertimbangkan untuk menambah stok dan mempromosikan produk serupa.",
                ];
            }
        }
        
        // Sort by priority
        usort($recommendations, function ($a, $b) {
            $priorityOrder = ['high' => 3, 'medium' => 2, 'low' => 1];
            return $priorityOrder[$b['priority']] - $priorityOrder[$a['priority']];
        });
        
        return array_slice($recommendations, 0, 5); // Return top 5
    }

    /**
     * Generate AI summary
     * 
     * @param array $data
     * @param array $metrics
     * @return string
     */
    protected function generateSummary(array $data, array $metrics): string
    {
        $revenueTrend = $metrics['revenue_trend'];
        $profitMargin = $metrics['profit_margin'];
        $collection = $metrics['collection_efficiency'];
        
        $summary = "Ringkasan Performa Bisnis:\n\n";
        
        $summary .= sprintf(
            "Pendapatan %s sebesar %.1f%% dibandingkan periode sebelumnya. ",
            $revenueTrend['direction'] === 'up' ? 'meningkat' : 'menurun',
            abs($revenueTrend['value'])
        );
        
        $profitStatus = $profitMargin['status'] === 'excellent' ? 'sangat baik' 
            : ($profitMargin['status'] === 'good' ? 'baik' 
            : ($profitMargin['status'] === 'fair' ? 'cukup' : 'rendah'));
        $summary .= sprintf(
            "Margin laba berada di %.1f%%, yang menunjukkan kondisi %s. ",
            $profitMargin['value'],
            $profitStatus
        );
        
        $collectionStatus = $collection['status'] === 'excellent' ? 'sangat baik' 
            : ($collection['status'] === 'good' ? 'baik' 
            : ($collection['status'] === 'fair' ? 'cukup' : 'perlu perhatian'));
        $summary .= sprintf(
            "Efisiensi penagihan berada di %.1f%%, menunjukkan manajemen pembayaran yang %s. ",
            $collection['value'],
            $collectionStatus
        );
        
        $trending = $data['trending_products'] ?? [];
        if (!empty($trending)) {
            $topProduct = $trending[0];
            $productName = explode(' - ', $topProduct['name'])[0] ?? $topProduct['name'];
            $summary .= sprintf(
                "Produk terlaris adalah %s dengan %d %s terjual. ",
                $productName,
                $topProduct['quantity_sold'],
                $topProduct['unit'] ?? 'unit'
            );
        }
        
        $summary .= "Secara keseluruhan, bisnis menunjukkan tren " . ($revenueTrend['value'] > 0 ? 'positif' : 'menantang') . " yang memerlukan perhatian strategis.";
        
        return $summary;
    }

    /**
     * Generate detailed analysis
     * 
     * @param array $data
     * @param array $metrics
     * @return array
     */
    protected function generateDetailedAnalysis(array $data, array $metrics): array
    {
        $analysis = [];
        
        // Revenue Performance
        $revenueTrend = $metrics['revenue_trend'];
        $analysis[] = [
            'title' => 'Performa Pendapatan',
            'content' => $this->analyzeRevenue($data, $revenueTrend),
        ];
        
        // Financial Health
        $profitMargin = $metrics['profit_margin'];
        $analysis[] = [
            'title' => 'Kesehatan Keuangan',
            'content' => $this->analyzeFinancialHealth($data, $profitMargin),
        ];
        
        // Inventory Insights
        $stockHealth = $metrics['stock_health'];
        $analysis[] = [
            'title' => 'Wawasan Inventaris',
            'content' => $this->analyzeInventory($data, $stockHealth),
        ];
        
        // Product Performance
        $trending = $data['trending_products'] ?? [];
        $analysis[] = [
            'title' => 'Performa Produk',
            'content' => $this->analyzeProducts($trending),
        ];
        
        return $analysis;
    }

    /**
     * Analyze revenue performance
     */
    protected function analyzeRevenue(array $data, array $revenueTrend): string
    {
        $sales = $data['sales'] ?? [];
        $currentRevenue = $sales['current_period_revenue'] ?? 0;
        
        if ($revenueTrend['value'] > 10) {
            return sprintf(
                "Bisnis Anda menunjukkan pertumbuhan pendapatan yang kuat sebesar %.1f%% dibandingkan periode sebelumnya. Pendapatan saat ini mencapai %s. Ini menunjukkan performa pasar yang sangat baik dan strategi penjualan yang efektif. Pertimbangkan untuk mempertahankan momentum ini melalui upaya pemasaran yang berkelanjutan.",
                $revenueTrend['value'],
                number_format($currentRevenue, 2)
            );
        } elseif ($revenueTrend['value'] > 0) {
            return sprintf(
                "Pendapatan tumbuh stabil sebesar %.1f%%. Meskipun ini positif, masih ada ruang untuk percepatan. Tinjau saluran penjualan dan strategi akuisisi pelanggan Anda untuk meningkatkan pertumbuhan lebih lanjut.",
                $revenueTrend['value']
            );
        } else {
            return sprintf(
                "Pendapatan telah menurun sebesar %.1f%%. Ini memerlukan perhatian segera. Analisis data penjualan, umpan balik pelanggan, dan kondisi pasar. Pertimbangkan kampanye promosi, diversifikasi produk, atau penyesuaian harga.",
                abs($revenueTrend['value'])
            );
        }
    }

    /**
     * Analyze financial health
     */
    protected function analyzeFinancialHealth(array $data, array $profitMargin): string
    {
        $margin = $profitMargin['value'];
        
        if ($margin >= 25) {
            return sprintf(
                "Margin laba yang sangat baik sebesar %.1f%% menunjukkan kesehatan keuangan yang kuat. Strategi penetapan harga dan manajemen biaya Anda berjalan dengan baik. Pertimbangkan untuk menginvestasikan kembali laba dalam peluang pertumbuhan atau memperluas lini produk yang sukses.",
                $margin
            );
        } elseif ($margin >= 15) {
            return sprintf(
                "Margin laba yang baik sebesar %.1f%% menunjukkan operasi yang sehat. Lanjutkan memantau biaya dan harga untuk mempertahankan atau meningkatkan level ini. Cari peluang untuk mengoptimalkan efisiensi operasional.",
                $margin
            );
        } else {
            return sprintf(
                "Margin laba sebesar %.1f%% berada di bawah level optimal. Tinjau strategi penetapan harga, biaya supplier, dan pengeluaran operasional. Pertimbangkan untuk menegosiasikan syarat supplier yang lebih baik, mengurangi pemborosan, atau menyesuaikan harga produk.",
                $margin
            );
        }
    }

    /**
     * Analyze inventory
     */
    protected function analyzeInventory(array $data, array $stockHealth): string
    {
        $lowStockCount = $data['low_stock_count'] ?? 0;
        $score = $stockHealth['value'];
        
        if ($score >= 90) {
            return "Tingkat inventaris sangat baik dengan minimal peringatan stok. Manajemen inventaris Anda sudah dioptimalkan dengan baik. Lanjutkan pemantauan untuk mencegah kehabisan stok dan mempertahankan level ini.";
        } elseif ($score >= 75) {
            return sprintf(
                "Kesehatan inventaris baik, namun %d produk stoknya rendah. Tinjau item-item ini dan siapkan pemesanan ulang otomatis untuk mencegah kehabisan stok. Pertimbangkan untuk menerapkan inventaris just-in-time untuk item yang cepat bergerak.",
                $lowStockCount
            );
        } else {
            return sprintf(
                "Manajemen inventaris memerlukan perhatian. %d produk berada di bawah level peringatan. Prioritaskan pengisian ulang item-item ini segera untuk menghindari kehilangan penjualan. Tinjau titik pemesanan ulang Anda dan pertimbangkan untuk menerapkan manajemen inventaris otomatis.",
                $lowStockCount
            );
        }
    }

    /**
     * Analyze product performance
     */
    protected function analyzeProducts(array $trending): string
    {
        if (empty($trending)) {
            return "Data performa produk tidak tersedia. Pastikan pelacakan penjualan dikonfigurasi dengan benar untuk mendapatkan wawasan tentang produk berkinerja terbaik.";
        }
        
        $topProducts = array_slice($trending, 0, 3);
        $productNames = array_map(function ($p) {
            $name = explode(' - ', $p['name'])[0] ?? $p['name'];
            return $name;
        }, $topProducts);
        
        $summary = "Produk berkinerja terbaik: " . implode(', ', $productNames) . ". ";
        
        if (count($trending) > 3) {
            $summary .= "Produk-produk ini mendorong penjualan yang signifikan. Pertimbangkan untuk meningkatkan level stok, mempromosikan produk serupa, dan menganalisis apa yang membuat produk-produk ini sukses untuk mereplikasi kesuksesan mereka.";
        } else {
            $summary .= "Fokus pada mempertahankan level stok dan kepuasan pelanggan untuk produk-produk kunci ini.";
        }
        
        return $summary;
    }
}

