<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{

    public function create()
    {
        return view('Admin.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'name' => 'required',
           'slug' => 'required|unique:categories',
        ]);

        if($validator->passes()){
          $category = new Category();
          $category->name = $request->name;
          $category->slug = $request->slug;
          $category->status = $request->status;
          $category->save();

          $request->session()->flash('success','Category Added Successfully');
          
          return response()->json([
            'status' => true,
            'msg' => 'Category Added Successfully'
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
        $category = Category::find($id);

        if(empty($category)){
            return redirect()->route('category');
        }

        return view('Admin.category.edit',compact('category'));
    }

    
    public function update(Request $request, string $id)
    {
        
        $category = Category::find($id);

        if(empty($category)){
            $request->session()->flash('error','Category Not Found');
            return response()->json([
                'status' => false,
                'Notfound' => true,
                'msg' => 'Category Not Found'
            ]);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
         ]);
 
         if($validator->passes()){
           $category->name = $request->name;
           $category->slug = $request->slug;
           $category->status = $request->status;
           $category->update();
 
           $request->session()->flash('success','Category Updated Successfully');
           
           return response()->json([
             'status' => true,
             'msg' => 'Category Updated Successfully'
         ]);
 
         }
         else{
             return response()->json([
                 'status' => false,
                 'errors' => $validator->errors()
             ]);
         }
    }

    
    public function destroy(Request $request, string $id)
    {
        $category = Category::find($id);
        if(empty($category)){
            
            $request->session()->flash('error','Category Not Found');

        return response()->json([
            'status' => true,
            'msg' => 'Category Not Found'
        ]);
        }

        $category->delete();

        $request->session()->flash('success','Category Deleted Successfully');

        return response()->json([
            'status' => true,
            'msg' => 'Category Deleted Successfully'
        ]);


    }
}
