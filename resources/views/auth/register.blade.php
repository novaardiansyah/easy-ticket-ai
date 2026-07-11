@extends('layouts.auth')

@section('title', 'Register')

@section('content')
          <a href="{{ route('landing') }}" class="d-block">
            <img src="{{ url('app-logo-16x9.png') }}" alt="Easy Ticket AI" class="w-100" style="max-height: 100px; object-fit: contain;" />
          </a>

          <p class="login-box-msg">Register a new account</p>

          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif

          <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus />
              <div class="input-group-text">
                <span class="bi bi-envelope"></span>
              </div>
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary py-2">Register</button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small text-decoration-none">Already have an account? Sign In</a>
          </div>

          <hr class="my-4">

          <div class="text-center">
            <a href="{{ route('landing') }}" class="text-decoration-none small">Back to Home</a>
          </div>
@endsection
