@extends('layouts.loginLayout')

@section('content')
<div class="row flex-grow">
  <div class="col-lg-5 mx-auto">
    <div class="auth-form-light text-left p-5">
      <div class="brand-logo">
        {{--  <img src="../../assets/images/logo.svg">  --}}
      </div>
      <h4>New here?</h4>
      <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
      <form class="pt-3" action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" id="exampleInputUsername1" placeholder="Name" value="{{ old('name') }}">
          @error('name')
          <div class="text-danger mt-2">
            {{ $message }}
          </div>
        @enderror
        </div>
        <div class="form-group">
          <input type="text" name="username" class="form-control form-control-lg @error('username') is-invalid @enderror" id="exampleInputUsername1" placeholder="Username" value="{{ old('username') }}">
          @error('username')
            <div class="text-danger mt-2">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password" value="{{ old('password') }}">
          @error('password')
          <div class="text-danger mt-2">
            {{ $message }}
          </div>
        @enderror
        </div>
        <div class="form-group">
          <input type="password" name="confirm_password" class="form-control form-control-lg @error('confirm_password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Confirm Password" value="{{ old('confirm_password') }}">
          @error('confirm_password')
          <div class="text-danger mt-2">
            {{ $message }}
          </div>
        @enderror
        </div>
        <div class="mb-4">
          <div class="form-check">
            <label class="form-check-label text-muted">
              <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn form-control">SIGN UP</button>
        </div>
        <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection