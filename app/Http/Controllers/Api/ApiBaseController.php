<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiBaseController extends Controller
{
    protected $clientMessage = 'Whoops, something went wrong on our servers.';

    /**
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    protected function sendSuccess($result = null, $message = null): JsonResponse
    {
        $response = [
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * @param $code
     * @param $message
     * @param $status
     * @param $logLevel
     * @return JsonResponse
     */
    protected function sendError($code, $message, $status, $clientMessage = null, $logLevel = LogLevel::ERROR): JsonResponse
    {
        // Log context
        $context = $this->getContext($code);

        if ($logLevel == LogLevel::DEBUG) {
            Log::debug($message, $context);
        } elseif ($logLevel == LogLevel::INFO) {
            Log::info($message, $context);
        } elseif ($logLevel == LogLevel::WARNING) {
            Log::warning($message, $context);
        } elseif ($logLevel == LogLevel::ERROR) {
            Log::error($message, $context);
        } elseif ($logLevel == LogLevel::ALERT) {
            Log::alert($message, $context);
        }

        if (!$clientMessage) $clientMessage = $this->clientMessage;

        $response = [
            'code' => $code,
            'message' => $message,
            'errors' => [
                'clientMessage' => [$clientMessage],
            ],
        ];

        return response()->json($response, $status);
    }

    /**
     * Get log context.
     *
     * @param $code
     * @return array
     */
    private function getContext($code = null): array
    {
        if ($code) {
            return [
                'code' => $code,
                'user_id' => Auth::check() ? Auth::user()->id : null,
                'input' => request()->all(),
            ];
        }

        return [
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'input' => request()->all(),
        ];
    }
}
