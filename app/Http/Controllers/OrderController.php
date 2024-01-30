<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;
use App\Models\Order;

class OrderController extends Controller
{
    public function submitOrder(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'max:128'],
            'email' => ['required', 'max:50', 'email'],
            'message' => ['required', 'max:512'],
        ]);
        if (Order::where('name', $request->name)->where('email', $request->email)->where('message', $request->message)->count()) {
            return response()->json(['messageError' => 'Такая запись уже существует'], 422);
        }
        Order::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return response()->json(['messageSuccess' => 'Заявка создана! Ожидайте ответа']);
    }
}
