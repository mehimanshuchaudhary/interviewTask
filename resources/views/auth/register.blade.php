@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input class="form-control form-control-lg @error('name') is-invalid @enderror" type="text" name="name"
                id="name" placeholder="Enter your name" value="{{ old('name') }}" required autofocus
                autocomplete="name" />
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email"
                id="email" placeholder="Enter your email" value="{{ old('email') }}" required
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
                name="password" id="password" placeholder="Enter password" required autocomplete="new-password" />
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input class="form-control form-control-lg" type="password" name="password_confirmation"
                id="password_confirmation" placeholder="Confirm password" required autocomplete="new-password" />
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">Sign up</button>
        </div>

        <div class="text-center mt-3">
            Already have an account? <a href="{{ route('login') }}">Log In</a>
        </div>
    </form>
@endsection
