<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Order;
use App\Models\CustomerDetail;
use App\Models\productimage;
use App\Models\news;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Rating;
use App\Models\ShippingCharge;
use App\Models\Service;
use App\Models\Coupon;
use App\Models\Feedback;
use App\Models\Team;
use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


use Svg\Tag\Rect;

class UserController extends Controller
{
    public function home(Request $request, $categorySlug = null)
    {
        $categoryID = '';
        $categories = Category::where('status', 1)->limit(3)->get();
        $services = Service::where('status', 1)->limit(3)->get();
        $coupon = Coupon::latest()->where('status', 1)
            ->where('start_at', '<=', Carbon::now())
            ->where('expire_at', '>=', Carbon::now())
            ->first();




        $products = Product::where('status', 1)->where("is_featured", "Yes");
        $TopProducts = Product::where('status', 1)->limit(4)->get();
        $news = news::where('status', 1)->where("is_Home", "Yes")->get();



        // Feedbacks 

        $feedbacks = Feedback::where('status', 1)->get();


        // category filter
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $categoryID = $category->id;
                $products->where('category_id', $category->id);
            }
        }
        $products = $products->get();

        return view('User.index', compact("categories", "products", "categoryID", "TopProducts", "news", "services", "coupon", 'feedbacks'));
    }
    public function service()
    {
        $TopProducts = Product::where('status', 1)->limit(4)->get();
        $services = Service::where('status', 1)->get();
        $feedbacks = Feedback::where('status', 1)->get();


        return view('User.service', compact('TopProducts', "services", "feedbacks"));
    }
    public function shop(Request $request, $categorySlug = null)
    {
        $categories = Category::where('status', 1)->limit(5)->get();
        $brands = brand::where('status', 1)->limit(5)->get();
        $categoryID = '';
        $brandArray = [];
        $genderArray = [];

        $products = Product::where('status', 1);





        // category filter
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $categoryID = $category->id;
            if ($category) {
                $products->where('category_id', $category->id);
            }
        }


        // brand filter 
        if (!empty($request->get('brands'))) {
            $brandArray = explode(',', $request->get('brands'));
            $products->whereIn('brand_id', $brandArray);
        }

        // gender filter 
        if (!empty($request->get('gender'))) {
            $genderArray = explode(',', $request->get('gender'));
            $products->whereIn('gender', $genderArray);
        }
        // price filter

        if ($request->get('price_min') != "" && $request->get('price_max') != "") {
            if ($request->get('price_max') == 10000) {
                $products->whereBetween('price', [intval($request->get('price_min')), 1000000]);
            } else {
                $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
            }
        }

        // Sort filter
        if ($request->get('sort')) {
            if ($request->get('sort') == "latest") {
                $products->orderBy('id', 'DESC');
            } else if ($request->get('sort') == "price_desc") {
                $products->orderBy('price', 'DESC');
            } else {
                $products->orderBy('price', 'ASC');
            }
        }

        // Fetch the results
        $products = $products->paginate(6);

        $sort = $request->get('sort');
        $pricemax = (intval($request->get('price_max')) == 0) ? 10000 : intval($request->get('price_max'));
        $pricemin = intval($request->get('price_min'));
        return view('User.shop', compact('categories', 'sort', 'brands', 'products', 'categoryID', 'brandArray', 'pricemin', 'pricemax', "genderArray"));
    }


    public function gallery()
    {
        return view('User.gallery');
    }


    public function about()
    {


        $members = Team::where('status', 1)->get();
        $customers = User::where('role', 0)->count();
        $orders = Order::where('delivery_status', 'delivered')->count();
        $products = product::where('status', 1)->count();
        $brands = brand::where('status', 1)->count();
        $feedbacks = Feedback::where('status', 1)->get();

        return view('User.about', compact('members', 'customers', 'orders', 'products', 'brands', 'feedbacks'));
    }

    public function contact()
    {
        return view('User.contact');
    }


    public function Product(string $slug)
    {
        $product = Product::where(['slug' =>  $slug , 'status' => 1 ])->first();

        if (empty($product)) {

            return redirect()->route('Page-Error');
        }

        $relatedProducts = [];

        if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);

            $relatedProducts = product::whereIn('id', $productArray)->get();
        }

        // Rating  Here

        $ratings = Rating::where(['product_id' => $product->id, 'status' => 1])->get();

        return view('User.productDetail', compact("product", "relatedProducts", "ratings"));
    }



    public function Cart()
    {
        $cartItems = Cart::content();
        return view('User.cart', compact("cartItems"));
    }


    public function Wishlist()
    {

        $user = Auth::user();

        $wishlists = Wishlist::where("user_id", $user->id)->with('product')->get();



        return view('User.wishlist', compact('wishlists'));
    }


    public function Checkout()
    {

        if (Cart::count() == 0) {
            return redirect()->route('Cart');
        }

        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('login');
        }

        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();

        $Customers = CustomerDetail::where('user_id', Auth::user()->id)->first();

        $total = 0;
        $discount = 0;
        $subtotal = Cart::subtotal(2, '.', '');
        $shippingcharges = 0;
        $grandtotal = $subtotal;
        // Calulate discount here

        if (session()->has('code')) {

            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $subtotal;
            } else {
                $discount = $code->discount_amount;
            }
        }

        if (!empty($Customers)) {
            $shippinginfo = ShippingCharge::where('country_id', $Customers->country_id)->first();
            foreach (Cart::content() as $item) {
                $total += $item->qty;
            }

            if ($shippinginfo != null) {

                $shippingcharges = $shippinginfo->amount * $total;
              
            } else {

                $shipping = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $shippingcharges = $shipping->amount * $total;
            }
        }

        $grandtotal = ($subtotal - $discount)  + $shippingcharges;

        return view('User.checkout', compact('countries', 'Customers', 'shippingcharges', 'grandtotal', 'discount'));
    }


    public function Order()
    {


        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(12);

        return view("User.orders", compact('orders'));
    }


    public function OrderDetail($orderId)
    {

        $order = Order::where(['id' => $orderId, 'user_id' => Auth::id()])->first();


        if (empty($order)) {

            return redirect()->route('Page-Error');
        }

        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $orderCounts = OrderItem::where('order_id', $orderId)->count();

        return view("User.order-detail", compact('order', 'orderItems', 'orderCounts'));
    }


    public function BlogDetail(Request $request, $id)
    {

        $news = news::find($id);


        if (empty($news)) {
            return redirect()->route('Page-Error');
        }

        return view("User.blog-detail", compact('news'));
    }


    public function News()
    {
        $news = news::where('status', 1)->get();
        return view("User.blog", compact('news'));
    }

    public function SendContactEmal(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|regex:/^0[3-9][0-9]{2}[0-9]{7}$/',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]);



        if ($validator->passes()) {

            if (Auth::check() == false) {
                return response()->json([

                    'isLogin' => false,
                    'msg' => 'Send Contact Email to first Sign in',
                ]);
            }

            $user = Auth::user();

            $maildata = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
                'subject' => 'You have a Contant Email'
            ];

            $admin = User::where('role', 1)->first();

            $contact = new Contact();
            $contact->user_id = $user->id;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            $contact->save();

            Mail::to($admin->email)->send(new ContactEmail($maildata));

            $request->session()->flash('success', 'Your Message Send Succesfully');
            return response()->json([
                'status' => true,
                'msg' => 'Your Message Send Succesfully',

            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Please Fix the Errors',
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function DownloadPDF(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->with('items')->first();
        $data['order'] = $order;


        $pdf = Pdf::loadView('pdf.order', $data)->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('order.pdf');
    }

    public function OrderCancel(Request $request, $orderId)
    {

        $order = Order::find($orderId);


        if (empty($order)) {
            $request->session()->flash('error', 'Order Not Found');
            return response()->json([
                'status' => false,
                'msg' => 'Order Not Found',

            ]);
        }

        $order->delivery_status = 'cancelled';
        $order->save();


        $request->session()->flash('success', 'Order Cancel Successfully');

        return response()->json([
            'status' => true,
            'msg' => 'success',
            'Order Cancel Successfully',

        ]);
    }



    public function PageError()
    {
        return view('User.404');
    }

    public function Thanks(Request $request, $orderid)
    {
        $orderId = $orderid;
        return view('User.Thanks', compact('orderId'));
    }

    public function serviceDetail(Request $request, $slug)
    {

        $service = Service::where('slug', $slug)->first();


        if (empty($service)) {
            return redirect()->route('Page-Error');
        }

        return view("User.service-detail", compact('service'));
    }
}
