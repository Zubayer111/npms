<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OtpSand;
use App\Mail\UserInfo;
use App\Helper\JWTToken;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use App\Models\AdminsProfile;
use App\Helper\ResponseHelper;
use App\Models\DoctorsProfile;
use App\Models\PatientsProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function userLoginPage(){
        return view("backend.pages.auth.login-page");
    }

    public function SendOtpPage(){
        return view("backend.pages.auth.send-otp-page");
    }

    public function VerifyOTPPage(){
        return view("backend.pages.auth.verify-otp-page");
    }

    public function ResetPasswordPage(){
        return view("backend.pages.auth.reset-password-page");
    }

    public function patientLoginPage(){
        return view("backend.pages.auth.patient-login-page");
    }

    public function patientVerifyOtpPage(){
        return view("backend.pages.auth.patient-verify-otp-page");
    }


public function createUser(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string|min:10|unique:users',
            'type' => 'required', 
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        DB::beginTransaction();

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'type' => $request->input('type'),
        ]);
        
        if ($user) {
            event(new UserCreated($user, $request->input('password')));
            if ($user->type === 'Patient') {
               PatientsProfile::create([
                    'user_id' => $user->id,
                    'reference_by' => $request->session()->get("id"),
                    'reference_time' => date('Y-m-d H:i:s'),
                    'first_name' => $user->name,
                    'phone_number' => $user->phone,
                    'email' => $user->email,
                    'created_by' => $request->session()->get("id"),
                    'updated_by' => $request->session()->get("id"),
                ]);
                // dd($patient);
            } elseif ($user->type === 'Doctor') {
                DoctorsProfile::create([
                    'user_id' => $user->id,
                    'phone_number' => $user->phone,
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                    'created_by' => $request->session()->get("id"),
                    'updated_by' => $request->session()->get("id"),
                ]);
            } else {
                AdminsProfile::create([
                    'user_id' => $user->id,
                    'phone_number' => $user->phone,
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                    'created_by' => $request->session()->get("id"),
                    'updated_by' => $request->session()->get("id"),
                ]);
            } 
           

            DB::commit();
            
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully & an email has been sent to the provided email address',
            ], 200);
        }
    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Admin Creation Failed: ' . $e);
        Alert::toast($e->getMessage(), 'error');
        return redirect("/dashboard/user-list")->with("error", $e->getMessage());
    }
}
// public function createUser(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|unique:users',
//             'password' => 'required|min:8',
//             'phone' => 'required|string|unique:users,phone|min:10|max:11',
//             'type' => 'required',
//         ]);

//         $user = User::create([
//             'name' => $request->input('name'),
//             'email' => $request->input('email'),
//             'password' => bcrypt($request->input('password')),
//             'phone' => $request->input('phone'),
//             'type' => $request->input('type'),
//         ]);

//         if ($user) {
//             event(new UserCreated($user, $request->input('password')));

//             if ($user->type === 'Patient') {
//                 PatientsProfile::create([
//                     'user_id' => $user->id,
//                     'reference_by' => $request->session()->get("id", 0),
//                     'reference_time' => now(),
//                     'first_name' => $user->name,
//                     'phone_number' => $user->phone,
//                     'email' => $user->email,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             } elseif ($user->type === 'Doctor') {
//                 DoctorsProfile::create([
//                     'user_id' => $user->id,
//                     'phone_number' => $user->phone,
//                     'first_name' => $user->name,
//                     'last_name' => $user->name,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             } elseif ($user->type === 'Admin') {
//                 AdminsProfile::create([
//                     'user_id' => $user->id,
//                     'phone_number' => $user->phone,
//                     'first_name' => $user->name,
//                     'last_name' => $user->name,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             } else {
//                 return response()->json([
//                     'status' => 'error',
//                     'message' => 'Something went wrong',
//                 ]);
//             }
//             DB::commit();
            
//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'User created successfully & an email has been sent to the provided email address',
//             ], 200);
//         }
//     } catch (Exception $e) {
//         DB::rollBack();
//         Alert::toast($e->getMessage(), 'error');
//         return redirect("/dashboard/user-list")->with("error", $e->getMessage());
//     }
// }



    public function checkPasswordStrength(Request $request){
        $password = $request->input('password');
        $strength = $this->getPasswordStrength($password);
        return response()->json(['strength' => $strength]);
    }

    private function getPasswordStrength($password)
    {
        $strength = 0;

        if (strlen($password) >= 8) {
            $strength += 1;
        }

        if (preg_match('/[A-Z]/', $password)) {
            $strength += 1;
        }

        if (preg_match('/[a-z]/', $password)) {
            $strength += 1;
        }

        if (preg_match('/[0-9]/', $password)) {
            $strength += 1;
        }

        if (preg_match('/[\W]/', $password)) {
            $strength += 1;
        }

        return $strength;
    }

    public function editUser($id){
        $data = User::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateUser(Request $request) {
        try {
            $user_id = $request->input('id');
            $type = User::where("id", $user_id)->first()->type;
    
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user_id,
                'phone' => 'required|numeric|min:10|unique:users,phone,'.$user_id,
            ]);

            $user = User::where("id", $user_id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'type' => $type,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user        
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
    
    public function userLogin(Request $request)
    {
        try{
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
        $userEmail = $request->input('email');
        $userPassword = $request->input('password');
    
        $user = User::where("email", $userEmail)->first();
    
        if ($user && Hash::check($userPassword, $user->password)) {
            $token = JWTToken::CreateToken($userEmail, $user->id, $user->type, $user->status, $user->name);
    
            Alert::success('Success', 'Login Successfully');
            return redirect('/dashboard/home')
                ->with("success", "Login Successfully")
                ->cookie("Token", $token, 60 * 24 * 30);
        } else {
            Alert::error('Error', 'Invalid Email or Password');
            return redirect('/login')->with("error", "Invalid Email or Password");
        }
    }
        catch(Exception $e){
            Alert::toast($e->getMessage(), 'error');
            return redirect('/login')->with("error",$e->getMessage());
        }
    }

    public function userLogOut(){
        return redirect('/login')->cookie('Token','',-1);
    }

    public function sendOtp(Request $request){
        $email = $request->input("email");
            $otp = rand(1000,9999);
            $count = User::where("email", "=", $email)->count();

            if($count==1){
                Mail::to($email)->send(new OtpSand($otp));
                User::where("email","=",$email)->update(["otp"=>$otp]);
                $request->session()->put("email", $email);
                Alert::toast(" OTP Sent Successfully", "success");
                return view("backend.pages.auth.verify-otp-page", compact("email"));
            }
        else{
            return redirect("/login")->with("error","Invalid Email");
        }
    }

    public function VerifyOTP(Request $request){
        $request->validate([
            'otp' => 'required|string|min:4',
        ]);
        $email = $request->session()->get("email");
        $otp = $request->input("otp");
        $count = User::where("email", "=", $email)
        ->where("otp", "=", $otp)->count();

        if($count==1){
            User::where("email", "=", $email)->update(["otp"=>"0"]);
            $token = JWTtoken::CreateTokenForSetPassword($request->input("email"));
            Alert::toast("OTP Verified Successfully", "success");
            return redirect("/password-reset")->cookie("token",$token,time()+60*24*30);
        }
        else{
            Alert::toast("Invalid OTP", "error");
            return redirect("verify-otp")->with("error","Invalid OTP");
        }
    }

    public function ResetPassword(Request $request){
        try{
            $request->validate([
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:password',
            ]);
                $email = $request->session()->get("email");
                //  return($email);
                $password = Hash::make($request->input("password"));
                $request->input("confirm_password");
                //return($password);
                User::where("email","=",$email)->update(["password"=>$password]);
                Alert::toast("Password Reset Successfully", "success");
                return redirect("/login")->with("success","Password Reset Successfully")->cookie("token","",time()-1);
        }
        catch(Exception $e){
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->with("error",$e->getMessage());
        }
    }

    public function patientLogin(Request $request){
        $validated = $request->validate([
            'phone' => 'required|string|min:10|max:11',
        ]);
    
        if ($validated) {
            $userMobile = $request->input("phone");
            $otp = rand(100000, 999999);
            $user = User::updateOrCreate(["phone" => $userMobile], ["phone" => $userMobile, "otp" => $otp]);
            if(PatientsProfile::where("phone_number", $userMobile)->doesntExist()) {
                PatientsProfile::create([
                    "user_id" => $user->id,
                    "phone_number" => $userMobile,
                ]);
            }
            $request->session()->put("phone", $userMobile);
            Alert::toast("OTP Sent Successfully", "success");
            return view("backend.pages.auth.patient-verify-otp-page", compact("userMobile"));
        } else {
            return redirect("/user-login")->with("error", "Invalid Phone Number");
        }
    }

    public function patientVerifyOtp(Request $request){
       
           $validated = $request->validate([
                'otp' => 'required|string|min:4',
            ]);
            if ($validated) {
                $userMobile = $request->session()->get("phone");
                $otp = $request->input("otp");
                $user = User::where("phone", $userMobile)->where("otp", $otp)->first();
                 //return($user);
                if($user){
                 User::where("phone", $userMobile)->where("otp", $otp)->update(["otp"=>0]);
                 $token = JWTToken::CreateToken($userMobile,$user->id,$user->type,$user->status,$userMobile);
                 return redirect("/dashboard/profile")->with("success","Login Successfully")->cookie("Token", $token,60*24*30);
                }
                else{
                 return redirect("patient-verify-otp")->with("error","Invalid OTP");
                }
            }
          else {
            return redirect("/user-login")->with("error", "Please Try Again");
          } 
    
           
    }    
    
    public function userDelete($id){
        $user = User::find($id);
        if ($user) {
            $user->status = 'suspended';
            $user->save();
            $user->delete();
            
            toast('User has been deleted','success');

            return redirect()->back();
        }
        return redirect()->back()->with("error", "User not found");
    }

    

    public function userInactive($id){
        $user = User::find($id);
        
        if ($user) {
            $user->status = 'inactive';
            $user->save();
             toast('User has been deactivate','success');
            return redirect()->back();
        }
        return redirect()->back()->with("error", "User not found");
    }

    public function userActive($id){
        $user = User::find($id);
        
        if ($user) {
            $user->status = 'active';
            $user->save();
             toast('User has been activate','success');
            return redirect()->back();
        }
        return redirect()->back()->with("error", "User not found");
    }

    public function userRestore($id){
        $user = User::onlyTrashed()->find($id);

        if ($user) {
            $user->status = 'active';
            $user->restore();
            $user->save();

            return redirect()->back()->with("success", "User has been restored");
        }
        return redirect()->back()->with("error", "User not found");
    }


    public function updatePassword(Request $request){
       try{
        $userId = $request->session()->get("id");
        $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8',
        ]);
        $password = Hash::make($request->input("password"));
        User::where("id", $userId)->update(["password"=>$password]);
        return redirect()->back()->with("success","Password Updated Successfully");
       }
       catch(Exception $e){
        Alert::toast( $e->getMessage(), 'error');
        return redirect()->back()->with("error",$e->getMessage());
       }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $emailExists = User::where('email', $email)->exists();

        return response()->json([
            'exists' => $emailExists
        ]);
    }

    public function checkPhone(Request $request)
    {
            $phone = $request->input('phone');

            if (User::where('phone', $phone)->exists()) {
                return response()->json([
                    'status' => 'exists',
                    'message' => "Phone number already exists",
                    'available' => false
                ]);
            }

            else if (preg_match("/^[0-9]{3}[0-9]{4}[0-9]{4}$/", $phone)) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Phone number is valid",
                    'available' => true
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Phone number is not valid",
                    'available' => false
                ]);
            }

    }

    public function profileEditAdmin(Request $request){

    }
}
