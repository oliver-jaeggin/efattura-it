@section('title', 'Login')
@extends('layout')

<?php $users = \App\Models\User::all(); ?>

@section('content')
	@if(count($users) <= 0)

		<script>window.location = "/register";</script>

	@else
		<h1>@yield('title')</h1>
		<div>
			<form action="{{ route('login') }}" method="POST">
				@csrf

				@if ($errors->any())
					<div class="msg msg--error text-code sp-y-s" role="alert">
						@foreach ($errors->all() as $error)
							<p>{{ $error }}</p>
						@endforeach
					</div>
      	@endif

				<div class="field-wrapper flex__grow-2">
					<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
				</div>

				<div class="field-wrapper flex__grow-2">
					<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" required>
				</div>

				<div class="field-wrapper flex__grow-2 sp-y-m">
					<label for="remember" class="flex flex--pos-x-start sp-y-s">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						<p>{{ __('Remember Me') }}</p>
					</label>
				</div>

				<div class="field-group flex flex--wrap flex--pos-x-start flex--gap-row-m flex--gap-col-m">
					<button type="submit" class="btn btn-primary" title="{{ __('Login') }}">{{ __('Login') }}</button>

					@if (Route::has('password.request'))
							<a href="{{ route('password.request') }}" title="{{ __('Forgot Your Password?') }}">{{ __('Forgot Your Password?') }}</a>
					@endif
				</div>
			</form>
		</div>
	@endif
@endsection
