<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\TempImage;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view("Admin.product.create", compact('categories', 'brands'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9\s]+$/',
            'slug' => 'required|min:3|max:200|unique:products',
            'description' => 'required|',
            'shipping' => 'required',
            'price' => 'required|numeric',
            'gender' => 'required|in:men,women,kid',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'model' => 'required',
            'is_featured' => 'required|in:Yes,No',
            'sku' => 'required|unique:products',
            'qty' => 'required|numeric',
            'status' => 'required',
        ]);

        $length = is_array($request->img_array) ? count($request->img_array) : 0;
        if ($length > 4) {
            return response()->json([
                'status' => false,
                'error' => true,
                'errorMsg' => "You can only upload up to 4 images"
            ]);
        }

        if ($validator->passes()) {
            $product  = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->model = $request->model;
            $product->description = $request->description;
            $product->shipping = $request->shipping;
            $product->price = $request->price;
            $product->gender = $request->gender;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->is_featured = $request->is_featured;
            $product->sku = $request->sku;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->related_products = (!empty($request->related_product)) ? implode(',', $request->related_product)  : '';
            $product->save();



            if (!empty($request->img_array)) {
                foreach ($request->img_array as $tempimgid) {

                    $tempimginfo = TempImage::find($tempimgid);
                    $extArray = explode('.', $tempimginfo->image);
                    $ext = last($extArray);
                    $productimages = new ProductImage();
                    $productimages->product_id = $product->id;
                    $productimages->image = 'null';
                    $productimages->save();


                    $ImageName = $product->id . '-' . $productimages->id . '-' . time() . '.' . $ext;
                    $productimages->image = $ImageName;
                    $productimages->save();



                    // Generate thumbnail

                    //large
                    $manager = new ImageManager(new Driver());
                    $Spath = public_path() . '/temp/' . $tempimginfo->image;
                    $dpath = public_path() . '/uploads/product/large/' . $ImageName;
                    $image = $manager->read($Spath);
                    $image->scaleDown(1400);
                    $image->save($dpath);




                    //small
                    $dpath = public_path() . '/uploads/product/small/' . $ImageName;
                    $image->cover(300, 300);
                    $image->save($dpath);
                }
            }


            $request->session()->flash('success', 'Product Added Successfully');
            return response()->json([
                'status' => true,
                'msg' => 'Product Added Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit(Request $request, string $id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            $request->session()->flash('error', 'Product not Found');
            return response()->json([
                'status' => false,
                'msg' => 'Product Not Found'
            ]);
            return redirect()->route('product');
        }

        $Productimage = ProductImage::where('product_id', $product->id)->get();
        $categories = Category::all();
        $brands = Brand::all();
        $relatedProduct = [];

        if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);

            $relatedProduct = Product::whereIn('id', $productArray)->get();
        }

        return view('Admin.product.edit', compact('product', 'categories', 'brands', 'Productimage', 'relatedProduct'));

        return response()->json([
            'status' => true,
            'msg' => 'Product  Found Successfully'
        ]);
    }


    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            $request->session()->flash('error', 'Product not Found');
            return response()->json([
                'status' => false,
                'NotFound' => true,
                'msg' => 'Product Not Found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9\s]+$/',
            'slug' => 'required|min:3|max:200|unique:products,slug,' . $product->id . ',id',
            'description' => 'required|',
            'shipping' => 'required',
            'price' => 'required|numeric',
            'gender' => 'required|in:men,women,kid',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'model' => 'required',
            'is_featured' => 'required|in:Yes,No',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id',
            'qty' => 'required|numeric',
            'status' => 'required',
        ]);
        $length = is_array($request->img_array) ? count($request->img_array) : 0;
        if ($length > 4) {
            return response()->json([
                'status' => false,
                'error' => true,
                'errorMsg' => "You can only upload up to 4 images"
            ]);
        }
        if ($validator->passes()) {
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->model = $request->model;
            $product->description = $request->description;
            $product->shipping = $request->shipping;
            $product->price = $request->price;
            $product->gender = $request->gender;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->is_featured = $request->is_featured;
            $product->sku = $request->sku;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->related_products = (!empty($request->related_product)) ? implode(',', $request->related_product)  : '';
            $product->update();

            $request->session()->flash('success', 'Product Updated Successfully');
            return response()->json([
                'status' => true,
                'msg' => 'Product Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => "Product Not Found"
            ]);
        }

        $ProductImg = ProductImage::where('product_id', $id)->get();

        if (!empty($ProductImg)) {
            foreach ($ProductImg as $ProductImgs) {
                File::delete(public_path('uploads/product/large/' . $ProductImgs->image));
                File::delete(public_path('uploads/product/small/' . $ProductImgs->image));
            }
            ProductImage::where('product_id', $id)->delete();
        }
        $product->delete();
        return response()->json([
            'status' => true,
            'id' => $id,
            'msg' => 'Product will be Deleted Successfully',
        ]);
    }

    public function getProduct(Request $request)
    {
        $tempproduct = [];
        if ($request->term != "") {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();

            if ($products != null) {
                foreach ($products as $product) {
                    $tempproduct[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }
        return response()->json([
            'tags' => $tempproduct,
            'status' => true,
        ]);
    }
}
