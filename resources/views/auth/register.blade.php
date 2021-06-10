@extends('layouts.app')

@section('content')

<section class="hero is-info is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5-tablet is-4-desktop">
                    <form method="POST" action="{{ route('register') }}" class="box">
                        @csrf
                        <h1 class="title has-text-black">Register</h1>
                        <div class="field">
                            <label for="name" class="label">Name</label>
                            <div class="control">
                                <input id="name" type="text" name="name" class="input" value="{{ old('name') }}" autocomplete="name" autofocus required>
                            </div>
                            @error('name')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" type="email" name="email" class="input" value="{{ old('email') }}" placeholder="e.g. bobsmith@gmail.com" autocomplete="email" required>
                            </div>
                            @error('email')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="password" class="label">Password</label>
                            <div class="control">
                                <input id="password" type="password" name="password" class="input" placeholder="*******" autocomplete="new-password" required>
                            </div>
                            @error('password')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="password_confirmation" class="label">Confirm Password</label>
                            <div class="control">
                                <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="button is-success">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
