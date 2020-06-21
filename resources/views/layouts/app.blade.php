<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
  <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
    <div class="uk-navbar-left">

      <a class="uk-navbar-item uk-logo uk-text-uppercase uk-text-bold" style="color: #25243D;" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
      </a>
    </div>

    <div class="uk-navbar-right">
      <div class="uk-navbar-item">
        <form class="uk-search uk-search-default" action="javascript:void(0)">
          <input class="uk-search-input" type="search" placeholder="SEARCH">
          <span class="uk-search-icon-flip" uk-search-icon></span>
        </form>
      </div>

      <ul class="uk-navbar-nav uk-margin-small-right">
        @guest
        <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
        <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
        @else
        <li>
          <button type="button" class="uk-button uk-button-default">
            {{ Auth::user()->name }} <span uk-icon="icon: triangle-down"></span>
          </button>
          <div class="uk-navbar-dropdown" uk-dropdown="offset: 10; mode: click">
            <ul class="uk-nav uk-navbar-dropdown-nav">
              <li class="uk-active">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </li>
        @endguest
      </ul>
    </div>
  </nav>

  <main class="py-4">
    @yield('content')
  </main>
</div>
</body>
</html>
