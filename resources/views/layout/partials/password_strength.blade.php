{{--You must use id="password"  && id="password_confirmation" <div id="msg"></div> below password confrim--}}

<div id="popover-password">
	<ul class="list-unstyled">
		<li class="">1. {{config('basic.password_required_character')}}</li>
		<li class="">2. {{config('basic.password_not_contain_username')}}</li>
		<li class="">3. {{config('basic.password_not_contain_words').implode(', ', config('basic.words'))}}</li>
	</ul>
	<div class="mb-1"><b class="basic-req">{{config('basic.password_three_requirement')}}</b></div>
	<ul class="list-unstyled">
		<li class="">
			@if($capitalChar)
				<span class="upper-case text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
			@else
				<span class="upper-case"><i class="fa fa-times" aria-hidden="true"></i></span>
			@endif
			{{config('basic.password_policy_uppercase')}}
		</li>

		<li class="">
			@if($smallChar)
				<span class="upper-case text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
			@else
				<span class="upper-case"><i class="fa fa-times" aria-hidden="true"></i></span>
			@endif
			{{config('basic.password_policy_lowercase')}}
		</li>

		<li class="">
			@if($numberChar)
				<span class="upper-case text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
			@else
				<span class="upper-case"><i class="fa fa-times" aria-hidden="true"></i></span>
			@endif
			{{config('basic.password_policy_number')}}
		</li>

		<li class="">
			@if($specialChar)
				<span class="upper-case text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
			@else
				<span class="upper-case"><i class="fa fa-times" aria-hidden="true"></i></span>
			@endif
			{{config('basic.password_policy_character')}}
		</li>
	</ul>

	@if($strengthValue == 1)
        <div class="mb-2"><b class="pass_str">Password Strength: <span id="result" class="text-danger">{{ $strength }}</span></b></div>
		<div class="progress">
			<div id="password-strength" class="progress-bar progress-bar-danger"
				 role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
				 style="width:10%">
			</div>
		</div>
	@elseif($strengthValue == 2)
        <div class="mb-2"><b class="pass_str">Password Strength: <span id="result" class="good">{{ $strength }}</span></b></div>
		<div class="progress">
			<div id="password-strength" class="progress-bar progress-bar-warning"
				 role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
				 style="width:60%">
			</div>
		</div>
	@elseif($strengthValue == 3)
        <div class="mb-2"><b class="pass_str">Password Strength: <span id="result" class="better text-success">{{ $strength }}</span></b></div>
		<div class="progress">
			<div id="password-strength" class="progress-bar progress-bar-success"
				 role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
				 style="width:85%">
			</div>
		</div>
	@elseif($strengthValue == 4)
        <div class="mb-2"><b class="pass_str">Password Strength: <span id="result" class="strong text-success">{{ $strength }}</span></b></div>
		<div class="progress">
			<div id="password-strength" class="progress-bar progress-bar-success"
				 role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
				 style="width:100%">
			</div>
		</div>
	@else
        <div class="mb-2"><b class="pass_str">Password Strength: <span id="result">{{ $strength }}</span></b></div>
		<div class="progress">
			<div id="password-strength" class="progress-bar progress-bar-success"
				 role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
				 style="width:0%">
			</div>
		</div>
	@endif
</div>
