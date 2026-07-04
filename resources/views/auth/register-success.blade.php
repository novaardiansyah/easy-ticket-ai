@extends('layouts.auth')

@section('title', 'Check Your Email')
@section('card-body-class', 'text-center')

@section('content')
          <div class="my-4">
            <i class="bi bi-envelope-check text-primary" style="font-size: 4rem;"></i>
          </div>
          
          <h4 class="mb-3 fw-bold text-dark">Check Your Email</h4>
          
          <p class="text-secondary mb-4">
            We have sent a registration link to your email address. Please check your inbox and click the link to complete your account setup.
          </p>

          <div class="d-grid gap-2">
            <a href="{{ route('login') }}" class="btn btn-primary py-2">Back to Login</a>
          </div>
@endsection
