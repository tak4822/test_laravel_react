<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems')->paginate();
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $orders = Order::with('orderItems')->find($id);
        return new OrderResource($orders);
    }

    public function export()
    {
        $header = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=order.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function() {
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);

            foreach($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach($order->orderItems as $item) {
                    fputcsv($file, ['', '', '', $item->product_title, $item->price, $item->quantity]);
                }
            }

            fclose($file);
        };

        return \Response::stream($callback, 200, $header);
    }

    public function chart()
    {
        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, SUM(order_items.price * order_items.quantity) as sum")
            ->groupBy('date')
            ->get();

        return $orders;
    }
}
