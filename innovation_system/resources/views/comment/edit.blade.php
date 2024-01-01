@extends('layout/secondary')
@section('title', 'Edit Comment · Innovation Chamber')
@section('content')
<!-- Edit Comment -->
<div class="container edit-comment">
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <div class="card shadow">
        <div class="card-body">
          <form method="POST" action="{{ route('editcomment', $comment->id) }}">
            @method('PATCH')
            @csrf
              <div class="form-group">
                <label for="comment" class="lead">Edit Comment</label>
                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Comment">{{ old('comment') ?? $comment->comment }}</textarea>
              </div>
              <div class="float-right">
                @if($comment->post_id)
                  <a href="{{ route('post', $comment->post_id) }}" class="btn btn-secondary">Cancel</a>
                @elseif($comment->upload_id)
                  <a href="{{ route('post', $comment->upload_id) }}" class="btn btn-secondary">Cancel</a>
                @endif
                <button type="submit" class="btn btn-primary">Save <i class="fa fa-save"></i></button>
              </div>
          </form>
          <form method="POST" action="{{ route('editcomment', $comment->id) }}">
            @method('DELETE')
            @csrf
              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Comment <i class="fa fa-trash"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Edit Comment -->
@endsection