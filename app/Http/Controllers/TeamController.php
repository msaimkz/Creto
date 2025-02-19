<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\tempimage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class TeamController extends Controller
{

   public function index(Request $request){


    $teams = Team::orderby('id', 'ASC');

    if (!empty($request->keyword)) {
        $teams->where('name', 'like', '%' . $request->keyword . '%');
        $teams->orWhere('designation', 'like', '%' . $request->keyword . '%');
    }


    $teams = $teams->paginate(8);


    return  view('Admin.Team.team',compact('teams'));
   } 

   public function create(Request $request){

    return  view('Admin.Team.create');
   } 


   public function store (Request $request){

    $validator = Validator::make($request->all(),[
        'name' => 'required|min:3',
        'designation' => 'required|',
        'status' => 'required',
         
     ]);




     if($validator->passes()){


    

        

         $team = new Team();
         $team->name = $request->name;
         $team->designation = $request->designation;
         $team->facebook_url = $request->facebook;
         $team->youtube_url = $request->youtube;
         $team->instagram_url = $request->instagram;
         $team->X_url = $request->X;
        
         $team->status = $request->status;
         $team->save();



         if(!empty($request->teamimage)){
            $tempimgid = $request->teamimage;
            $tempimginfo = tempimage::find($tempimgid);
            $extArray = explode('.',$tempimginfo->image);
            $ext = last($extArray);

            $newImageName = $team->id.'-'.time().'.'.$ext;
            $TempSpath = public_path().'/temp/'.$tempimginfo->image;
            $TempDpath = public_path().'/uploads/team/'.$newImageName;
            File::copy($TempSpath,$TempDpath);

            $team->img = $newImageName;
            $team->save();

             // Generate thumbnail

                



                //small
                $dpath = public_path().'/uploads/team/thumb/'.$newImageName;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($TempDpath);
                $image->cover(300,300);
                $image->save($dpath);
         }

         $request->session()->flash('success','Member  Added Successfully');
         return response()->json([
            'status' =>  true,
            'msg' => "Member  Added Successfully",
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
        $member = Team::find($id);
         
        if(empty($member)){
            $request->session()->flash('error','Member not Found');
            return response()->json([
                'status' => false,
                'msg' => 'Member Not Found'
             ]);
         return redirect()->route('Admin-team');
        }

       
        return view('Admin.Team.edit',compact('member'));

        
    }

    public function update(Request $request, string $id){

        $team = Team::find($id);

        if(empty($team)){
            $request->session()->flash('error','Member not Found');
            return response()->json([
                'status' => false,
                'msg' => 'Member Not Found'
             ]);
         return redirect()->route('Admin-team');
        }

    
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'designation' => 'required|',
            'status' => 'required',
             
         ]);
    
    
         if($validator->passes()){
    
    

             $team->name = $request->name;
             $team->designation = $request->designation;
             $team->facebook_url = $request->facebook;
             $team->youtube_url = $request->youtube;
             $team->instagram_url = $request->instagram;
             $team->X_url = $request->X;
            
             $team->status = $request->status;
             $team->update();
    
             $OldImageName = $team->img;
    
    
             if(!empty($request->teamimage)){
                $tempimgid = $request->teamimage;
                $tempimginfo = tempimage::find($tempimgid);
                $extArray = explode('.',$tempimginfo->image);
                $ext = last($extArray);
    
                $newImageName = $team->id.'-'.time().'.'.$ext;
                $TempSpath = public_path().'/temp/'.$tempimginfo->image;
                $TempDpath = public_path().'/uploads/team/'.$newImageName;
                File::copy($TempSpath,$TempDpath);
    
                $team->img = $newImageName;
                $team->update();

                File::delete(public_path('uploads/team/thumb/'.$OldImageName));
                File::delete(public_path('uploads/team/'.$OldImageName));

    
                 // Generate thumbnail
    
                    
    
    
    
                    //small
                    $dpath = public_path().'/uploads/team/thumb/'.$newImageName;
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($TempDpath);
                    $image->cover(300,300);
                    $image->save($dpath);
             }
    
             $request->session()->flash('success','Member  Updated Successfully');
             return response()->json([
                'status' =>  true,
                'msg' => "Member  Updated Successfully",
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
        $member = Team::find($id); 
        if(empty($member)){
            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => 'Team Member Not Found'
             ]);
        } 
        File::delete(public_path('uploads/team/thumb/'.$member->img));
        File::delete(public_path('uploads/team/'.$member->img));

        $member->delete();

        return response()->json([
            'status' => true,
            'id' => $id,
            'msg' => 'Member will be Deleted Successfully',
            ]);
    }

}
