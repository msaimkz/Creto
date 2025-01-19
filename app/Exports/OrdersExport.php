<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($request)
    {

        $this->request = $request;
    }
    public function view(): View
    {
        $orders = Order::latest('orders.created_at')->select('orders.*', 'users.name', 'users.email')->leftJoin('users', 'users.id', '=', 'orders.user_id');


        if (!empty($this->request->get('keyword'))) {
            $orders->where('users.name', 'like', '%' . $this->request->get('keyword') . '%');
            $orders->orWhere('users.email', 'like', '%' . $this->request->get('keyword') . '%');
            $orders->orWhere('orders.id', 'like', '%' . $this->request->get('keyword') . '%');
            $orders->orWhere('orders.id', 'like', '%' . $this->request->get('keyword') . '%');
            $orders->orWhere('orders.delivery_status', 'like', '%' . $this->request->get('keyword') . '%');
        }

        return view('Excel.order', [
            'orders' => $orders->get()
        ]);
    }
}
