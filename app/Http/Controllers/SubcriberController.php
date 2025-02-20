<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeMail;
use App\Models\Coupon;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubcriberController extends Controller
{

    public function index(Request $request)
    {
        $subcribers = Subscriber::latest('subscribers.created_at')->select('subscribers.*', 'users.name')->leftJoin('users', 'users.id', '=', 'subscribers.user_id');
        if (!empty($request->keyword)) {
            $subcribers->where('users.name', 'like', '%' . $request->keyword . '%');
            $subcribers->orWhere('subscribers.email', 'like', '%' . $request->keyword . '%');
        }
        $subcribers = $subcribers->paginate(8);

        return view('Admin.Subscriber.subscriber', compact('subcribers'));
    }


    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->passes()) {

            if (Auth::check() == false) {

                return response()->json([
                    'isLogin' => false,
                    'msg' => 'Add Email In Subscriber Person to first Sign in',
                ]);
            }
    
    
    
    
    
            $user = Auth::user();

            Subscriber::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'user_id' => $user->id,
                    'email' => $request->email,
                ]


            );

            $message = 'Your Email Add Succesfully in Subscriber Member';


            return response()->json([
                'status' => true,
                'msg' => $message
            ]);
        }
        else{

            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);

        }
    }


    public function show(Request $request, string $id)
    {

        $subscriber = Subscriber::where('subscribers.id', $id)->select('subscribers.*', 'users.name')->leftJoin('users', 'users.id', '=', 'subscribers.user_id')->first();

        if (empty($subscriber)) {

            $request->session()->flash('error', 'Subscriber Not Found');

            return redirect()->route('Subscribers');
        }



        $coupons = Coupon::latest()->where('status', 1)
            ->where('start_at', '<=', Carbon::now())
            ->where('expire_at', '>=', Carbon::now())
            ->get();

        return view('Admin.Subscriber.subscriber-detail', compact('subscriber', 'coupons'));
    }


    public function send(Request $request)
    {




        $validator = Validator::make($request->only('coupon'), [
            'coupon' => 'required'
        ]);


        if ($validator->passes()) {
            $subscriber = Subscriber::where('subscribers.id', $request->id)->select('subscribers.*', 'users.name')->leftJoin('users', 'users.id', '=', 'subscribers.user_id')->first();
            $coupons = Coupon::find($request->coupon);


            $maildata = [
                'coupon' => $coupons,
                'subject' => 'You Recived a Subscription Email'
            ];


            Mail::to($subscriber->email)->send(new SubscribeMail($maildata));

            $request->session()->flash('success', 'Your Message Send Succesfully');
            return response()->json([
                'status' => true,
                'msg' => 'Your Message Send Succesfully',

            ]);
        } else {

            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }
    }

    public function destroy(Request $request, string $id)
    {
        $subcriber = Subscriber::find($id);



        if (empty($subcriber)) {

            $error = "Subcriber Not Found";

            $request->session()->flash('error', $error);

            return response()->json([
                'status' => false,
                'msg' => $error,
            ]);
        }

        $subcriber->delete();



        $status = true;
        $message = "Subscriber Delete Successfully";

        $request->session()->flash('success', $message);



        return response()->json([
            'status' => $status,
            'msg' => $message
        ]);
    }
}
