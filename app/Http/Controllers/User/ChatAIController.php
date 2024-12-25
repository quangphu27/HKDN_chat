<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatAIController extends Controller
{
    //

    public function __invoke(Request $request): string
    {

        try {
            /** @var array $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/json"
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . config('services.genmini.key'), [
                "contents" => [
                    [
                        "parts" => [
                            [
                                "text" => $request->post('content')
                            ]
                        ]
                    ]
                ]
            ])->json();

            if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {

                return $response['candidates'][0]['content']['parts'][0]['text'];  // Trả về nội dung văn bản từ phản hồi
            } else {
                
                return "Không có phản hồi hợp lệ từ API.";
            }
        } catch (Throwable $e) {
            return "Đã xảy ra lỗi: " . $e->getMessage();
        }
    }
}
