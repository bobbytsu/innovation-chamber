@extends('layout/secondary')
@section('title', 'Sign up · Innovation Chamber')
@section('content')
<!-- Register -->
<div class="container register">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow" style="border-radius: 0%;">
        <div class="text-center py-4">
          <img src="/data/asset/Logo RDCX.png" height="50px" alt="">
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('registermaster') }}">
          @csrf
            <div class="form-row">
              <div class="form-group col-lg">
                <label for="employeeid">Employee ID</label>
                <input type="text" name="employeeid" class="form-control @error('employeeid') is-invalid @enderror" id="employeeid" value="{{ old('employeeid') }}" placeholder="Employee ID">
                @error('employeeid')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group col-lg">
                <label for="unit_id">Unit</label>
                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                  <option value="" selected disabled>Select Unit</option>
                @foreach($units as $unit)
                  <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
                </select>
                @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group col-lg">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group col-lg">
                <label for="password">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password" placeholder="Confirm Password">
                @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign up</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Register -->
@endsection