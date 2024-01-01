@extends('layout/secondary')
@section('title', 'Sign in · Innovation Chamber')
@section('content')
<!-- Login -->
<div class="container login">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card shadow" style="border-radius: 0%;">
        <div class="text-center py-4">
          <img src="/data/asset/Logo innovation chamber.png" height="50px" alt="">
        </div>
        <div class="card-body">
          @if (session('error'))
            <div class="alert alert-danger text-center">
              {{ session('error') }}
            </div>
          @elseif(session('status'))
            <div class="alert alert-danger text-center">
              {{ session('status') }}
            </div>
          @endif
          <form method="POST" action="{{ route('login') }}">
          @csrf
            <div class="form-group">
              <label for="employeeid">Employee ID</label>
              <input type="text" name="employeeid" class="form-control @error('employeeid') is-invalid @enderror" id="employeeid" value="{{ old('employeeid') }}" placeholder="Employee ID">
              @error('employeeid')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
              @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group form-check ml-2">
              <input type="checkbox" class="form-check-input" name="rememberme" id="rememberme">
              <label class="form-check-label" for="rememberme">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-2">Sign in</button>
          </form>
          <div class="text-center">
            <a href="{{ route('forgot') }}">Forgot password?</a>
          </div>
        </div>
        <div class="card-footer text-center">
          Don't have account? <a class="" href="{{ route('register') }}">Sign up</a>
        </div>
      </div>
    </div>
  </div>  
</div>
<!-- End Login -->
@endsection