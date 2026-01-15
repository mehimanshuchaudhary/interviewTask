@extends('layouts.guest')

@section('content')
    <div class="mb-4 text-sm text-secondary">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password"
                id="password" placeholder="Enter password" required autocomplete="current-password" />
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">Confirm</button>
        </div>
    </form>
@endsection
