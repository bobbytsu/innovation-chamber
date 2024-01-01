@foreach($comments as $comment)
  <div class="media">
    @if($comment->user->profile_img == NULL)
        <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle mr-3" style="width:40px; height:40px; object-fit:cover;" alt="">
    @else
        <img src="{{ asset('storage/'.$comment->user->profile_img) }}" class="rounded-circle mr-3" style="width:40px; height:40px; object-fit:cover;" alt="">
    @endif
    <div class="media-body">
      <p class="mb-0">
          <b>{{ $comment->user->name }}</b>
          <small class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->format('M j, Y') }}</small>
      </p>
      <p>{{ $comment->comment }}</p>
      <p>
        @guest
        @elseif(auth()->user()->id == $comment->user_id)
          <a href="{{ route('editcomment', $comment->id) }}" class="mx-2">Edit</a>
        @endif
        <a data-toggle="collapse" href="#collapse{{$comment->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$comment->id}}">Reply</a>
      </p>
      <div class="collapse" id="collapse{{$comment->id}}">
          <form method="POST" action="{{ route('reply') }}">
          @csrf
          <div class="form-group">
              @if($comment->post_id)
                <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}" />
              @elseif($comment->upload_id)
                <input type="hidden" name="upload_id" id="upload_id" value="{{ $upload->id }}" />
              @endif
              <input type="hidden" name="parent_id" id="parent_id" value="{{ $comment->id }}" />
              <textarea class="form-control" name="comment" id="comment" rows="1" placeholder="Add a reply"></textarea>
          </div>
          <p class="float-right">
              <button type="submit" class="btn btn-primary">Reply <i class="fa fa-reply-all"></i></button>
          </p>
          </form>
      </div>

      @include('comment.index', ['comments' => $comment->replies])

    </div>
  </div>
@endforeach