<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

use App\Libraries\Sendpulse\RestApi\ApiClient;
use App\Libraries\Sendpulse\RestApi\Storage\FileStorage;

use App\Jobs\SendEmailJob;
use App\Models\Customer;

use Carbon\Carbon;
use Auth;
use DB;
use Session;
use Validator;

class CustomerController extends BaseController{
    public function indexSignIn(Request $request){
        if(Auth::check()){
            return redirect('#account');
        }else{
            return view('pages/account/sign-in');
        }
    }

    public function indexSignUp(Request $request){
        if(Auth::check()){
            return redirect('#account');
        }else{
            return view('pages/account/sign-up');
        }
    }

    public function indexForgotPassword(Request $request){
        if(Auth::check()){
            return redirect('#account');
        }else{
            return view('pages/account/forgot-password');
        }
    }

    public function indexGift(Request $request){
        return view('pages/account/gift');
    }

    public function indexChangeForgotPassword(Request $request, $email = null, $key = null){
        if($customer = Customer::where(['customer_email' => $email, 'customer_key' => $key])->first()){
            return view('pages/account/change-forgot-password', compact('email', 'key'));
        }else{
            return abort(404);
        }
    }

    public function indexAccount(Request $request){
        return view('pages/account/account');
    }

    public function indexEditProfile(Request $request){
        $customer = Auth::user();
        return view('pages/account/edit-profile', compact('customer'));
    }

    public function indexChangePassword(Request $request){
        return view('pages/account/change-password');
    }

    public function actionRegister(Request $request){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required',
            'customer_birthday' => 'required',
            'customer_gender' => 'required',
            'customer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }
        
        $customer = Auth::user();
        $customer->customer_name        = $input->customer_name;
        $customer->customer_phone       = $input->customer_phone;
        $customer->customer_birthday    = $input->customer_birthday;
        $customer->customer_gender      = $input->customer_gender;
        $customer->customer_address     = $input->customer_address;
        $customer->customer_institution = $input->customer_institution;
        $customer->customer_status      = 2;
        $customer->save();

        return ['status' => 200, 'message' => 'Your register successfully'];
    }

    public function actionSubscribe(Request $request, $email){
        $API_USER_ID = env('SENDPULSE_API_USER_ID', '');
        $API_SECRET = env('SENDPULSE_API_SECRET', '');
        $SPApiClient = new ApiClient($API_USER_ID, $API_SECRET, new FileStorage('../storage/sendpulse_token/'));
        $emails[] = $email;
        $SPApiClient->addEmails(1780553, $emails);

        Cookie::queue(Cookie::forever('newsletter', 'true'));
        return ['status' => 200, 'message' => 'Your email added successfully'];
    }

    public function actionEditProfile(Request $request){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:255',
            'customer_birthday' => 'required',
            'customer_gender' => 'required',
            'customer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }
        
        $customer = Auth::user();
        $customer->customer_name        = $input->customer_name;
        $customer->customer_birthday    = $input->customer_birthday;
        $customer->customer_gender      = $input->customer_gender;
        $customer->customer_address     = $input->customer_address;
        $customer->customer_institution = $input->customer_institution;
        $customer->save();

        return ['status' => 200, 'message' => 'Your record saved successfully'];
    }

    public function actionSignIn(Request $request){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email',
            'password' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }

        if (Auth::attempt(['customer_email' => $input->email, 'password' => $input->password], true)) {
            return ['status' => 200, 'message' => 'You signed'];
        }else{
            return ['status' => 201, 'message' => 'Sign in failed'];
        }
    }

    public function actionSignUp(Request $request){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email',
            'password' => 'required|max:255',
            'confirm_password' => 'required|max:255',
        ]);

        if($validator->fails()){
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }

        if($input->password != $input->confirm_password){
            return ['status' => 201, 'message' => 'Confirm password is incorrect'];
        }

        if($customer = Customer::where('customer_email', $input->email)->first()){
            return ['status' => 200, 'message' => 'Your email is already registered, please sign in'];
        }
        $key = md5(uniqid());
        $customer = new Customer;
        $customer->customer_email = $input->email;
        $customer->password = Hash::make($input->password);
        $customer->customer_key = $key;
        $customer->save();

        // Send email to account activation
        // $API_USER_ID = env('SENDPULSE_API_USER_ID', '');
        // $API_SECRET = env('SENDPULSE_API_SECRET', '');
        // $SPApiClient = new ApiClient($API_USER_ID, $API_SECRET, new FileStorage('../storage/sendpulse_token/'));

        $email = $customer->customer_email;

        $plain_content = 'Hi,
        \n \n
		Thanks for creating a cahayaagro.com account.\n
		To continue, please confirm your email address by clicking the link below.\n
        '.url('verify').'/'.$email.'/'.$key.'
        \n \n
        Best,
        \n
        Cahaya Agro';
        
        $html_content = view('emails.account-verification', compact('email', 'key'))->render();
        
        $email = array(
            'html' => $html_content,
            'text' => $plain_content,
            'subject' => 'Cahaya Agro Email Activation',
            'from' => array(
                'name' => 'Cahaya Agro',
                'email' => 'no-reply@cahayaagro.com',
            ),
            'to' => array(
                array(
                    'name' => $customer->customer_email,
                    'email' => $customer->customer_email,
                ),
            )
        );

        $emailJob = (new SendEmailJob($email))->delay(Carbon::now()->addSeconds(3));
        dispatch($emailJob);
        // $SPApiClient->smtpSendMail($email);

        if (Auth::attempt(['customer_email' => $input->email, 'password' => $input->password], true)) {
            return ['status' => 200, 'message' => 'You signed'];
        }else{
            return ['status' => 201, 'message' => 'Sign in failed'];
        }
    }

    public function actionResendActivation(Request $request){
        $input = (object) $request->input();

        $customer = Auth::user();

        // Send email to account activation
        // $API_USER_ID = env('SENDPULSE_API_USER_ID', '');
        // $API_SECRET = env('SENDPULSE_API_SECRET', '');
        // $SPApiClient = new ApiClient($API_USER_ID, $API_SECRET, new FileStorage('../storage/sendpulse_token/'));

        $email = $customer->customer_email;
        $key = $customer->customer_key;

        $plain_content = 'Hi,
        \n \n
		Thanks for creating a cahayaagro.com account.\n
		To continue, please confirm your email address by clicking the link below.\n
        '.url('verify').'/'.$email.'/'.$key.'
        \n \n
        Best,
        \n
        Cahaya Agro';
        
        $html_content = view('emails.account-verification', compact('email', 'key'))->render();
        
        $email = array(
            'html' => $html_content,
            'text' => $plain_content,
            'subject' => 'Cahaya Agro Email Activation',
            'from' => array(
                'name' => 'Cahaya Agro',
                'email' => 'no-reply@cahayaagro.com',
            ),
            'to' => array(
                array(
                    'name' => $customer->customer_email,
                    'email' => $customer->customer_email,
                ),
            )
        );

        $emailJob = (new SendEmailJob($email))->delay(Carbon::now()->addSeconds(3));
        dispatch($emailJob);
        // $SPApiClient->smtpSendMail($email);

        return ['status' => 200, 'message' => 'Please check your email'];
    }

    public function actionRequestForgotPassword(Request $request){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email'
        ]);

        if($validator->fails()){
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }

        if($customer = Customer::where('customer_email', $input->email)->first()){
        }else{
            return ['status' => 201, 'message' => 'Account not found'];
        }

        // Send email to account activation
        // $API_USER_ID = env('SENDPULSE_API_USER_ID', '');
        // $API_SECRET = env('SENDPULSE_API_SECRET', '');
        // $SPApiClient = new ApiClient($API_USER_ID, $API_SECRET, new FileStorage('../storage/sendpulse_token/'));

        $email = $customer->customer_email;
        $key = md5(uniqid());
        $customer->customer_key = $key;
        $customer->save();
        
        $plain_content = 'Hi,
        \n \n
		Kami melihat Kamu melakukan permintaan lupa password pada web https://cahayaagro.com.\n
        Untuk melanjutkan, klik link di bawah ini untuk melakukan ubah password Kamu.\n
        '.url('/').'#forgot-password/'.$email.'/'.$key.'\n
        Kamu bisa mengabaikan pesan ini jika Kamu merasa tidak melakukan permintaan lupa password akun Kamu.\n
        \n \n
        Terima kasih,
        \n
        Cahaya Agro';
        
        $html_content = view('emails.account-forgot', compact('key', 'email'))->render();
        
        $email = array(
            'html' => $html_content,
            'text' => $plain_content,
            'subject' => 'Cahaya Agro Forgot Password',
            'from' => array(
                'name' => 'Cahaya Agro',
                'email' => 'no-reply@cahayaagro.com',
            ),
            'to' => array(
                array(
                    'name' => $customer->customer_email,
                    'email' => $customer->customer_email,
                ),
            )
        );

        $emailJob = (new SendEmailJob($email))->delay(Carbon::now()->addSeconds(3));
        dispatch($emailJob);
        // $SPApiClient->smtpSendMail($email);

        return ['status' => 200, 'message' => 'Email sent, please check your email'];
    }

    public function actionSignOut(Request $request){
        Auth::logout();
        return ['status' => 200, 'message' => 'You signout'];
    }

    public function actionChangePassword(Request $request){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255|min:6',
            'confirm_new_password' => 'required|max:255|min:6'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }

        $customer = Auth::user();
        if($input->new_password == $input->confirm_new_password){
            if (Auth::once(['customer_email' => $customer->customer_email, 'password' => $input->old_password])) {
                $customer->password = Hash::make($input->new_password);
                $customer->save();
                return ['status' => 200, 'message' => 'Change password successfully'];
            }else{
                return ['status' => 201, 'message' => 'Your old password is incorrect'];
            }
        }else{
            return ['status' => 201, 'message' => 'Re-type your new password again'];
        }
    }
    
    public function actionChangeForgotPassword(Request $request, $email = null, $key = null){
        $input = (object) $request->input();
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|max:255|min:6',
            'confirm_new_password' => 'required|max:255|min:6'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }

        if($input->new_password == $input->confirm_new_password){
            if($customer = Customer::where(['customer_email' => $email, 'customer_key' => $key])->first()){
                $customer->password = Hash::make($input->new_password);
                $customer->save();
                return ['status' => 200, 'message' => 'Change password successfully, Login with new password'];
            }else{
                return ['status' => 201, 'message' => 'Please try again'];
            }
        }else{
            return ['status' => 201, 'message' => 'Re-type your new password again'];
        }
    }

    public function actionVerify(Request $request, $email = null, $key = null){
        if($customer = Customer::where(['customer_email' => $email, 'customer_key' => $key])->first()){
            $customer->customer_status = 1;
            $customer->save();

            Session::flash('toast-success', 'Go to your profile and please completed the register form');
        }
        return redirect('/');
    }
}