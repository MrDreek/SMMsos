<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllEntitiesRequest;
use App\Http\Requests\OrderAnotherIdRequest;
use App\Http\Requests\OrderIdRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UserIdRequest;
use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;

class OrdersController extends Controller
{
    public function checkPaid($id)
    {
        $order = Order::where('_id', $id)->orWhere('order_id', (int)$id)->firstOrFail();

        return response()->json($order->checkPaid(), 200);
    }

    public function beforeAdd(OrderRequest $request)
    {
        return response()->json(Order::beforeOrderCheck($request->input()), 200);
    }

    public function prepare(AllEntitiesRequest $request)
    {
        return response()->json(Order::prepareOrder($request->input()), 200);
    }

    public function add(OrderAnotherIdRequest $request)
    {
        return response()->json(Order::createOrder($request->input()), 200);
    }

    public function history(UserIdRequest $request)
    {
        $orders = Order::where('user_id', $request->userId)->orderBy('_id', 'desc')->paginate(10);
        if (empty($orders->items())) {
            return response()->json(['message' => 'Заказы для данного пользователя не найдены'], 404);
        }

        /** @var Order $order */
        foreach ($orders as $order) {
            $statusCheck = $order->getStatus();
            if (\is_array($statusCheck)) {
                return $statusCheck;
            }
        }

        $paginate = $orders->sortBy('_id');
        $paginate = new LengthAwarePaginator($paginate, $orders->total(), $orders->perPage());

        return OrderResource::collection($paginate);
    }

    public function status(OrderIdRequest $request)
    {
        $order = Order::where('order_id', $request->id)->firstOrFail();
        if ($order->status !== 4) {
            return new OrderResource($order);
        }

        if ($error = $order->getStatus()) {
            return new OrderResource($order);
        }
        return $error;
    }
}
