@extends('layout/main')
@section('title', 'Edit · Innovation Chamber')
@section('content')
<!-- Edit Upload -->
<div class="container edit-upload">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow" style="border-radius: 0%;">
        <h5 class="card-header text-center">Edit Upload</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('video', $upload->id) }}">
            @method('PATCH')
            @csrf
              <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" type="text" placeholder="Title" id="title" name="title" value="{{ old('title') ?? $upload->title }}">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Description">{{ old('description') ?? $upload->description }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="float-right ml-2">
                <a href="{{ route('video', $upload->id) }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes <i class="fa fa-save"></i></button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Edit Upload -->
@endsection