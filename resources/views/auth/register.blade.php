@extends('guest-layout.layout')
@section('main')
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 border">
    <div class="p-3 auth-form">
    <h1 class="text-center">Register</h1>
    <div class="mt-5 register-form">
        @php
            $email = (old('email') != null) ? old('email') : '';
            $name = (old('name') != null) ? old('name') : '';
        @endphp
        <form method="post" action="{{ route('auth.register_account') }}">
            @csrf
            <!-- Name -->
            <div class="row">
                <div class="col">
                    <input
                        type="name"
                        name="name"
                        class="form-control form-control-lg"
                        placeholder="Name"
                        required
                        autofocus
                        value="{{ $name }}"
                    >
                </div>
            </div>

            <!-- Email -->
            <div class="row mt-3">
                <div class="col">
                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        placeholder="Email"
                        required
                        autocomplete="email"
                        value="{{ $email }}"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="password" class="form-control form-control-lg"  placeholder="Password" required autocomplete="current-password">
                </div>
            </div>

            @if ($errors->any())
                <div class="row mt-3">
                    <div class="alert alert-danger col">
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
                    <input type="submit" value="Sign up" class="btn btn-primary">
                </div>
            </div>
        </form>
    <div>
</div>
    </div>
</div>
@endsection
