@section('title', 'Resetta il tuo password')
@extends('layout')

@section('content')
    <h1>@yield('title')</h1>
    <div class="sp-y-m">
			@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
			@endif

			<form method="POST" action="{{ route('password.email') }}">
				@csrf

				<div class="field-wrapper sp-y-s">
					<label for="email">{{ __('Email Address') }}</label>
					<input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>

				<div class="field-wrapper">
					<button type="submit" class="btn btn-primary">{{ __('Send Password Reset Link') }}</button>
				</div>
			</form>
    </div>
@endsection
