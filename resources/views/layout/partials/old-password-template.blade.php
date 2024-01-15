<div class="col-xs-12 col-sm-6">
    <div class="form-group">
        <label for="" class="col-form-label">Old Password</label>
        <div class="">
            <input type="password" class="form-control form-control-sm @error('data.old_password') is-invalid @enderror"
                   id="old_password" name="old_password" wire:model="data.old_password" placeholder="Old Password">
            @error('data.old_password')
            <span class="invalid-feedback" role="alert">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-form-label">Password</label>
        <div class="">
            <input type="password" class="form-control form-control-sm @error('data.password') @enderror"
                   id="password" name="password" wire:model="data.password" placeholder="Enter New Password">
            @error('data.password')
            <span class="invalid-feedback" role="alert">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-form-label">Password Confirmation</label>
        <div class="">
            <input type="password" class="form-control form-control-sm @error('data.password_confirmation') is-invalid @enderror"
                   wire:model="data.password_confirmation"
                   id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
            <div class="@if($passwordMatch) text-success @else text-danger @endif">{{ $passwordMatchMessage }}</div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-6">
    @include('layout.partials.password_strength')
</div>

