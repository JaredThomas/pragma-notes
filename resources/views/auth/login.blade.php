@extends('layouts.app')

@section('content')
<h2 class="text-green-700 py-4 text-2xl text-center">{{ __('Login') }}</h2>

<form method="POST" action="{{ route('login') }}" class="bg-white rounded shadow p-4 w-full md:w-3/4 lg:w-1/2 mx-auto">
    @csrf

    @component( 'components.label', ['for' => 'email'] )
        {{ __('E-Mail Address') }}
    @endcomponent
    @error('email')
        @component( 'components.input-error' )
            {{ $message }}
        @endcomponent
    @enderror
    @component( 'components.input' )
        id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
    @endcomponent

    <label for="password" class="text-gray-800">{{ __('Password') }}</label>
    <input id="password" type="password" class="block mb-4 border p-2 border-gray-300 rounded w-full" name="password" required autocomplete="current-password">
    @error('password')
        <span role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="flex items-center">
        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="inline-block ml-2 text-gray-800" for="remember">
            {{ __('Remember Me') }}
        </label>
    </div>

    <button type="submit" class="my-4 rounded px-8 py-2 bg-blue-500 text-white hover:bg-blue-400 cursor-pointer block">
        {{ __('Login') }}
    </button>

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="underline text-blue-600 hover:text-blue-400">
            {{ __('Forgot Your Password?') }}
        </a>
    @endif
</form>
@endsection
