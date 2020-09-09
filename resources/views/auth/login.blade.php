@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh">
        <div class="col-md-8 align-self-center">
            <div class="card w-50 m-auto shadow" style="border-radius: 1.5rem">
              <div class="card-header text-center">
                <h2>Login</h2>
              </div>
              <div class="card-body my-2">
                  <form method="POST" action="{{ route('login') }}">
                      @csrf

                    @if(session('nonaktif'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ session('nonaktif') }}</strong>
                    </span>
                    @endif
                      <div class="form-group col">
                          <label for="email" class="ml-1">{{ __('E-Mail Address') }}</label>

                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>

                      <div class="form-group col">
                          <label for="password" class="ml-1">{{ __('Password') }}</label>

                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>

                      <div class="form-group col">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                              {{ __('Remember Me') }}
                          </label>
                        </div>
                      </div>

                      <div class="form-group col mb-0">
                        <button type="submit" class="btn btn-primary w-100">
                          {{ __('Login') }}
                        </button>

                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif --}}
                      </div>
                  </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
