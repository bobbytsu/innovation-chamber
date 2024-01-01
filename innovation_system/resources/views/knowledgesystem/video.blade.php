@extends('layout/main')
@section('title', 'Video · Innovation Chamber')
@section('content')
<!-- Video -->
<div class="container video">
  <div class="row">
    <div class="col-lg">
      @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">
          {{ session('status') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="color:black;">&times;</span>
          </button>
        </div>
      @endif
    </div>
  </div>
  <div class="card shadow" style="border:none; border-radius: 0%;">
    <div class="row">
      <div class="col-lg">
        <div class="card-body">
          <video controls width="100%" style="background:black;">
            <source src="{{ asset('data/knowledge system/'.$upload->upload_video) }}">
          </video>
          <p><h4>{{ $upload->title }}</h4></p>
          <div class="row">
            <div class="col-lg">
              <div class="float-right">
                <form method="POST" action="{{ route('like') }}">
                  @csrf
                    <input type="hidden" name="upload_id" id="upload_id" value="{{ $upload->id }}" />
                    @guest
                      <button type="submit" class="btn btn-primary btn-sm like" title="Like"><i class="fa fa-thumbs-o-up"></i></button>
                    @elseif($upload->isAuthUserLikedUpload())
                      <small class="liked mx-1"><i class="fa fa-thumbs-o-up"></i> You've liked this video</small>
                    @else
                      <button type="submit" class="btn btn-primary btn-sm like" title="Like"><i class="fa fa-thumbs-o-up"></i></button>
                    @endif
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#likermodal" title="@if($totallike > 1 )Likers @else Liker @endif">{{$totallike}} @if($totallike > 1 ) likes @else like @endif</button>
                    <a href="whatsapp://send?text={{url()->current()}}" class="btn btn-success btn-sm" title="Share on WhatsApp">Share <i class="fa fa-whatsapp"></i></a>
                </form>
              </div>
              <p class="text-muted">{{ \Carbon\Carbon::parse($upload->created_at)->format('M j, Y') }}</p>
            </div>
          </div>
          <hr/>
          <div class="media">
            @if($upload->user->profile_img == NULL)
              <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle mr-3" style="width:50px; height:50px; object-fit:cover;" alt="">
            @else
              <img src="{{ asset('storage/'.$upload->user->profile_img) }}" class="rounded-circle mr-3" style="width:50px; height:50px; object-fit:cover;" alt="">
            @endif
            <div class="media-body">
              @guest
              @elseif(auth()->user()->id == $upload->user_id)
                <form method="POST" action="{{ route('video', $upload->id) }}">
                  @method('DELETE')
                  @csrf
                    <button type="submit" class="btn btn-danger btn-sm ml-1 float-right" onclick="return confirm('Are you sure?')">Delete <i class="fa fa-trash"></i></button>
                </form>
                <a href="{{ route('editupload', $upload->id) }}" class="btn btn-warning btn-sm ml-1 float-right" style="color:white;"><i class="fa fa-edit"></i> Edit</a>
              @endif
              <b>{{ $upload->user->name }}</b>
              <p>{!! nl2br(e($upload->description)) !!}</p>
            </div>
          </div>
          <hr/>
          <form method="POST" action="{{ route('comment') }}">
            @csrf
            <div class="form-group">
              <input type="hidden" name="upload_id" id="upload_id" value="{{ $upload->id }}" />
              @if($totalcomment > 1)
                <label for="comment" class="lead">Comments · {{ $totalcomment }}</label>
              @else
                <label for="comment" class="lead">Comment · {{ $totalcomment }}</label>
              @endif
              <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Leave a comment"></textarea>
            </div>
            <p class="float-right">
              <button type="submit" class="btn btn-primary">Add Comment <i class="fa fa-comments"></i></button>
            </p>
          </form>
          <div class="comment-list">
            @foreach($comments as $comment)
              @if($comment->parent_id == NULL)
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
                      <a data-toggle="collapse" href="#collapse{{$comment->id}}" class="mx-2" role="button" aria-expanded="false" aria-controls="collapse{{$comment->id}}">Reply</a>
                    </p>
                    <div class="collapse" id="collapse{{$comment->id}}">
                      <form method="POST" action="{{ route('reply') }}">
                        @csrf
                        <div class="form-group">
                          <input type="hidden" name="upload_id" id="upload_id" value="{{ $upload->id }}" />
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
              @endif
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-lg-3 suggestion">
        <div class="card-body suggestion">
          <p class="lead">Suggested</p>
          <hr/>
          @foreach($thumbs as $thumb)
            @if($thumb->id != $upload->id)
              <div class="card border-0 thumbnail-card mb-3" style="border-radius: 0%;">
                <a href="{{ route('video', $thumb->id) }}" style="text-decoration:none; color:black;">
                  <div class="thumbnail">
                    <img src="{{ asset('data/knowledge system/'.$thumb->thumbnail) }}" class="card-img-top"  style="border-radius:0%;" alt="">
                    <div class="overlay">     
                      <i class="fa fa-play"></i>           
                    </div>
                  </div>
                  <div class="card-body px-0 py-2">
                    <h6 class="card-title mb-0" title="{{ $thumb->title }}">{{ \Illuminate\Support\Str::limit($thumb->title, 60) }}</h6>
                    <small class="text-muted mb-0">
                      <span class="text-muted" title="{{ $thumb->user->name }}">
                        {{ \Illuminate\Support\Str::limit($thumb->user->name, 27) }}
                      </span> · {{ \Carbon\Carbon::parse($thumb->created_at)->format('M j, Y') }}
                    </small>
                  </div>
                </a>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Video -->
<!-- Modal -->
<div class="modal fade" id="likermodal" tabindex="-1" aria-labelledby="likermodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
    <div class="modal-content">
      <h5 class="card-header text-center">@if($totallike > 1 )Likers @else Liker @endif
        <span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:black;">&times;</span>
          </button>
        </span>
      </h5>
      <ul class="list-group">
        @forelse($likers as $liker)
          <li class="list-group-item">
            @auth
              @if(auth()->user()->id == $liker->user_id)
                <form method="POST" action="{{ route('unlike', $liker->id) }}" class="float-right">
                  @method('DELETE')
                  @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" title="Unlike"><i class="fa fa-thumbs-o-down"></i></button>
                </form>
              @endif
            @endauth
            <div class="media">
              @if($liker->user->profile_img == NULL)
                <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle mr-3" style="width:35px; height:35px; object-fit:cover;" alt="">
              @else
                <img src="{{ asset('storage/'.$liker->user->profile_img) }}" class="rounded-circle mr-3" style="width:35px; height:35px; object-fit:cover;" alt="">
              @endif
              <div class="media-body">
                <h6 class="mt-2">{{ $liker->user->name }}</h6>
              </div>
            </div>
          </li>
        @empty
          <li class="list-group-item">
            <p class="lead text-center py-5">No like yet</p>
          </li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection