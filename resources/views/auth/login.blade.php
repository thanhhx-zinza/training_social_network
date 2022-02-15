@extends('layout.layout')

@section('title', 'Login')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
<div class="p-3 auth-form">
    <h1 class="text-center">Welcome</h1>
    <div class="mt-5 login-form">
        @php
            $email = (old('email') != null) ? old('email') : '';
        @endphp
        <form method="post" action="{{ route('auth.authenticate') }}">
            @csrf
            <!-- Email -->
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        placeholder="Email"
                        required autocomplete="email"
                        autofocus
                        value="{{ $email }}"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="row mt-3">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <input type="password" name="password" class="form-control form-control-lg"  placeholder="Password" required autocomplete="current-password">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            Remember me?
                        </label>
                    </div>
                </div>
                <div class="col-md-5 text-end">
                    <a class="forgot-pass" href="">Forgot password?</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="row mt-3">
                    <div class="col-md-1"></div>
                    <div class="alert alert-danger col-md-10">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row my-5">
                <div class="col text-center">
                    <input type="submit" value="Login" class="btn btn-login">
                </div>
            </div>
        </form>
    <div>
</div>
@endsection
