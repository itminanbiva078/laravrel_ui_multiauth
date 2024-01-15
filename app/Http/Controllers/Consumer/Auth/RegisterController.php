<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Merchant\MerchantBankDetail;
use App\Models\Merchant\MerchantDocument;
use App\Models\Merchant\MerchantProfile;
use App\Models\Password;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\Merchant\MerchantHelperTrait;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Setting;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, MerchantHelperTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::MERCHANT;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegisterForm()
	{
          $value = Cache::rememberForever('webSignup', function () {
			$settings = Setting::where('id', config('setting.index.merchant'))->first();
			$settings = json_decode($settings->details, true);
			return $settings['webSignup'];
		});

		abort_if(!$value, 417, 'Sorry, registration is not available right now. Please try again later.');

		return view('merchant.auth.register');
	}

	public function register(Request $request)
	{
		$this->validator($request->all())->validate();

		event(new Registered($merchant = $this->create($request->all())));

		$this->guard()->login($merchant);

		if ($response = $this->registered($request, $merchant)) {
			return $response;
		}

		return $request->wantsJson()
			? new JsonResponse([], 201)
			: redirect($this->redirectPath());
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'alpha_dash', 'min:5', 'max:30', 'unique:merchant_users'],
            'email' => ['required', 'email:rfc,dns', 'max:100', 'unique:merchant_users'],
//            'contact' => ['required', 'digits:11', 'regex:/01[3456789]{1}[0-9]{8}/'],
            'contact' => ['required', 'max:16', 'regex:/([+]{1})?[0-9]{3,15}$/', 'unique:merchant_users'],
            'url' => ['required', 'string', 'url'],
            'referral_input' => ['nullable', 'string', 'alpha_dash', 'max:16'],
            'merchant_name' => ['required', 'string', 'min:5', 'max:50', 'regex:/(^([a-z A-Z\.\p{Bengali}]+)(\d+)?$)/u'],
            'password' => ['required', 'string', 'min:10', 'max:30', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Merchant\MerchantUser
     */
    protected function create(array $data)
    {
        $role = Role::findByName('Admin', 'merchant');
        abort_if(!$role, '417', 'Can not register at this moment. Please try again after some time');

		$tempPass = bcrypt($data['password']);
		$merchant = new Merchant();
		$merchant->wmx_id = uniqid('WMX');
		$merchant->url = $data['url'];
        $merchant->referral_input = $data['referral_input'];
        $merchant->signup_type = config('setting.merchant_signup_type.web');
		$merchant->is_active = config('setting.status.active');

        if(config('setting.sandbox')){
            $merchant->is_verified = config('setting.boolean.yes');
        }
		$merchant->save();

        $user = new Merchant\MerchantUser();
        $user->merchant_id = $merchant->id;
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->contact = $data['contact'];
        $user->password = $tempPass;
        $user->save();
        $user->assignRole($role);

		$this->merchantProfileCreate($merchant->id, $user, $tempPass, $data['merchant_name']);
		return $user;
    }

	protected function guard()
	{
		return Auth::guard('merchant');
	}
}
