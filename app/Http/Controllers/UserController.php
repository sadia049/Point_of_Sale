<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Helper\JWT_TOKEN;
use App\Mail\OTPmail;
use Error;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Password;
use PHPUnit\Event\Code\Throwable;

class UserController extends Controller
{

    //User Registration method
    function registration(Request $request)
    {

        try {

           // request validation

            $validated = Validator::make(
                $request->all(),
                [
                    'firstName' => 'alpha:ascii',
                    'lastName' => 'alpha:ascii',
                    'email' => 'required|email|unique:App\Models\User,email',
                    'password' => 'required|min:8'
                ],
                [
                    'firstName'=>'Only Aplphabet allowed',
                    'email.unique' => 'Already Have an account',
                    'password' => 'Minimum 8 character required'
                ]
            );

            if ($validated->fails()) {
                
                return response()->json(['status' => 'Failed', 'message' => $validated->errors()], 403);
            }
           
           
            
            

           
            echo 'No error till now';
             User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password')

            ]);
           // DB::table('users')->insert($request->input());

            return response()->json([
                "status" => "successfull",
                "message" => "Your response has been submitted"
            ], 200);
        } catch (Exception $e) {
            
            return response()->json([
                "status" =>   $e,
                "message" => "Registartion Failed"
            ], 400);
        }
    }

    //User Login method
    function Login(Request $request)
    {

        try {

            $count = User::where('email', '=', $request->input('email'))
                ->where('password', '=', $request->input('password'))
                ->select('id')->first();


            if ($count !== null) {
                $token = JWT_TOKEN::create_token($request->input('email'),$count->id);
                return response()->json([
                    'status' => 'successfull',
                    'message' => 'Login Successfull',
                    'token' => $token
                ])->cookie('token',$token,60*24*30);
            }
        } catch (Exception $e) {

            return response()->json([
                'status' => 'Failed',
                'message' => 'Either the email or password is incorrect'
            ], 401);
        }
    }


    function sendOTP(Request $request)
    {

        $email = $request->input('email');
        $count = User::where('email', '=', $email)->count();
        $otp = rand(1000, 9999);
        if ($count == 1) {
            //sed OTP to user email
            Mail::to($email)->send(new OTPmail($otp));
            //update the otp in record
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => "4 digit OTP has been sent to $email. please check your email "
            ],200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        try {
            //Otp length validation
            $validator = Validator::make($request->all(), [
                'otp' => 'required|min:4',
            ], [
                'otp' => 'Otp Must be 4 Characters',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'Failed', 'message' => $validator->errors()], 400);
            }

            $otp = $request->otp;
            $email = $request->email;

            $user = User::where('email', $email)->where('otp', $otp)->first();

            //user find based on email & otp
            if (!$user) {
                return response()->json(['status' => 'Failed', 'message' => 'Please enter a valid otp'], 400);
            }



            //Otp expired after 5 minutes
            $expirationTime = strtotime($user->updated_at) + ((60 * 3) + 5);
            if (time() > $expirationTime) {
                //otp update
                $user->update(['otp' => 0]);
                return response()->json(['status' => 'Failed', 'message' => 'Your Otp expired'], 400);
            }
            //otp update
            $user->update(['otp' => 0]);
            //create password reset token
            $reset_token = JWT_TOKEN::reset_token($email);
            return response()->json(['status' => 'success', 'message' => "Your Otp verify Successfully"], 200)->cookie('token',$reset_token,60*24*30);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json(['status' => 'Failed', 'message' => 'Database connection error'], 500);
        } catch (\Throwable $th) {

            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 500);
        }
        
    }



function resetPassword(Request $request)
{

    try {

        //password Validation.Must contain Lowercase and Upercase letters

        $validated = Validator::make(
            $request->all(),
            [
                'password ' => ['required|confirmed|min:8']
            ],
            [
                'password' => 'Password must have of altleast 8 characters '

            ]
        );

        if ($validated->failed()) {
            return response()->json(['status' => 'Failed', 'message' => $validated->errors()], 400);
        }

        $email = $request->header('email');
        echo $email;
       $user =  User::where('email', '=', $email)->update(['password' => $request->password]);
       if($user){ return response()->json(['status' => 'success', 'message' => 'Password Update Successfully'], 200);}
    } catch (Throwable $th) {

        return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 500);
    }
}

function userRegistrationView():View{

    return view('pages.auth.registration-page');
    
}
function userLoginView():View{
    return view('pages.auth.login-page');
}

function sendOTPview():View{
    return view('pages.auth.send-otp-page');
}

function verifyOTPview():View{   
    return view('pages.auth.verify-otp-page');
}
function resetPasswordview():View{
    return view('pages.auth.reset-password-page');
}

function profilePageView(){
    return View('pages.Dashboard.profile-page');
}

function userProfile(Request $request){

    $email=$request->header('email');
    $user=User::where('email','=',$email)->first();
    return response()->json([
        'status' => 'success',
        'message' => 'Request Successful',
        'data' => $user
    ],200);
}

function updateProfile(Request $request){
    sleep(10);
    try{


        $email = $request->header('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $mobile = $request->input('mobile');
        $password = $request->input('password');
    
        $user = User::where('email','=',$email)->update([
    
            'firstName'=>$firstName,
            'lastName'=>$lastName,
             'mobile'=>$mobile,
            'password'=>$password
        ],200);
    
        return response()->json([
              'status'=>'success',
              'message'=>'profile update successfull'
    
        ],200);
    
    }  
    catch(Exception){
        return response()->json([
            'status'=>'failed',
            'message'=>'Something went wrong'
  
      ],500);
    }
   


}

}
