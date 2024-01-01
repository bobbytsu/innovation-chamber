@extends('layout/main')
@section('title', 'Edit Profile · Innovation Chamber')
@section('content')
<!-- Edit Profile -->
<div class="container edit-profile">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow" style="border-radius: 0%;">
        <h5 class="card-header text-center">Edit Profile</h5>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data" action="{{ route('editprofile') }}">
          @method('PATCH')
          @csrf
            <div class="form-row">
              <div class="form-group col-lg-3">
                <label for="employeeid">Employee ID</label>
                <input type="text" name="employeeid" class="form-control" id="employeeid" value="{{ auth()->user()->employeeid }}" disabled>
              </div>
              <div class="form-group col-lg">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') ?? auth()->user()->name }}" placeholder="Name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group col-lg-3">
                <label for="unit_id">Unit</label>
                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                  <option value="" disabled>Your Unit:</option>
                  <option value="{{ auth()->user()->unit_id }}" selected>{{ auth()->user()->unit->name }}</option>
                  <option value="" disabled>Change Unit:</option>
                  @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                  @endforeach
                </select>
                @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') ?? auth()->user()->email }}" placeholder="Email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group col-lg">
                <label for="phonenumber">WhatsApp</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                  </div>
                  <input type="text" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" id="phonenumber" value="{{ old('phonenumber') ?? auth()->user()->phonenumber }}" placeholder="Phone Number">
                  <div class="input-group-append">
                    <div class="input-group-text" style="background-color:#25D366; border-color:#25D366; color:white;">
                      <i class="fa fa-whatsapp"></i>
                    </div>
                  </div>
                </div>
                @error('phonenumber')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="form-group">
              <label for="bio">Quotes</label>
              <input type="text" name="bio" class="form-control @error('bio') is-invalid @enderror"" id="bio" value="{{ old('bio') ?? auth()->user()->bio }}" placeholder="Quotes">
              @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label for="profile_img">Choose Profile Picture</label>
              <input type="file" class="form-control" name="profile_img" id="profile_img">
            </div>
            <a href="{{ route('changepassword') }}">Change password?</a>
            <div class="float-right">
              <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
              <button type="submit" class="btn btn-primary">Save Changes <i class="fa fa-save"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Edit Profile -->
@endsection