<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('teacher.settings');
    }
    
        public function updateProfile(Request $request)
    {
         $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|max:2048|mimes:jpeg,bmp,png,jpg'
        ]);
        //$image = $request->file('image');
        $slug = str_slug($request->name);
        $user = User::findOrFail(Auth::id());
        
        // return $user;
        /*if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('profile'))
            {
             Storage::disk('public')->makeDirectory('profile');
            }
//            Delete old image form profile folder
            if (Storage::disk('public')->exists('profile/'.$user->image))
            {
                Storage::disk('public')->delete('profile/'.$user->image);
            }
            $profile = Image::make($image)->resize(500,500)->save('foo'.$image->getClientOriginalExtension());
            Storage::disk('public')->put('profile/'.$imageName,$profile);
        } else {
            $imageName = $user->image;
        }*/
        if($request->hasFile('image')){
            $image = $request->file('image');
            $directory = 'images/profile/';
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $imageUrl = $directory.$imagename;
            Image::make($image)->resize(60,60)->save($imageUrl);
            if(file_exists($directory.$user->image)){
                @unlink($directory.$user->image);
            }
        }else{
            $imagename = $user->image;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->image = $imagename;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Profile Successfully Updated','Success');
        return redirect()->back();

    }

    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Successfully Changed','Success');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password cannot be the same as old password.','Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.','Error');
            return redirect()->back();
        }

    }
    
}
