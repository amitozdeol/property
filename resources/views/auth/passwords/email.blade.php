@extends('layouts.app')

@section('content')

<section class="hero is-primary is-fullheight">
    <div class="hero-body">
        <div class="container">
            @if (session('status'))
                <div class="columns is-centered">
                    <div class="notification column is-success is-5-tablet is-4-desktop">
                        <button class="delete"></button>
                        {{ session('status') }}
                    </div>
                </div>
            @endif
            <div class="columns is-centered">
                <div class="column is-5-tablet is-4-desktop">
                    <form method="POST" action="{{ route('password.email') }}" class="box">
                        @csrf

                        <h1 class="title has-text-black">Reset Password</h1>
                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <button type="submit" class="button is-success">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
