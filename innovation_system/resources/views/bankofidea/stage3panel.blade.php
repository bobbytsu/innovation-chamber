@extends('layout/main')
@section('title', 'Edit · Innovation Chamber')
@section('content')
<!-- Stage 3 Panel -->
<div class="container submit-idea">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow" style="border-radius: 0%;">
        <h5 class="card-header text-center">Stage 3 Panel
          <span><i class="fa fa-rocket float-right" style="color: navy;"></i></span>
        </h5>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('updatepost3', $post->id) }}">
          @method('PATCH')
          @csrf
            <div class="form-group">
              <label for="title">Title (optional)</label>
              <input class="form-control @error('title') is-invalid @enderror" type="text" placeholder="Title" id="title" name="title" value="{{ old('title') ?? $post->stage3->title }}">
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
              <div class="form-group col-lg">
                <label for="post_img">Insert Picture (optional)</label>
                <input type="file" class="form-control @error('post_img') is-invalid @enderror" name="post_img" id="post_img">
                @error('post_img')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group col-lg">
                <label for="post_file">Insert Supporting File (optional)</label>
                <input type="file" class="form-control @error('post_file') is-invalid @enderror" name="post_file" id="post_file">
                @error('post_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="form-group">
              <label for="description">Description (optional)</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="10" placeholder="Description">{{ old('description') ?? $post->stage3->description }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="float-right">
              <a href="{{ route('post', $post->id) }}" class="btn btn-danger">Cancel</a>
              <button type="submit" class="btn btn-primary">Save Changes <i class="fa fa-save"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Stage 3 Panel -->
@endsection