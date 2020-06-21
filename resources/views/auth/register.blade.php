@extends('layouts.app')

@section('content')
  <div class="uk-container">
    <form method="POST" action="{{ route('register') }}" class="uk-form-stacked uk-flex uk-flex-center">
      <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
          <h3 class="uk-card-title">{{ __('Register') }}</h3>
        </div>
        <div class="uk-card-body">
          @csrf

          <div class="uk-margin">
            <label class="uk-form-label" for="name">{{ __('Name') }}</label>
            <div class="uk-form-controls">
              <input class="uk-input @error('name') uk-form-danger @enderror" id="name" name="name"
                     value="{{ old('name') }}" type="text"
                     placeholder="Full name...">
              @error('name')
              <div class="uk-form-controls-text uk-text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

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
            <label class="uk-form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
            <div class="uk-form-controls">
              <input class="uk-input" id="password-confirm" name="password_confirmation" type="password"
                     placeholder="Confirm password...">
            </div>
          </div>
        </div>
        <div class="uk-card-footer">
          <button type="submit" class="uk-button uk-button-primary">{{ __('Register') }}</button>
        </div>
      </div>
    </form>
  </div>
@endsection
