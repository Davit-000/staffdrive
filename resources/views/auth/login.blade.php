@extends('layouts.app')

@section('content')
  <div class="uk-container">
    <form method="POST" action="{{ route('login') }}" class="uk-form-stacked uk-flex uk-flex-center">
      <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
          <h3 class="uk-card-title">{{ __('Login') }}</h3>
        </div>
        <div class="uk-card-body">
          @csrf

          <div class="uk-margin">
            <label class="uk-form-label" for="email">{{ __('E-Mail Address') }}</label>
            <div class="uk-form-controls">
              <input class="uk-input @error('email') uk-form-danger @enderror" id="email" name="email"
                     value="{{ old('email') }}" type="email"
                     placeholder="E-mail address...">
              @error('email')
              <div class="uk-form-controls-text uk-text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label" for="password">{{ __('Password') }}</label>
            <div class="uk-form-controls">
              <input class="uk-input @error('password') uk-form-danger @enderror" id="password" name="password"
                     type="password" placeholder="Password...">
              @error('password')
              <div class="uk-form-controls-text uk-text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="uk-margin">
            <label>
              <input class="uk-checkbox" type="checkbox"  name="remember"
                     id="remember" {{ old('remember') ? 'checked' : '' }}>
              {{ __('Remember Me') }}
            </label>
          </div>
        </div>
        <div class="uk-card-footer">
          <button type="submit" class="uk-button uk-button-primary">{{ __('Login') }}</button>
        </div>
      </div>
    </form>
  </div>
@endsection
