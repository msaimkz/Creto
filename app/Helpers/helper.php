<?php

use App\Mail\OrderEmail;
use App\Models\Country;
use App\Models\Order;
use App\Models\product;
use App\Models\productimage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

function ProductImage($id){

    return productimage::where('product_id',$id)->first();
}
function GetProducts($id){

 return product::where(['status' => 1 , 'category_id' => $id])->count();

}

function Profileimg($id){

    $user =  User::find($id);

    return $user->profile_img;
}

function country($id){
    return Country::find($id);;
}

function OrderEmail($orderId,$userType = 'customer'){

    $order = Order::where('id',$orderId)->with('items')->first();

    if($userType == 'customer'){
       $subject = 'Thank For Your Order';
       $email = $order->email;
    }
    else{

        $admin = User::where('role',1)->first();
        $subject = 'You have Recived an Order';
        $email = $admin->email;
    }


    $maildata = [
        'subject' => $subject,
        'order' => $order,
    ];

    Mail::to($email)->send( new OrderEmail($maildata));

    
}
?>


