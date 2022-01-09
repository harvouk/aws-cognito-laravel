@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <main class="form-signin text-center">
        <form method="post" action="{{route('register')}}">
            <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Register</h1>

            @forelse(config('cognito.required_fields') as $field=>$validation)

                @if($field == 'username')
                    <div class="form-floating">
                        <input type="email" name="{{$field}}" class="form-control" id="floatingInput" placeholder="{{$field}}">
                        <label for="floatingInput">Email address</label>
                    </div>
                @elseif($field == 'password')
                    <div class="form-floating">
                        <input type="password" name="{{$field}}" class="form-control" id="floatingPassword" placeholder="{{$field}}">
                        <label for="floatingPassword">Password</label>
                    </div>
                @else
                    <div class="form-floating">
                        <input type="text" name="{{$field}}" class="form-control" id="floatingInput" placeholder="{{$field}}">
                        <label for="floatingInput">{{ucfirst(str_replace('_', ' ', $field))}}</label>
                    </div>
                @endif
            @empty
                <p>You must nominated the required fields for Cognito before this form can be displayed.</p>
            @endforelse

            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
            <p class="mt-5 mb-3 text-muted">&copy; {{date('Y')}}</p>
        </form>
    </main>

@endsection
