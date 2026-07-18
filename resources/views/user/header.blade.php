<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Hospital care center for appointments, doctors, and patient support.">
  <title>Hospital | Care when you need it</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/maicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/hospital-home.css') }}">
</head>
<body>
  <header class="hospital-header">
    <div class="container">
      <nav class="hospital-nav" aria-label="Primary navigation">
        <a class="hospital-brand" href="{{ url('/') }}">
          <span class="brand-mark" aria-hidden="true"><span class="mai-pulse"></span></span>
          <span class="brand-copy">
            <strong>Hospital</strong>
            <small>care center</small>
          </span>
        </a>

        <button class="navbar-toggler hospital-menu-toggle" type="button" data-toggle="collapse" data-target="#hospitalNavigation" aria-controls="hospitalNavigation" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mai-menu"></span>
        </button>

        <div class="collapse navbar-collapse hospital-navigation" id="hospitalNavigation">
          <div class="hospital-links">
            <a class="hospital-link active" href="{{ url('/') }}">Home</a>
            <a class="hospital-link" href="#services">Services</a>
            <a class="hospital-link" href="#doctors">Care team</a>
            <a class="hospital-link" href="#appointment">Appointments</a>
          </div>

          <div class="hospital-actions">
            @auth
              <a class="hospital-account-link" href="{{ url('myappointment') }}">My appointments</a>
            @else
              <a class="hospital-account-link" href="{{ route('login') }}">Sign in</a>
              @if (Route::has('register'))
                <a class="hospital-button hospital-button-small" href="{{ route('register') }}">Create account <span class="mai-arrow-forward" aria-hidden="true"></span></a>
              @endif
            @endauth
          </div>
        </div>
      </nav>
    </div>
  </header>
