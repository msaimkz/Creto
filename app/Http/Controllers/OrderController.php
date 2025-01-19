<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Country;
use App\Models\OrderItem;
use App\Models\product;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function ChangrStatus(Request $request, $id)
    {


        $order = Order::find($id);



        $order->delivery_status = $request->status;
        $order->shipping_date = $request->shipping_date;
        $order->save();

        $message = "Order Status Changed Successfully";

        $request->session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'msg' => $message,
        ]);
    }

    public function SendInvioceEmail(Request $request, $id)
    {

        OrderEmail($id, $request->userType);


        $message = "Order Email Sent Successfully";

        $request->session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'msg' => $message,
        ]);
    }

    
 public function getproducts(Request $request){


    $product_id = $request->product_id;
    $orderid = $request->orderID;

    

    if($product_id != null){

        $OrderItems = OrderItem::where('order_id',$orderid)->whereIn('product_id',$product_id)->get(); 
        session()->put('orderItems', $OrderItems);
        session()->put('productId', $product_id);

        
       return  response()->json([
        'status' => true,
        'products' => $OrderItems,

       ]);
       
    }

    else{
        return  response()->json([
            'status' => false,
            'msg' => 'Product Not Found',
    
           ]);

    }

   
    
  
 } 



 public function getexchangeproduct(Request $request){

   $productID = $request->product_id;
   $itemId= $request->item_id;

   
   $product =  product::where('status',1)->find($productID);

    
   $qty = 1;
   $total = $product->price * $qty;

   return response()->json([
    'status' => true,
    'price' => number_format($product->price,2),
    'total' => number_format($total,2),
    'qty' => $qty,
    'itemId' => $itemId,
   ]);


 }

    public function ExchangeOrder(Request $request, $id)
    {
       
      $order = Order::find($id);
        if(empty($order)){ 
            return redirect()->route('Page-Error');
        }

        $countries = Country::orderBy('name', 'ASC')->get();
        $orderItemsCount = OrderItem::where('order_id', $order->id)->count();
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $products = Product::where('status', 1)
        ->where('qty', '>', 0)
        ->get();




        return view('User.exchange',compact('order','countries','orderItemsCount','orderItems','products'));
    }
}
