<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Ticket\Channel;
use App\Enums\Ticket\Status;
use App\Models\Category;
use App\Models\User;
use App\Services\Ticket\CreateTicketDTO;
use App\Services\Ticket\TicketService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class TelegramController extends Controller
{
    public function handle(Request $request, TicketService $service): JsonResponse
    {
        $update = $request->all();
        $chatId = $update['message']['chat']['id'] ?? $update['callback_query']['message']['chat']['id'] ?? null;
        $message = $update['message']['text'] ?? null;

        if ($message) {
            if (\Str::startsWith($message, '/start')) {
                $parts = explode(' ', $message);
                $userId = $parts[1] ?? null;

                if (!$userId) {
                    $this->sendMessage($chatId, 'Please, auth in website first!');
                    return response()->json();
                }

                try {
                    // bind user and their telegram
                    $user = User::findOrFail($userId);
                    $user->telegram_chat_id = $update['message']['chat']['id'];
                    $user->save();
                } catch (ModelNotFoundException) {
                    $this->sendMessage($chatId, 'Please, auth in website first!');
                    return response()->json();
                }

                $this->sendCategorySelectionResponse($chatId);
                return response()->json();
            }

            if ($message === 'hello') {
                try {
                    $user = $this->getUserByChatId($chatId);
                    $this->sendCategorySelectionResponse($user->telegram_user_id);
                } catch (ModelNotFoundException) {
                    $this->sendMessage($chatId, 'Please, auth in website first!');
                    return response()->json();
                }
            }

            $state = Cache::get('tg_state_' . $chatId);
            if ($state['status'] === 'entering_subject') {
                Cache::put('tg_state_' . $chatId, [
                    ...$state,
                    'subject' => $message,
                    'state' => 'entering_message',
                ]);
            }

            if ($state['status'] === 'entering_message') {
                try {
                    $service->create(CreateTicketDTO::fromTelegram([
                        $state['category_id'],
                        $state['subject'],
                        $state['message'],
                        $this->getUserByChatId($chatId)->id,
                    ]));
                    Cache::forget('tg_state_' . $chatId);
                } catch (ModelNotFoundException) {
                    $this->sendMessage($chatId, 'Please, auth in website first!');
                    return response()->json();
                } catch (\Exception) {
                    $this->sendMessage($chatId, 'Something went wrong, please, retry again!');
                } finally {
                    return response()->json();
                }
            }

            $this->sendCategorySelectionResponse($chatId);
            return response()->json();
        }

        if (isset($update['callback_query'])) {
            $this->handleCategorySelection($chatId, $update['callback_query']['data']);
        }

        return response()->json();
    }

    private function sendCategorySelectionResponse($chatId): void
    {
        $categories = Category::all();
        $keyboard = [
            'inline_keyboard' => $categories->map(fn(Category $category) => [
                'text' => $category->name,
                'callback_data' => $category->id
            ]
            )->toArray()
        ];

        $this->sendMessage($chatId, 'Please select a category:', [
            'reply_markup' => json_encode($keyboard)
        ]);

        \Cache::put('tg_state_' . $chatId, [
            'state' => 'selecting_category',
        ]);
    }

    private function handleCategorySelection($chatId, $categoryId): void
    {
        $category = Category::first($categoryId);

        if (!$category) {
            Cache::forget('tg_state_' . $chatId);
            $this->sendMessage($chatId, 'Send "hello" to start again!');
            return;
        }

        $this->sendMessage($chatId, 'Plesase,️ enter a subject (max 2000 characters):');

        Cache::put('tg_state_' . $chatId, [
            'state' => 'entering_subject',
            'category_id' => $categoryId,
        ]);
    }

    private function sendMessage($chatId, $text, $extra = [])
    {
        \Http::post('https://api.telegram.org/bot'.config('telegram.bot_token').'/sendMessage', array_merge([
            'chat_id' => $chatId,
            'text' => $text,
        ], $extra));
    }

    private function getUserByChatId($chatId): ?User
    {
        return User::where('telegram_user_id', $chatId)->firstOrFail();
    }
}
