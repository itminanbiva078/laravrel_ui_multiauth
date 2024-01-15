<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\LoginAttemptTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginController extends Controller
{
	use LoginAttemptTrait;

	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	protected $maxAttempts;
	protected $decayMinutes;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest:web')->except('logout');
        $this->maxAttempts = config('basic.maxAttempts');
        $this->decayMinutes = config('basic.decayMinutes');

	}

	public function showLoginForm()
	{
        return view('admin.auth.login');
    }

    function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function username()
    {
        return 'username';
    }

    public function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%i minutes and %s seconds');
    }

    protected function authenticated(Request $request, User $user)
    {
        Auth::logoutOtherDevices($request->password);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $checkCustomLoginAttempt = $this->checkCustomLoginAttempt($request->{$this->username()}, config('setting.user.type.admin'));
        if ($checkCustomLoginAttempt >= config('basic.maxAttempts')) {
            $seconds = $this->customFireLockoutEvent($request->{$this->username()}, config('setting.user.type.admin'));
            $message = [Lang::get('auth.throttle', ['seconds' => $this->secondsToTime($seconds)])];
            return back()->withInput()->withErrors(['password' => $message]);
        }
        if ($this->attemptLogin($request)) {
            $user = Auth::user();

//            if ($user->is_active == config('setting.status.inactive')) {
//                $this->incrementCustomLoginAttempt($request->{$this->username()}, config('setting.user.type.admin'));
//                $this->authAccessLog($request, 403); //403 = INACTIVE
//                Auth::logout();
//                return back()->withInput()->withErrors([$this->username() => 'Account is deactivated']);
//            }

            $this->authAccessLog($request, 200);
            $this->clearLoginAttempt($request->{$this->username()}, config('setting.user.type.admin'));

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementCustomLoginAttempt($request->{$this->username()}, config('setting.user.type.admin'));

        $this->authAccessLog($request, 401);
        return $this->sendFailedLoginResponse($request);
    }

    protected function authAccessLog($request, $status)
    {
        $ip = $request->getClientIp();
        $logId = Str::uuid()->toString();
        $date = date('Y-m-d h:i:s a');
        $method = $request->getMethod();
        $url = $method . '-' . $request->fullUrl();

        $logWrite = " AUTHENTICATION LOG
		IP : \t {$ip}
		DATE : \t {$date}
		LOG_ID : \t {$logId}
		REQUEST_URL : \t {$url}
		USER_EMAIL : \t {$request->{$this->username()}}
		STATUS : \t {$status}
		";

        Log::notice($logWrite);
    }

}
