<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Slim;
use App\User;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.home');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function profileUpdateAvatar(Request $request)
    {
        $employee = Auth::user();
        if ($employee) {
            $imageRand = rand(1000, 9999);
            $random_name = $imageRand."_".time()."_".$employee->id;

            if(!is_dir(public_path('uploads/avatars/'.$employee->unique_id))){
                mkdir(public_path('uploads/avatars/'.$employee->unique_id));
            }

            $dst = public_path('uploads/avatars/'.$employee->unique_id.'/');

            $finish_image = $this->uploadImagetoServer($request, $random_name, $dst);

            if ($finish_image['result'] == "fail") {
                return $finish_image['reason'];
            }

            if ($finish_image['result'] == "success") {
                $employee->avatar = $finish_image['image'][0]['name'];
                $employee->save();

                $avatar_url = asset('/uploads/avatars/'.$employee->unique_id.'/'.$employee->avatar);

                return $avatar_url;
            }

            return $finish_image->result;
        }
        return "fail";
    }

    public function profileUpdateCover(Request $request)
    {
        $employee = Auth::user();
        if ($employee) {
            $imageRand = rand(1000, 9999);
            $random_name = $imageRand."_".time()."_".$employee->id;

            if(!is_dir(public_path('uploads/covers/'.$employee->unique_id))){
                mkdir(public_path('uploads/covers/'.$employee->unique_id));
            }

            $dst = public_path('uploads/covers/'.$employee->unique_id.'/');

            $finish_image = $this->uploadImagetoServer($request, $random_name, $dst);

            if ($finish_image['result'] == "fail") {
                return $finish_image['reason'];
            }

            if ($finish_image['result'] == "success") {
                $employee->cover = $finish_image['image'][0]['name'];
                $employee->save();

                $avatar_url = asset('/uploads/covers/'.$employee->unique_id.'/'.$employee->cover);

                return $avatar_url;
            }

            return $finish_image->result;
        }
        return "fail";
    }

    public function uploadImagetoServer($imgdata, $name, $path)
    {
        $files = array();
        $result = array();
        $rules = [
            'file' => 'image',
            'slim[]' => 'image'
        ];

        $validator = Validator::make($imgdata->all(), $rules);
        $errors = $validator->errors();

        if($validator->fails()){
            $result = array('result' => 'fail', 'reson' => 'validator');
            return $result;
        }

        // Get posted data
        $images = Slim::getImages();

        // No image found under the supplied input name
        if ($images == false) {
            $result = array('result' => 'fail', 'reson' => 'image');
            return $result;
        } else {
            foreach ($images as $image) {
                // save output data if set
                if (isset($image['output']['data'])) {
                    // Save the file
                    $origine_name = $image['input']['name'];
                    $file_type = pathinfo($origine_name, PATHINFO_EXTENSION);
                    $finalName = $name.".".$file_type;

                    // We'll use the output crop data
                    $data = $image['output']['data'];
                    $output = Slim::saveFile($data, $finalName, $path, false);
                    array_push($files, $output);
                    $result = array('result' => 'success', 'image' => $files);
                    return $result;
                }
                // save input data if set
                if (isset ($image['input']['data'])) {
                    // Save the file
                    $origine_name = $image['input']['name'];
                    $file_type = pathinfo($origine_name, PATHINFO_EXTENSION);
                    $finalName = $name.".".$file_type;

                    $data = $image['input']['data'];
                    $input = Slim::saveFile($data, $finalName, $path, false);
                    array_push($files, $output);

                    $result = array('result' => 'success', 'image' => $files);
                    return $result;
                }
            }
        }
    }

    public function usernameValidate($new_username)
    {
        // return $new_username;
        $admin = Admin::where('username', $new_username)->count();
        $user = User::where('username', $new_username)->count();
        $total = $admin + $user;
        if($total != 0){
            return "exist";
        }else{
            return "new";
        }
    }

    public function emailValidate($new_email)
    {
        // return $new_username;
        $admin = Admin::where('email', $new_email)->count();
        $user = User::where('email', $new_email)->count();
        $total = $admin + $user;
        if($total != 0){
            return "exist";
        }else{
            return "new";
        }
    }

    public function updateEmployeeUnique(Request $request)
    {
        $employee = Auth::user();
        if ($employee) {
            if ($employee->username != $request->unique_username) {
                $employee->username = $request->unique_username;
                $employee->save();
            }
            if ($employee->email != $request->unique_email) {
                $employee->email = $request->unique_email;
                $employee->save();
            }
            return back();
        }
        return back();
    }

    public function updateEmployeeInfo(Request $request)
    {
        $employee = Auth::user();
        if ($employee) {
            $employee->first_name = $request->firstName;
            $employee->last_name = $request->lastName;
            $employee->birth = $request->birth;
            $employee->contract_type = $request->contract_type;
            $employee->social_number = $request->socialNumber;
            $employee->personal_number = $request->personalNumber;
            $employee->emergency_contact = $request->emergencyContact;
            $employee->save();

            return back();
        }
        return back();
    }

    public function updateEmployeePassOwn(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $current_password = $user->password;
            if (Hash::Check($request->old_password, $current_password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return "success";
            }
            return "invalidPass";
        }
        return "fail";
    }
}
