<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\Notification;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
use Hash;
use Carbon\Carbon;
use App\helpers\SMS;


class RegisterController extends Controller
{






    public function showRegisterForm(){
        return view('user.register');
     }
    public function register(Request $request)
    {	

      
    	$this->validate($request,[
    		'name'    =>'required',
    		'phone'   =>'required|unique:users,phone|max:11|min:11',
    		'password'=>'required | min: 4',
            'is_shopowner'=>'required',
    	],[
            'name.required'=>'Provide your name',
            'phone.required'=>'Provide your phone number',
            'phone.unique'=>'This phone number is already used',
            'password.required'=>'Provide password',
            'is_shopowner.required'=>'provide your business',
        ]);


        $varifycode=rand(10000,99999);

        $user=User::create([
            'name'         =>$request->name,
            'phone'        =>$request->phone,
            'verifycode'   =>$varifycode,
            'password'     =>Hash::make($request->password),
            'ref_user'     =>str_replace(' ', '', strtolower($request->name)).rand(1000,9999),
            'shopname'     =>$request->shopname, 
            'location'     =>$request->location, 
            'businesstype' =>$request->businesstype, 
            'is_shopowner' =>$request->is_shopowner,
            'selling_way'  =>$request->selling_way,
            'businessname' =>$request->businessname,
            'parentuser'   =>$request->parentuser, 
        ]);


          Session::put('user_id',$user->id);
          $message="Welcome to neoseller.com.Your OTP code: ".$varifycode.", Use this for signup completion and get bonus 150 taka. It will expire in 10 minutes";

       //===sms code here====
        $to=$request->phone;
        $get=SMS::sendSms(urlencode($message),$to);

        if ($get) {
            Session::flash('rmessage', 'You have been send verification code in '.$request->phone);
            return redirect('user/verifycode');

        }else{
            Session::flash('rmessage', 'Something wents wrong. Please try again');
            return back();
        }

    }

    // verify code
    public function verifycode()
    {

        return view('user.verification');
    }

    //===active account===
    public function activeaccount(Request $request)
    {

     $user=User::where('verifycode',$request->verifycode)->first();
     if (!is_null($user)) {

            $updated = new Carbon($user->updated_at);

             $now = Carbon::now();
             $diff_in_minutes = $now->diffInMinutes($updated);

             if($diff_in_minutes > 10){
              Session::flash('errormessage', 'Your OTP code has been expired. You can resend another OTP');
      
                return back();
             }else{
                $incomebalance=$user->incomebalance;
                $incomebalance +=150;
                $user->useractive=1;
                $user->verifycode=NULL;
                $user->incomebalance=$incomebalance;
                $user->save();
                // sms====
            $message="Welcome to neoseller.com.bd. Your account has been activated successfully and taka 150 is add in your main balance. Thank you.";
            $to=$user->phone;
               $get=SMS::sendSms(urlencode($message),$to);
               if ($get) {
                Session::put('user_id',NULL);
                    Session::flash('rmessage', 'Your account has been activated. Log in now');
                  return redirect('user/login');
               }else{

                Session::flash('errormessage', 'Your account has been activated. Log in now');
                return back();
               }


               
             }
     }else{
        Session::flash('errormessage', 'You have entered wrong code.');
        return back();
     }
        

    }

    //===resend code===

    public function resendcode(){

            if (Session::has('user_id') !=NULL) {
                $userid= Session::get('user_id');
                $user=User::where('id',$userid)->first();

                $verifycode=rand(10000,99999);

                $user->verifycode=$verifycode;
                $user->save();

                 $message="Welcome to neoseller.com.Your OTP code: ".$verifycode.", Use this for signup completion, It will expire in 10 minutes";

                //===sms code here====
                 $to=$user->phone;
                 $get=SMS::sendSms(urlencode($message),$to);

                 if ($get) {
                     //Session::put('user_id',NULL);
                     Session::flash('rmessage', 'New Verify code has been send in your phone');
                        return back();
                 }else{
                    Session::flash('errormessage', 'Something went wrong. Contact with admin');
                      return back();
                 }

               
            }else{
                Session::flash('errormessage', 'Something went wrong. Contact with admin');
                return back();
            }
           

        
    }





     public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_verification_email == 1)
            {       
        $user = User::where('verification_link','=',$token)->first();
        if(isset($user))
        {
            $user->email_verified = 'Yes';
            $user->update();
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->save();
            Auth::guard('web')->login($user); 
            return redirect()->route('user-dashboard')->with('success','Email Verified Successfully');
        }
            }
            else {
            return redirect()->back();  
            }
    }
}
