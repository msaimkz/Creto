<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Country;
use App\Models\OrderItem;
use App\Models\product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{


    public function ChangrStatus(Request $request, $id)
    {

        $rules = [
            'status' => 'required|string',
            'shipping_date' => ['sometimes'], 
        ];

        
        if ($request->status !== 'pending') {
            $rules['shipping_date'][] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, [
            'shipping_date.required' => 'The  date is required when the order status is not pending.',
        ]);

        if ($validator->passes()) {
            $order = Order::find($id);
            $order->delivery_status = $request->status;
            $order->shipping_date = $request->shipping_date;
            $order->save();

            $message = "Order Status Changed Successfully";

            return response()->json([
                'status' => true,
                'orderStatus' => $order->delivery_status,
                'date' => Carbon::parse($request->shipping_date)->format('d M, Y'),
                'msg' => $message,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function SendInvioceEmail(Request $request, $id)
    {

        OrderEmail($id, $request->userType);


        $message = "Order Email Sent Successfully";


        return response()->json([
            'status' => true,
            'msg' => $message,
        ]);
    }


    public function getproducts(Request $request)
    {


        $product_id = $request->product_id;
        $orderid = $request->orderID;



        if ($product_id != null) {

            $OrderItems = OrderItem::where('order_id', $orderid)->whereIn('product_id', $product_id)->get();
            session()->put('orderItems', $OrderItems);
            session()->put('productId', $product_id);


            return  response()->json([
                'status' => true,
                'products' => $OrderItems,

            ]);
        } else {
            return  response()->json([
                'status' => false,
                'msg' => 'Product Not Found',

            ]);
        }
    }
}
