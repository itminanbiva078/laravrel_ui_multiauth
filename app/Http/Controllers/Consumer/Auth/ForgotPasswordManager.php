<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Merchant\MerchantPasswordResetLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Merchant\MerchantUser;
class ForgotPasswordManager extends Controller
{
   public function forgotPassword(){
      return view('merchant.auth.forgot-password');
   }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:merchant_users'
        ]);
        $token = Str::random('64');
        if (MerchantUser::where('email', $request->email)->exists()) {
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);
            Mail::to($request->email)->send(new MerchantPasswordResetLink($token));
            return redirect()->route('merchant.forgot.password')->with('success', 'We have sent an email to reset your password');

        } else {
            return redirect()->to(route('merchant.forgot.password'))
                ->with('error', 'This email does not exist in our records');
        }
    }

   public function resetPassword($token){
        return view('merchant.auth.new-password',compact('token'));
   }
   public function resetPasswordPost(Request $request){
       $request->validate([
           'email' => 'required|email|exists:merchant_users',
           'password' => 'required|string|min:8|confirmed',
           'password_confirmation' => 'required'
       ]);
      $updatePassword = DB::table('password_resets')->where([
           'email' => $request->email,
           'token' => $request->token,
       ])->first();

      if(!$updatePassword){
          return redirect()->to(route('merchant.forgot.password'))
              ->with('error','Invalid');
      }
      MerchantUser::where('email', $request->email)
           ->update(['password' => Hash::make($request->password)]);

      DB::table('password_resets')->where('email',$request->email)->delete();
       return redirect()->to(route('merchant.login.post'))
           ->with('success','Password reset successfully');
   }
}
