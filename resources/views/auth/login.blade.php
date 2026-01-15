@extends('layouts.guest')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email"
                id="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus
                autocomplete="username" />
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password"
                name="password" id="password" placeholder="Enter your password" required autocomplete="current-password" />
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <small>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </small>
        </div>

        <!-- Remember Me -->
        <div class="mb-3">
            <label class="form-check">
                <input class="form-check-input" type="checkbox" value="remember-me" name="remember" id="remember_me">
                <span class="form-check-label">
                    Remember me next time
                </span>
            </label>
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
        </div>
    </form>
@endsection
