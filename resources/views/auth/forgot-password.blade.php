@extends('layouts.guest')

@section('content')
    <div class="mb-4 text-sm text-secondary">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email"
                id="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus />
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">Email Password Reset Link</button>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </form>
@endsection
