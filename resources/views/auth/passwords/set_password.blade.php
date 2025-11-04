@extends('auth.auth-page', ['authType' => 'login'])

@section('auth_header', 'Set Your Password')

@section('auth_body')
    <form action="{{ route('password.set.update') }}" method="post">
        @csrf

        {{-- Email field --}}
        <input type="hidden" name="user_id" class="form-control" value="{{ old('user_id', $user_id) }}">
        <input type="hidden" name="email" class="form-control" value="{{ old('email', $email) }}">

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('adminlte::adminlte.password') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password confirmation field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="{{ trans('adminlte::adminlte.retype_password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Set password button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-sync-alt mr-2"></span> Set Password
        </button>
    </form>
@stop
