@extends('layout/secondary')
@section('title', 'Edit Event · Innovation Chamber')
@section('content')
<!-- Edit Event -->
<div class="container add-event">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow" style="border-radius: 0%;">
        <h5 class="card-header text-center">Edit Event</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('editevent', $event->id) }}">
            @method('PATCH')
            @csrf
              <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" type="text" placeholder="Title" id="title" name="title" value="{{ old('title') ?? $event->title }}">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-row">
                <div class="form-group col-lg">
                  <label for="start">Start</label>
                  <input class="form-control @error('start') is-invalid @enderror date" type="text" placeholder="yyyy-mm-dd" id="start" name="start" value="{{ old('start') ?? $event->start }}">
                  @error('start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-lg">
                  <label for="end">End (optional)</label>
                  <input class="form-control date" type="text" placeholder="yyyy-mm-dd" id="end" name="end" value="{{ old('end') ?? $event->end }}">
                </div>
              </div>
              <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description">{{ old('description') ?? $event->description }}</textarea>
              </div>
              <div class="float-right">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary rounded-circle"><i class="fa fa-arrow-left" style="color:white;"></i></a>
                <button type="submit" class="btn btn-primary rounded-circle"><i class="fa fa-save"></i></button>
              </div>
          </form>
          <form method="POST" action="{{ route('editevent', $event->id) }}">
            @method('DELETE')
            @csrf
              <button type="submit" class="btn btn-danger rounded-circle" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "yy-mm-dd"
    });
  });
</script>
<!-- End Edit Event -->
@endsection