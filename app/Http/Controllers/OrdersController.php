<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllEntitiesRequest;
use App\Http\Requests\OrderIdRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UserIdRequest;
use App\Http\Resources\HistoryCollection;
use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Routing\Controller;

class OrdersController extends Controller
{
    public function prepare(AllEntitiesRequest $request)
    {
        return response()->json(Order::prepareOrder($request->input()), 200);
    }

    public function add(OrderRequest $request)
    {
        return response()->json(Order::createOrder($request->input()), 200);
    }

    public function history(UserIdRequest $request)
    {
        $orders = Order::where('user_id', $request->userId)->paginate(5);
        if (empty($orders->items())) {
            return response()->json(['message' => 'Заказы для данного пользователя не найдены'], 404);
        }
        return new HistoryCollection($orders);
    }

    public function status(OrderIdRequest $request)
    {
        $order = Order::where('order_id', $request->id)->firstOrFail();
        if (isset($order->status)) {
            return new OrderResource($order);
        }

        if ($error = $order->getStatus()) {
            return new OrderResource($order);
        }
        return $error;
    }
}
