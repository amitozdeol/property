@extends('layouts.app')

@section('content')

<section class="hero is-primary is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5-tablet is-4-desktop">
                    <form method="POST" action="{{ route('password.update') }}" class="box">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <h1 class="title has-text-black">Reset Password</h1>
                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" type="email" class="input" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="password" class="label">Password</label>
                            <div class="control">
                                <input id="password" type="password" class="input" placeholder="*******" name="password" required autocomplete="new-password">
                            </div>
                            @error('password')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="password-confirm" class="label">Password Confirm</label>
                            <div class="control">
                                <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="button is-success">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
