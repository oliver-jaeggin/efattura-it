@section('title', 'Registra utente')
@extends('layout')

@section('content')
<h1>@yield('title')</h1>
<div>
		<form method="POST" action="{{ route('register') }}">
			@csrf

			@if ($errors->any())
				<div class="msg msg--error text-code sp-y-s" role="alert">
					@foreach ($errors->all() as $error)
						<p>{{ $error }}</p>
					@endforeach
				</div>
			@endif

			<div class="field-wrapper">
				<label for="email">{{ __('Email Address') }}</label>
				<input type="email" name="email" id="email" @error('email') class="is-invalid" @enderror value="{{ old('email') }}" autocomplete="email" autofocus required>
			</div>

			<div class="field-wrapper">
				<label for="password">{{ __('Password') }}</label>
				<input type="password" name="password" id="password" @error('password') class="is-invalid" @enderror autocomplete="new-password" required>
			</div>

			<div class="field-wrapper sp-y-s">
				<label for="password-confirm">{{ __('Confirm Password') }}</label>
				<input type="password" name="password_confirmation" id="password-confirm" @error('password_confirmation') class="is-invalid" @enderror autocomplete="new-password" required>
			</div>

			<div class="field-wrapper">
				<button type="submit" class="btn btn-primary sp-y-s" title="{{ __('Register') }}">{{ __('Register') }}</button>
			</div>
		</form>
	</div>
@endsection
