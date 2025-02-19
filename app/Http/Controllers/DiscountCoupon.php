<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;


class DiscountCoupon extends Controller
{


    public function create()
    {
        return view('Admin.discount.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'discount_amount' => 'required|numeric',
            'type' => 'required',
            'status' => 'required',
        ]);



        if ($validator->passes()) {

            // Start_at Date Validation 
            if (!empty($request->start_at)) {
                $now = Carbon::now();
                $start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);
                if ($start_at->lte($now)) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['start_at' => 'Start date current time se kam nahin ho sakti'],
                    ]);
                }
            }

            // Expire_at Date Validation 
            if (!empty($request->expire_at)) {
                $start_at = !empty($request->start_at) ? Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at) : null;
                $expire_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->expire_at);

                if ($start_at && $expire_at->lte($start_at)) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['expire_at' => 'Expire date Start date se zyada honi chahiye'],
                    ]);
                }
            }

            // Save coupon data
            $discount = new Coupon();
            $discount->code = $request->code;
            $discount->name = $request->name;
            $discount->description = $request->description;
            $discount->max_uses = $request->max_uses;
            $discount->max_user_uses = $request->max_user_uses;
            $discount->type = $request->type;
            $discount->discount_amount = $request->discount_amount;
            $discount->status = $request->status;
            $discount->min_amount = $request->min_amount;
            $discount->start_at = $request->start_at;
            $discount->expire_at = $request->expire_at;
            $discount->save();

            $message = 'Discount Coupon Added Successfully';
            $request->session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'msg' => $message,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(string $id, Request $request)
    {

        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            $request->session()->flash('error', 'Dicount Coupon Not Found');
            return redirect()->route('discount');
        }


        return view('Admin.discount.edit', compact('coupon'));
    }


    public function update(Request $request, string $id)
    {
        $discount = Coupon::find($id);

        if (empty($discount)) {
            $request->session()->flash('error', 'Dicount Coupon Not Found');
            return redirect()->route('discount');
        }

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'discount_amount' => 'required|numeric',
            'type' => 'required',
            'status' => 'required',
        ]);



        if ($validator->passes()) {


            // Expire_at Date Validation 

            if (!empty($request->start_at) && !empty($request->expire_at)) {
                $start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);
                $expire_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->expire_at);
                if ($expire_at->gt($start_at) == false) {

                    return response()->json([
                        'status' => false,
                        'errors' => ['expire_at' => 'Expire date must be greater than Start date'],
                    ]);
                }

                $discount->code = $request->code;
                $discount->name = $request->name;
                $discount->description = $request->description;
                $discount->max_uses = $request->max_uses;
                $discount->max_user_uses = $request->max_user_uses;
                $discount->type = $request->type;
                $discount->discount_amount = $request->discount_amount;
                $discount->status = $request->status;
                $discount->min_amount = $request->min_amount;
                $discount->start_at = $request->start_at;
                $discount->expire_at = $request->expire_at;
                $discount->update();


                $message = 'Discount Coupon Updated succesfully';
                $request->session()->flash('success', $message);
                return response()->json([
                    'status' => true,
                    'msg' => $message,
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function destroy(string $id)
    {

        $discount = Coupon::find($id);

        if (empty($discount)) {
            return response()->json([
                'status' => true,
                'error' => true,
                'msg' => "Discount Coupon Not Found",
            ]);
        }

        $discount->delete();


        $message = 'Discount Coupon Deleted succesfully';
        return response()->json([
            'status' => true,
            'id' => $id,
            'msg' => $message,
        ]);
    }
}
