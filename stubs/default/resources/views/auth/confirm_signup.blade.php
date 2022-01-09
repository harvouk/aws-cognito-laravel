@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <main class="form-signin text-center">
        <form method="post" action="{{route('confirm_signup')}}">
            <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Confirm Sign-up</h1>
            <p class="text-center">Thanks for registering, we have sent you a confirmation code in your email. Please enter it here:</p>
            <div class="form-floating">
                <input type="email" name="username" class="form-control" id="floatingInput" placeholder="Username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="text" name="confirmation_code" class="form-control" id="floatingInput" placeholder="Confirmation Code">
                <label for="floatingInput">Confirmation Code</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Confirm</button>
            <p class="mt-5 mb-3 text-muted">&copy; {{date('Y')}}</p>
        </form>
    </main>

@endsection
