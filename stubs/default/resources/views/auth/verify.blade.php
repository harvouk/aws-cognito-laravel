@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <main class="form-signin text-center">
        <form method="post" action="{{route('verify')}}">
            <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Verify Email</h1>
            <p class="text-center">Thanks for registering, we have sent you a verification code in your email. Please enter it here:</p>
            <div class="form-floating">
                <input type="text" name="verification_code" class="form-control" id="floatingInput" placeholder="Verification Code">
                <label for="floatingInput">Verification Code</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Verify</button>
            <p class="mt-5 mb-3 text-muted">&copy; {{date('Y')}}</p>
        </form>
    </main>

@endsection
