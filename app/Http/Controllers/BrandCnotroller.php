<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\brand;

class BrandCnotroller extends Controller
{
    
    public function create()
    {
        $categories = Category::all();
        return view('Admin.brand.create',compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9]+$/',
            'slug' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9]+$/|unique:brands',
         ]);
 
         if($validator->passes()){
           $brand = new brand();
           $brand->name = $request->name;
           $brand->slug = $request->slug;
           $brand->status = $request->status;
           $brand->save();
 
           $request->session()->flash('success','brand Added Successfully');
           
           return response()->json([
             'status' => true,
             'msg' => 'brand Added Successfully'
         ]);
 
         }
         else{
             return response()->json([
                 'status' => false,
                 'errors' => $validator->errors()
             ]);
         }
    }

   

    public function edit(string $id)
    {
        $brand = brand::find($id);
        if(empty($brand)){
            return redirect()->route('brand');
        }
        return view('Admin.brand.edit',compact('brand'));
    }

    public function update(Request $request, string $id)
    {

        $brand = brand::find($id);   

        if(empty($brand)){
            $request->session()->flash('error','Category Not Found');
            return response()->json([
                'status' => false,
                'Notfound' => true,
                'msg' => 'brand Not Found'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9]+$/',
            'slug' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9]+$/|unique:brands,slug,'.$brand->id.',id',
         ]);
 
         if($validator->passes()){
           $brand->name = $request->name;
           $brand->slug = $request->slug;
           $brand->status = $request->status;
           $brand->save();
 
           $request->session()->flash('success','brand Updated Successfully');
           
           return response()->json([
             'status' => true,
             'msg' => 'brand Updated Successfully'
         ]);
 
         }
         else{
             return response()->json([
                 'status' => false,
                 'errors' => $validator->errors()
             ]);
         }
    }
    public function destroy(Request $request,string $id)
    {
        $Brand = brand::find($id);
        if(empty($Brand)){   
            $request->session()->flash('error','Brand Not Found');
        return response()->json([
            'status' => true,
            'msg' => 'Brand Not Found'
        ]);
        }

        $Brand->delete();

        $request->session()->flash('success','Brand Deleted Successfully');

        return response()->json([
            'status' => true,
            'msg' => 'Brand Deleted Successfully'
        ]);
    }
}
