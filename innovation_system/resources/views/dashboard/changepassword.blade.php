@extends('layout/main')
@section('title', 'Change Password · Innovation Chamber')
@section('content')
<!-- Register -->
<div class="container change-password">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card shadow" style="border-radius: 0%;">
        <h5 class="card-header text-center">Change Password</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('changepassword') }}">
          @method('PATCH')
          @csrf
            <div class="form-group">
              <label for="employeeid">Employee ID</label>
              <input type="text" name="employeeid" class="form-control" id="employeeid" value="{{ auth()->user()->employeeid }}" disabled>
            </div>
            <div class="form-group">
              <label for="oldpassword">Old Password</label>
              <input type="password" name="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" id="oldpassword" placeholder="Old Password">
              @error('oldpassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label for="newpassword">New Password</label>
              <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror" id="newpassword" placeholder="New Password">
              @error('newpassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label for="confirmnewpassword">Confirm New Password</label>
              <input type="password" name="confirmnewpassword" class="form-control @error('confirmnewpassword') is-invalid @enderror" id="confirmnewpassword" placeholder="Confirm New Password">
              @error('confirmnewpassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="text-center">
              <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
              <button type="submit" class="btn btn-primary">Save Password <i class="fa fa-save"></i></button>
            </div>
          </form>
        </div>
        <div class="card-footer text-center">
          <a data-toggle="modal" href="#deleteaccountmodal" style="color: red;">Delete account?</a>
          <div class="modal fade" id="deleteaccountmodal" tabindex="-1" role="dialog" aria-labelledby="deleteaccountmodallabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content delete-account-modal">
                <div class="modal-body">    
                  <img src="/data/asset/rocket.png" class="m-4" width="100px" alt="">
                  <p class="lead text-center mb-0" style="color:white;">We're sad to see you leaving :(</p>
                  <p class="display-4" style="color:white;">Are you sure?</p>
                  <form method="POST" action="{{ route('changepassword') }}">
                    @method('DELETE')
                    @csrf
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Nah, i'll stay</button>
                      <button type="submit" class="btn btn-danger" onclick="return confirm('WARNING: This action can\'t be undone! Do you want to proceed?')">Yes, i'm sure</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Register -->
@endsection