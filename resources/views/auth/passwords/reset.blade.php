@section('title', 'Resetta il tuo password')
@extends('layout')

@section('content')
	<h1>@yield('title')</h1>
	<div>
		<form method="POST" action="{{ route('password.update') }}">
			@csrf

			<input type="hidden" name="token" value="{{ $token }}">

			<div class="field-wrapper">
				<label for="email">{{ __('Email Address') }}</label>
				<input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="field-wrapper">
				<label for="password">{{ __('Password') }}</label>
				<input type="password" name="password" id="password" required autocomplete="new-password">

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="field-wrapper">
				<label for="password-confirm">{{ __('Confirm Password') }}</label>
				<input type="password" name="password_confirmation" id="password-confirm" required autocomplete="new-password">
			</div>

			<div class="field-wrapper">
				<button type="submit" class="btn btn-primary" title="{{ __('Reset Password') }}">{{ __('Reset Password') }}</button>
			</div>
		</form>
	</div>
@endsection
