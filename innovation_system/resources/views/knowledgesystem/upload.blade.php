@extends('layout/main')
@section('title', 'Upload · Innovation Chamber')
@section('content')
<script src="http://malsup.github.com/jquery.form.js"></script>
<!-- Upload -->
<div class="container upload-video">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow" style="border-radius: 0%;">
        <h5 class="card-header text-center">Upload Video</h5>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data" action="{{ route('knowledgesystem') }}">
            @csrf
              <div class="form-group">
                <label for="upload_video">Insert Video</label>
                <input type="file" class="form-control" name="upload_video" id="upload_video">
                <small class="text-muted ml-2"><i>max: 500MB</i></small>
              </div>
              <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" placeholder="Title" id="title" name="title" value="{{ old('title') }}">
              </div>
              <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description">{{ old('description') }}</textarea>
              </div>
              <div class="float-right ml-2">
                <a href="{{ route('knowledgesystem') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-danger">Upload <i class="fa fa-video" style="color:white"></i></button>
              </div>
          </form>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow=""
            aria-valuemin="0" aria-valuemax="100" style="width: 0%">
              0%
            </div>
          </div>
          <div id="success">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Upload -->
@endsection