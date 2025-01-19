<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{


    public function create()
    {

        $countries = Country::get();

        $shippings = ShippingCharge::select('shipping_charges.*', 'countries.name')
        ->leftJoin('countries', 'countries.id', '=', 'shipping_charges.country_id')
        ->get();
        return view('Admin.shipping.create',compact('countries','shippings'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
          'country_id' => 'required',
          'amount' => 'required|numeric',
        ]);


        if($validator->passes()){


          $shippinginfo = ShippingCharge::where('country_id',$request->country_id)->first();

          if($shippinginfo != null) {
            $request->session()->flash('error','Shipping Already Added ');
            return response()->json([
              'status' => true,
            ]);
          }  

          $shipping = new ShippingCharge();
          $shipping->country_id = $request->country_id;
          $shipping->amount = $request->amount;
          $shipping->save();


          $request->session()->flash('success','Shipping Added Succesfully');
          return response()->json([
            'status' => true,
          ]);

        }
        else{

            return response()->json([
              'status' => false,
               'errors' => $validator->errors(),
            ]);
        }
    }

    
   
    public function edit(string $id , Request $request)
    {

        $shipping = ShippingCharge::find($id);

        if(empty($shipping)){
            $request->session()->flash('error','Shipping Not Found  ');
           return redirect()->route('Shipping');
        }
        $countries = Country::get();

        return view('Admin.shipping.edit',compact('countries','shipping'));
    }

   
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'country_id' => 'required',
            'amount' => 'required|numeric',
          ]);
  
  
          if($validator->passes()){
  
  
           
  
            $shipping = ShippingCharge::find($id);
            $shipping->country_id = $request->country_id;
            $shipping->amount = $request->amount;
            $shipping->save();
  
  
            $request->session()->flash('success','Shipping Updated Succesfully');
            return response()->json([
              'status' => true,
            ]);
  
          }
          else{
  
              return response()->json([
                'status' => false,
                 'errors' => $validator->errors(),
              ]);
          }
    }

    
    public function destroy(string $id , Request $request)
    {
        $shipping = ShippingCharge::find($id);
        if(empty($shipping)){
            $request->session()->flash('error','Shipping Not Found  ');
           return response()->json([
            'status' => false
           ]);
        }

        $shipping->delete();

        $request->session()->flash('success','Shipping Deleted Succesfully  ');
        return response()->json([
         'status' => true
        ]);
    }
}
