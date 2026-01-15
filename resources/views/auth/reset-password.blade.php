@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email"
                id="email" placeholder="Enter your email" value="{{ old('email', $request->email) }}" required autofocus
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
                name="password" id="password" placeholder="Enter new password" required autocomplete="new-password" />
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
                id="password_confirmation" placeholder="Confirm new password" required autocomplete="new-password" />
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">Reset Password</button>
        </div>
    </form>
@endsection
