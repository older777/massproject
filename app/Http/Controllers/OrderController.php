<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    /**
     * Запись заявки
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function submitOrder(Request $request): JsonResponse
    {
        $request->validate([
            'name' => [
                'required',
                'max:128'
            ],
            'email' => [
                'required',
                'max:50',
                'email'
            ],
            'message' => [
                'required',
                'max:512'
            ]
        ]);
        if (Order::where('name', $request->name)->where('email', $request->email)
            ->where('message', $request->message)
            ->count()) {
            return response()->json([
                'messageError' => 'Такая запись уже существует'
            ], 422);
        }
        Order::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);
        return response()->json([
            'messageSuccess' => 'Заявка создана! Ожидайте ответа'
        ]);
    }

    /**
     * Обработка REST запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function orderProcess(Request $request): JsonResponse
    {
        $request->validate([
            'id' => [
                'required',
                'integer'
            ],
            'status' => [
                'required',
                'bool'
            ],
            'comment' => [
                'required',
                'max:512'
            ]
        ]);
        if ($request->status == 0) {
            return response()->json([
                'messageError' => 'Ошибка! Установите статус!'
            ]);
        }
        $order = Order::where('id', $request->id)->first();
        Mail::send('emails.response', [
            'msg' => $order->message,
            'comment' => $request->comment
        ], function ($mail) use ($order) {
            $mail->from(env('MAIL_FROM_ADDRESS'), 'Администрация сайта');
            $mail->to($order->email, $order->name)->subject('Ответ на запрос!');
        });
        $order->update([
            'status' => 'Resolved',
            'comment' => $request->comment
        ]);
        return response()->json([
            'messageSuccess' => 'Ответ отправлен'
        ]);
    }
}
