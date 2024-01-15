<?php

namespace App\Traits;

use App\Models\LoginAttempt;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Support\Carbon;

trait LoginAttemptTrait
{
	public function checkCustomLoginAttempt($user, $type)
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$attempts = LoginAttempt::where([
			['email', '=', $user],
//            ['ip','=',$ip],
			['type', '=', $type],
			['created_at', '>=', Carbon::now()->subMinutes(config('basic.maxAttemptInMinutes'))]
		])->orwhere([
			['email', '=', $user],
//            ['ip','=',$ip],
			['type', '=', $type],
			['updated_at', '>=', Carbon::now()]
		])->count();

		return $attempts;
	}

	public function incrementCustomLoginAttempt($user, $type)
	{
		$ip = $_SERVER["REMOTE_ADDR"];

		if ($type == config('setting.user.type.admin')) {
			$userExists = User::where('email', $user)->first();
		}
//        elseif ($type == config('setting.user.type.merchant')) {
//			$userExists = Merchant\MerchantUser::where('username', $user)->first();
//		}
        elseif ($type == config('setting.user.type.user')) {
			dd("User Login");
		}
		if ($userExists) {
			$loginAttempt = new LoginAttempt();
			$loginAttempt->email = $user;
			$loginAttempt->ip = $ip;
			$loginAttempt->type = $type;
			$loginAttempt->save();
		}
	}

	public function clearLoginAttempt($user, $type)
	{
		LoginAttempt::where(['email' => $user, 'type' => $type])->delete();
	}

	public function customFireLockoutEvent($user, $type)
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$maxAttemptInMinutes = config('basic.maxAttemptInMinutes');
		$decayMinutes = config('basic.decayMinutes');
		$calDecayMin = $decayMinutes - $maxAttemptInMinutes;

		$lockStatus = LoginAttempt::where([
			['email', '=', $user],
//            ['ip','=',$ip],
			['type', '=', $type],
			['updated_at', '>=', Carbon::now()]
		]);

		if ($lockStatus->count() < 1) {
			LoginAttempt::where([
				['email', '=', $user],
//                ['ip','=',$ip],
				['type', '=', $type],
				['created_at', '<', Carbon::now()->subMinutes(30)]
			])->delete();

			LoginAttempt::where([
				['email', '=', $user],
//                ['ip','=',$ip],
				['type', '=', $type],
			])->update(['updated_at' => Carbon::now()->addMinutes($calDecayMin)]);

			$lockStatus = LoginAttempt::where([
				['email', '=', $user],
//            ['ip','=',$ip],
				['type', '=', $type],
				['updated_at', '>=', Carbon::now()]
			]);
		}

		$latest = $lockStatus->latest('updated_at')->first();
		if (!$latest) {
			return 0;
		}
		$latestTime = strtotime($latest->updated_at) + (config('basic.maxAttemptInMinutes') * 60);
		$currentTime = strtotime(now());
		return $latestTime - $currentTime;
	}
}
