<x-guest-layout>
    @section('title', 'Login')
    <main class="form-guest">
        <a href="{{url('/')}}">
            <img class="mb-4" src="{{url('imgs/formprovider-logo.png')}}" alt="">
        </a>
        <h1 class="h3 mb-3 fw-normal">Sign In</h1>

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" id="email" name="email" value="{{old('email')}}" required>
                <label for="email">{{__('Email Address')}}</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                <label for="password">{{__('Password')}}</label>
            </div>

            <div class="checkbox mb-3 remember-box">
                <label>
                    <input type="checkbox" name="remember"> {{ __('Remember me') }}
                </label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">{{ __('Login') }}</button>
        </form>
        <a class="w-100 btn btn-lg btn-secondary" href="{{ route('register') }}">{{ __('Create an Account') }}</a>

        <div class="checkbox mb-3 remember-box">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <p class="mt-5 mb-3 text-muted">&copy; <?=date('Y')?> {{ config('app.name') }}</p>
    </main>

</x-guest-layout>
