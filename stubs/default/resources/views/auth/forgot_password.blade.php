@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <main class="form-signin text-center">
        <form method="post" action="{{route('forgot_password')}}">
            @csrf
            <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Forgotten Password</h1>
            <p class="text-center">Can't remember your password, reset it below</p>
            <div class="form-floating">
                <input type="email" name="username" class="form-control" id="floatingInput" placeholder="Username">
                <label for="floatingInput">Username</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Reset Password</button>
            <p class="mt-5 mb-3 text-muted">&copy; {{date('Y')}}</p>
        </form>
    </main>

@endsection
