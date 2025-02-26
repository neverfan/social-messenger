<?php

namespace App\Http\Controllers;

use App\Models\Dialog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dialog\SendRequest;
use App\Http\Requests\Dialog\CreateRequest;

class DialogController extends Controller
{
    /**
     * Создать диалог
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $dialog = Dialog::query()->create([
            'user_id' => Session::get('user_id'),
            'users' => $request->get('users'),
        ]);

        return $this->response->success([
            'dialog' => $dialog,
        ]);
    }

    /**
     * Вывести все сообщения диалога
     * @param Dialog $dialog
     * @return JsonResponse
     */
    public function get(Dialog $dialog): JsonResponse
    {
        return $this->response->success([
            'dialog' => $dialog,
            'messages' => $dialog->messages()->orderBy('id', 'desc')->paginate(20),
        ]);
    }

    /**
     * Отправить сообщение в диалог
     * @param SendRequest $request
     * @param Dialog $dialog
     * @return JsonResponse
     */
    public function send(SendRequest $request, Dialog $dialog): JsonResponse
    {
        $message = $dialog->messages()->create([
            'from_user_id' => Session::get('user_id'),
            'to_user_id' => $request->get('to_user_id'),
            'text' => $request->get('message'),
        ]);

        return $this->response->success([
            'message' => $message,
        ]);
    }

    /**
     * Список диалогов пользователя
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $userId = Session::get('user_id');

        return $this->response->success([
            'user_id' => $userId,
            'dialogs' => Dialog::query()->where('user_id', $userId)->get()
        ]);
    }
}
