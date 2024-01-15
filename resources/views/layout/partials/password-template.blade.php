<div class="col-sm-6">
    <div class="form-group">
        <label for="password">Password <span class="text-danger">*</span>
            <span>
                <i data-toggle="tooltip" data-placement="top" title="Your password should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character."
                   class="fas fa-question-circle">
                </i>
            </span>
        </label>
        <input type="password" wire:model="data.password"
               class="form-control form-control-sm @error('data.password') is-invalid @enderror" id="password"
               name="password" placeholder="Enter Password" autocomplete="new-password">
        @error('data.password')
        <span class="invalid-feedback" role="alert">
            <strong>{{$message}}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control form-control-sm @error('data.password_confirmation') is-invalid @enderror" wire:model="data.password_confirmation"
               id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
        <div class="@if($passwordMatch) text-success @else text-danger @endif">{{ $passwordMatchMessage }}</div>
    </div>
</div>

<div class="col-sm-6">
    @include('layout.partials.password_strength')
</div>




