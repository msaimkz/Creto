<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\TempImage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


use Illuminate\Http\Request;

class NewsController extends Controller
{
    
    public function create()
    {
        return view("Admin.news.create");
    }

   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9\s]+$/',
            'slug' => 'required|min:3|max:200|unique:news',
            'writer'=>'required|min:3|min:30|regex:/^[a-zA-Z\s]+$/',
            'description' => 'required|min:10',
            'short_description'=> 'required|min:7|max:150',
            'is_Home' => 'required|in:Yes,No',
            'status' => 'required',
             
         ]);

         if($validator->passes()){
             $news = new Article();
             $news->title = $request->title;
             $news->slug = $request->slug;
             $news->writer = $request->writer;
             $news->short_descripion = $request->short_description;
             $news->descripion = $request->description;
             $news->is_Home = $request->is_Home;
             $news->status = $request->status;
             $news->save();



             if(!empty($request->newsimage)){
                $tempimgid = $request->newsimage;
                $tempimginfo = TempImage::find($tempimgid);
                $extArray = explode('.',$tempimginfo->image);
                $ext = last($extArray);

                $newImageName = $news->id.'-'.time().'.'.$ext;
                $TempSpath = public_path().'/temp/'.$tempimginfo->image;
                $TempDpath = public_path().'/uploads/News/'.$newImageName;
                File::copy($TempSpath,$TempDpath);

                $news->img = $newImageName;
                $news->save();

                 // Generate thumbnail

                    //large
                    $manager = new ImageManager(new Driver());
                    $dpath = public_path().'/uploads/News/thumb/large/'.$newImageName;
                    $image = $manager->read($TempDpath);
                    $image->scaleDown(1400);
                    $image->save($dpath);



                    //small
                    $dpath = public_path().'/uploads/News/thumb/small/'.$newImageName;
                    $image->cover(300,300);
                    $image->save($dpath);
             }

             $request->session()->flash('success','News Added Successfully');
             return response()->json([
                'status' =>  true,
                'msg' => "News Added Successfully",
            ]);
         }else{
            return response()->json([
                'status' =>  false,
                'errors' => $validator->errors(),
            ]);
         }
    }

    public function edit(Request $request,string $id)
    {
        $news = Article::find($id);
         
        if(empty($news)){
            $request->session()->flash('error','News not Found');
            return response()->json([
                'status' => false,
                'msg' => 'News Not Found'
             ]);
         return redirect()->route('news');
        }

       
        return view('Admin.news.edit',compact('news'));

        return response()->json([
            'status' => true,
            'msg' => 'News  Found Successfully'
         ]);
    }

  
    public function update(Request $request, string $id)
    {
        $news = Article::find($id); 
        if(empty($news)){
            $request->session()->flash('error','News not Found');
            return response()->json([
                'status' => false,
                'NotFound' => true,
                'msg' => 'News Not Found'
             ]);
        } 
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9\s]+$/',
            'slug' => 'required|min:3|max:200|unique:news,slug,'.$news->id.',id',
            'writer'=>'required|min:3|max:30|regex:/^[a-zA-Z\s]+$/',
            'description' => 'required|min:10',
            'short_description'=> 'required|min:7|max:150',
            'is_Home' => 'required|in:Yes,No',
            'status' => 'required',
             
         ]);

         if($validator->passes()){
             $news->title = $request->title;
             $news->slug = $request->slug;
             $news->writer = $request->writer;
             $news->short_descripion = $request->short_description;
             $news->descripion = $request->description;
             $news->is_Home = $request->is_Home;
             $news->status = $request->status;
             $news->update();
             
             $OldImageName = $news->img;


             if(!empty($request->newsimage)){
                $tempimgid = $request->newsimage;
                $tempimginfo = TempImage::find($tempimgid);
                $extArray = explode('.',$tempimginfo->image);
                $ext = last($extArray);

                $newImageName = $news->id.'-'.time().'.'.$ext;
                $TempSpath = public_path().'/temp/'.$tempimginfo->image;
                $TempDpath = public_path().'/uploads/News/'.$newImageName;
                File::copy($TempSpath,$TempDpath);

                $news->img = $newImageName;
                $news->update();

                File::delete(public_path('uploads/News/thumb/large/'.$OldImageName));
                File::delete(public_path('uploads/News/thumb/small/'.$OldImageName));
                File::delete(public_path('uploads/News/'.$OldImageName));


                 //large
                 $manager = new ImageManager(new Driver());
                 $dpath = public_path().'/uploads/News/thumb/large/'.$newImageName;
                 $image = $manager->read($TempDpath);
                 $image->scaleDown(1400);
                 $image->save($dpath);



                 //small
                 $dpath = public_path().'/uploads/News/thumb/small/'.$newImageName;
                 $image->cover(300,300);
                 $image->save($dpath);
             }

             $request->session()->flash('success','News Updated Successfully');
             return response()->json([
                'status' =>  true,
                'msg' => "News Updated Successfully",
            ]);
         }else{
            return response()->json([
                'status' =>  false,
                'errors' => $validator->errors(),
            ]);
         }
    }

    public function destroy( string $id)
    {
        $news = Article::find($id); 
        if(empty($news)){
            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => 'News Not Found'
             ]);
        } 
        File::delete(public_path('uploads/News/thumb/large/'.$news->img));
        File::delete(public_path('uploads/News/thumb/small/'.$news->img));
        File::delete(public_path('uploads/News/'.$news->img));

        $news->delete();

        return response()->json([
            'status' => true,
            'id' => $id,
            'msg' => 'News will be Deleted Successfully',
            ]);
    }
}
