@extends('layouts.loginLayout')

@section('content')
<div class="row flex-grow">
  <div class="col-lg-5 mx-auto">
    <div class="auth-form-light text-left p-5">
      <div class="brand-logo">
        {{--  <img src="{{ asset('images/logo.svg') }}">  --}}
      </div>
      <h4>Hello! lets get started</h4>
      <h6 class="font-weight-light">Sign in to continue.</h6>

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" style="font-size: 5px" role="alert">
        <p style="">{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @elseif ($error = Session::get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <form class="pt-3" action="{{ route('todo-login') }}" method="POST">
        @csrf
        <div class="form-group">
          <input type="text" name="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" autocomplete="off">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn form-control">SIGN IN</a>
        </div>
        <div class="my-2 d-flex justify-content-between align-items-center">
          <div class="form-check">
            <label class="form-check-label text-muted">
              <input type="checkbox" class="form-check-input" name="remember"> Remember Me </label>
          </div>
        </div>
        <div class="text-center mt-4 font-weight-light"> Dont have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection