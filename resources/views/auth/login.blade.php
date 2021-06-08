@extends('layouts.app')

@section('content')

<section class="hero is-primary is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                    <form method="POST" action="{{ route('login') }}" class="box">
                        @csrf
                        <h1 class="title has-text-black">Login</h1>
                        <div class="field">
                            <label for="" class="label">Email</label>
                            <div class="control">
                                <input type="email" name="email" placeholder="e.g. bobsmith@gmail.com" class="input" required>
                            </div>
                            @error('email')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="" class="label">Password</label>
                            <div class="control">
                                <input type="password" name="password" placeholder="*******" class="input" required>
                            </div>
                            @error('password')
                                <p class="help is-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="" class="checkbox">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                Remember me
                            </label>
                        </div>
                        <div class="field is-flex is-justify-content-space-between is-align-items-center">
                            <button type="submit" class="button is-success">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="has-text-grey" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
