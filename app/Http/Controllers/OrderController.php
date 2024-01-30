<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function submitOrder(Request $request): JsonResponse
    {
        $data = $request->all();
        return response()->json([ 'messageSuccess' => 'ok' ]);
    }
}
