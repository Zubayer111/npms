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
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;

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
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
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
                $createdBy = $request->session()->get("id");
    
                if ($user->type === 'Patient') {
                    PatientsProfile::create([
                        'user_id' => $user->id,
                        'reference_by' => $createdBy,
                        'reference_time' => now(),
                        'first_name' => $user->name,
                        'phone_number' => $user->phone,
                        'email' => $user->email,
                        'created_by' => $createdBy,
                        'updated_by' => $createdBy,
                    ]);
                } elseif ($user->type === 'Doctor') {
                    DoctorsProfile::create([
                        'user_id' => $user->id,
                        'phone_number' => $user->phone,
                        'first_name' => $user->name,
                        'last_name' => $user->name,
                        'created_by' => $createdBy,
                        'updated_by' => $createdBy,
                    ]);
                } else {
                    AdminsProfile::create([
                        'user_id' => $user->id,
                        'phone_number' => $user->phone,
                        'first_name' => $user->name,
                        'last_name' => $user->name,
                        'created_by' => $createdBy,
                        'updated_by' => $createdBy,
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
            Log::error('User Creation Failed: ' . $e);
    
            return redirect("/dashboard/user-list")->with("error", $e->getMessage());
        }
    }


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

    public function updateUser(Request $request)
{
    try {
        $user_id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user_id,
            'phone' => 'required|string|min:10|unique:users,phone,' . $user_id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    } 
    catch (\Exception $e) {
        Log::error('User Update Failed: ' . $e);
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    
    
    public function userLogin(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $request->session()->put('name', $user->name);
            $request->session()->put('email', $user->email);
            $request->session()->put('id', $user->id);
            $request->session()->put('status', $user->status);
            $request->session()->put('type', $user->type);

            activity('User login') // Set log name here
            ->causedBy($user)
            ->withProperties([
                'ip' => $request->ip(),
                'user_name' => $user->name
            ])
            ->log("User {$user->name} logged in");
            
            Alert::success('Success', 'Login Successfully');
            return redirect()->intended('/dashboard/home')->with("success", "Login Successfully");
        }

        Alert::error('Error', 'Invalid Email or Password');
        return back()->with("error", "Invalid Email or Password");
    } catch (Exception $e) {
        Alert::toast($e->getMessage(), 'error');
        Log::error('Login Failed: ' . $e);
        return back()->with("error", $e->getMessage());
    }
}

public function userLogOut(Request $request)
{
    // Log the logout event
    if (Auth::check()) {
        activity('User logout')
            ->causedBy(Auth::user())
            ->withProperties([
                'ip' => $request->ip(),
                'user_name' => Auth::user()->name
            ])
            ->log("User " . Auth::user()->name . " logged out");
    }

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login')->cookie('token', '', -1);
}

public function sendOtp(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->input("email");
        $otp = rand(100000, 999999);
        $user = User::where("email", $email)->first();

        if ($user) {
            //Mail::to($email)->send(new OtpSand($otp));
            $user->update(['otp' => $otp]);

            $request->session()->put("email", $email);

            Alert::toast("OTP Sent Successfully", "success");

            return view("backend.pages.auth.verify-otp-page", compact("email"));
        } else {
            return redirect("/login")->with("error", "Invalid Email");
        }

    } catch (\Exception $e) {
        // Log the error
        Log::error('OTP Send Failed: ' . $e->getMessage(), [
            'email' => $request->input("email"),
            'ip' => $request->ip(),
        ]);

        // Optionally flash an error alert
        Alert::toast("Failed to send OTP. Please try again later.", "error");

        return redirect("/login")->with("error", "An error occurred while sending OTP.");
    }
}

public function VerifyOTP(Request $request)
{
    try {
        $request->validate([
            'otp' => 'required|string|min:6|max:6',
        ]);

        $email = $request->session()->get("email");
        $otp = $request->input("otp");

        $count = User::where("email", "=", $email)
            ->where("otp", "=", $otp)
            ->count();

        if ($count == 1) {
            User::where("email", "=", $email)->update(["otp" => "0"]);

            $token = JWTtoken::CreateTokenForSetPassword($email);

            Alert::toast("OTP Verified Successfully", "success");

            return redirect("/password-reset")
                ->cookie("token", $token, time() + 60 * 24 * 30);
        } else {
            Alert::toast("Invalid OTP", "error");
            return redirect("verify-otp")->with("error", "Invalid OTP");
        }

    } catch (\Exception $e) {
        Log::error('OTP Verification Error: ' . $e, [
            'email' => $request->session()->get("email"),
            'otp' => $request->input("otp"),
            'trace' => $e->getTraceAsString()
        ]);

        Alert::toast("Something went wrong. Please try again.", "error");
        return redirect("verify-otp")->with("error", "Something went wrong. Please try again.");
    }
}

    public function ResetPassword(Request $request){
        try{
            $request->validate([
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:password',
            ]);
                $email = $request->session()->get("email");
                $password = bcrypt($request->input('password'));
                $request->input("confirm_password");
                User::where("email","=",$email)->update(["password"=>$password]);
                Alert::toast("Password Reset Successfully", "success");
                return redirect("/login")->with("success","Password Reset Successfully")->cookie("token","",time()-1);
        }
        catch(Exception $e){
            Alert::toast($e->getMessage(), 'error');
            Log::error('Password Reset Error: ' . $e, [
                'email' => $request->session()->get("email"),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with("error",$e->getMessage());
        }
    }

    public function patientLogin(Request $request){
        try {
            $request->validate([
                'phone' => 'required|string|min:10|max:11',
            ]);

            $userMobile = $request->input("phone");
            $user = User::where("phone", $userMobile)->first();

            if ($user) {
                Auth::login($user);
                $request->session()->put('id', $user->id);
                $request->session()->put('name', $user->phone);
                $request->session()->put('status', $user->status);
                $request->session()->put('type', $user->type);

                return redirect("/dashboard/profile")->with("success", "Login Successfully");
            } else {
                return redirect("/user-login")->with("error", "Invalid Phone Number");
            }
        } catch (Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            Log::error('Patient Login Error: ' . $e, [
                'phone' => $request->input("phone"),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with("error", "Something went wrong. Please try again.");
        }
    }
        
    public function patientVerifyOtp(Request $request)
{
    try {
        $validated = $request->validate([
            'otp' => 'required|string|min:4',
        ]);

        $userMobile = $request->session()->get("phone");
        $otp = $request->input("otp");

        $user = User::where("phone", $userMobile)->where("otp", $otp)->first();

        if ($user) {
            // Clear OTP after successful verification
            $user->update(["otp" => 0]);

            // Authenticate the user
            Auth::login($user);

            $request->session()->put('id', $user->id);
            $request->session()->put('name', $user->phone);
            $request->session()->put('status', $user->status);
            $request->session()->put('type', $user->type);
            return redirect("/dashboard/profile")->with("success", "Login Successfully");
        }

        return redirect("patient-verify-otp")->with("error", "Invalid OTP");

    } catch (Exception $e) {
        return redirect("/user-login")->with("error", "Something went wrong. Please try again.");
    }
}   
    
    public function userDelete($id){
        $user = User::find($id);
        if ($user) {
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

        // Validate phone number format first
        if (!preg_match("/^01[3-9][0-9]{8}$/", $phone)) {
            return response()->json([
                'status' => 'error',
                'message' => "Phone number is not valid",
                'available' => false
            ]);
        }

        // Check if phone exists in database
        if (User::where('phone', $phone)->exists()) {
            return response()->json([
                'status' => 'exists',
                'message' => "Phone number already exists",
                'available' => false
            ]);
        }

        // If valid and not existing, return success
        return response()->json([
            'status' => 'success',
            'message' => "Phone number is valid and available",
            'available' => true
        ]);
    }
}
