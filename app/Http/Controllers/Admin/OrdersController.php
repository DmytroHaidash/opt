<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\DataTables;
use Illuminate\Contracts\View\View;

class OrdersController extends Controller
{
    public function index(): View
    {
        $orders = (new DataTables(Order::withCount('carts')))
            ->add('buyer.name', __('admin.orders.fields.buyer'))
            ->add('carts_count', __('admin.orders.fields.carts_count'))
            ->add('total', __('admin.orders.fields.total'))
            ->add('created_at', __('admin.fields.created_at'))
            ->paginate();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', compact('order'));
    }
}
