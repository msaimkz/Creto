<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\product;
use App\Models\Category;
use App\Models\brand;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\news;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\tempimage;
use App\Models\Wishlist;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

    public function dashboard()
    {

        $orders = Order::where('delivery_status', '!=', "cancelled")->count();
        $products = product::where('status',1)->count();
        $users = User::where('role', 0)->count();

        // Total Revenue 

        $totalReveneu =  Order::where('delivery_status', '!=', "cancelled")->sum('grand_total');


        // Reveneu This month 

        $currentdate = Carbon::now()->format('Y-m-d');
        $thismonthstartDate = Carbon::now()->startOfMonth()->format('Y-m-d');


        $Reveneuthismonth = Order::where('delivery_status', '!=', "cancelled")
            ->whereDate('created_at', '>=', $thismonthstartDate)
            ->whereDate('created_at', '<=', $currentdate)
            ->sum('grand_total');

        // Reveneu last month

        $lastmonthstartdate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastmonthenddate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastmonth = Carbon::now()->subMonth()->endOfMonth()->format('M');

        $Reveneulastmonth = Order::where('delivery_status', '!=', "cancelled")
            ->whereDate('created_at', '>=', $lastmonthstartdate)
            ->whereDate('created_at', '<=', $lastmonthenddate)
            ->sum('grand_total');



        // Reveneu last 30 days 

        $lastthirtydaysdate = Carbon::now()->subDay(30)->format('Y-m-d');

        $ReveneulastThirtyDays = Order::where('delivery_status', '!=', "cancelled")
            ->whereDate('created_at', '>=', $lastthirtydaysdate)
            ->whereDate('created_at', '<=', $currentdate)
            ->sum('grand_total');


        //  Get Categories
        
        $categories = Category::where('status',1)->get();

        // Delete Temp images here

        $lastBeforeDate = Carbon::now()->subDay(1)->format('Y-m-d H:i:s');
        $tempImages = tempimage::where('created_at', '<=', $lastBeforeDate)->get();

        foreach ($tempImages as $tempImage) {

            $path = public_path('/temp/' . $tempImage->image);
            $Thumbpath = public_path('/temp/thumb/' . $tempImage->image);




            if (File::exists($path)) {
                File::delete($path);
            }

            // Thmb Images Delete Here

            if (File::exists($Thumbpath)) {
                File::delete($Thumbpath);
            }
            tempimage::where('id', $tempImage->id)->delete();
        }


        return view("Admin.dashboard", compact(
            'orders',
            'products',
            'users',
            'totalReveneu',
            'Reveneuthismonth',
            'Reveneulastmonth',
            'lastmonth',
            'ReveneulastThirtyDays',
            'categories'

        ));
    }


    public function category(Request $request)
    {

        $categories = Category::orderby('id', 'ASC');
        if (!empty($request->keyword)) {
            $categories->where('slug', 'like', '%' . $request->keyword . '%');
        }
        $categories = $categories->paginate(10);
        return view("Admin.category.category", compact('categories'));
    }





    public function brand(Request $request)
    {
        $brands = brand::orderby('id', 'ASC');
        if (!empty($request->keyword)) {
            $brands->where('name', 'like', '%' . $request->keyword . '%');
        }
        $brands = $brands->paginate(10);
        return view("Admin.brand.brand", compact('brands'));
    }


    public function product(Request $request)
    {
        $products = product::with('image');
        if (!empty($request->keyword)) {
            $products->where('title', 'like', '%' . $request->keyword . '%');
            $products->orWhere('sku', 'like', '%' . $request->keyword . '%');    
        }
        $products = $products->paginate(8);
        return view("Admin.product.product", compact('products'));
    }


    public function order(Request $request)
    {


        $orders = Order::latest('orders.created_at')->select('orders.*', 'users.name', 'users.email')->leftJoin('users', 'users.id', '=', 'orders.user_id');
        if (!empty($request->keyword)) {
            $orders->where('users.name', 'like', '%' . $request->keyword . '%');
            $orders->orWhere('users.email', 'like', '%' . $request->keyword . '%');
            $orders->orWhere('orders.id', 'like', '%' . $request->keyword . '%');
            $orders->orWhere('orders.id', 'like', '%' . $request->keyword . '%');
            $orders->orWhere('orders.delivery_status', 'like', '%' . $request->keyword . '%');
        }



        $orders = $orders->paginate(8);


        return view("Admin.order.order", compact('orders'));
    }

    public function OrderDetail(Request $request, $id)
    {

        $order = Order::find($id);
        $items = OrderItem::where('order_id', $id)->get();

        return view('Admin.order.order-detail', compact('order', 'items'));
    }

    public function discount(Request $request)
    {

        $coupons = Coupon::latest();
        if (!empty($request->keyword)) {
            $coupons->where('title', 'like', '%' . $request->keyword . '%');
        }
        $coupons = $coupons->paginate(8);

        return view("Admin.discount.discount", compact('coupons'));
    }

    public function user(Request $request)
    {

        $users = User::where('role', 0)->latest('users.created_at')->select('users.*', 'customer_details.mobile', 'customer_details.country_id')
            ->leftJoin('customer_details', 'users.id', '=', 'customer_details.user_id');

        if (!empty($request->keyword)) {
            $users = $users->where('users.name', 'like', '%' . $request->keyword . '%');
            $users = $users->orWhere('users.email', 'like', '%' . $request->keyword . '%');


        }



        $users = $users->paginate(8);

        return view("Admin.user", compact('users'));
    }



    public function news(Request $request)
    {

        $News = news::orderby('id', 'ASC');
        if (!empty($request->keyword)) {
            $News->where('title', 'like', '%' . $request->keyword . '%');
            $News->orWhere('writer', 'like', '%' . $request->keyword . '%');
        }

        $News = $News->paginate(10);
        return view("Admin.news.news", compact('News'));
    }

    public function DeleteUser(Request $request, $id)

    {
        $user = User::where('role', 0)->where('id', $id)->first();
        if (empty($user)) {

            $request->session()->flash('error', 'User Not Found');

            return response()->json([
                'status' => true,
                'msg' => 'User Not Found'
            ]);
        }

        $user->delete();

        $request->session()->flash('success', 'User Deleted Successfully');

        return response()->json([
            'status' => true,
            'msg' => 'User Deleted Successfully'
        ]);
    }


    public function wishlist(Request $request){


        $wishlists = Wishlist::latest('wishlists.created_at')
        ->select('wishlists.*', 'products.title', 'users.name','users.email')
        ->leftJoin('products', 'products.id', '=', 'wishlists.product_id')
        ->leftJoin('users', 'users.id', '=', 'wishlists.user_id');


        if (!empty($request->keyword)) {
            $wishlists->where('users.name', 'like', '%' . $request->keyword . '%');
            $wishlists->orWhere('users.email', 'like', '%' . $request->keyword . '%');
            $wishlists->orWhere('products.title', 'like', '%' . $request->keyword . '%');
        }
        

        $wishlists = $wishlists->paginate(8);

       return view('Admin.wishlist.wishlist',compact('wishlists'));

    }

    public function contact(Request $request){
        $contacts = Contact::latest('contacts.created_at');

        if (!empty($request->keyword)) {
            $contacts->where('name', 'like', '%' . $request->keyword . '%');
            $contacts->orWhere('email', 'like', '%' . $request->keyword . '%');
           
        }


        $contacts = $contacts->paginate(8);

        return view('Admin.contact.contact',compact('contacts'));
    }

    
    public function contactDetail(Request $request , $id){
  
        $contact = Contact::find($id);
 

        if(empty($contact)){

            $error = "Contact Email Not Found";
            $request->session()->flash('error',$error);
            return redirect()->route('Admin-contact');
        }

        return view('Admin.contact.contact-detail',compact('contact'));
    }

    public function deleteContact(Request $request,$id){
        
        $contact = Contact::find($id);
 

        if(empty($contact)){

            $error = "Contact Email Not Found";
    
            $request->session()->flash('error',$error);
              
            return response()->json([
            'status' => false,
            'msg' => $error,
            ]);
    
           }
    
           $contact->delete();
    
    
    
           $status = true;
            $message = "Contact Email Delete Successfully";
    
           $request->session()->flash('success',$message);
    
    
    
         return response()->json([
            'status' => $status,
            'msg' => $message
         ]);

    }
}
