@extends('layout/main')
@section('title', 'Idea · Innovation Chamber')
@section('content')
<!-- Article -->
<div class="container article">
  <div class="row">
    <div class="col-lg">
      @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="color:black;">&times;</span>
          </button>
        </div>
      @endif
    </div>
  </div>
  <div class="card shadow" style="border:none; border-radius: 0%;">  

    <!-- Stage 1 -->
    <div class="row" id="stage-1">
      <div class="col-lg">
        @if($post->stage1->post_img != NULL)
          <div class="post-picture text-center">   
            <img src="{{ asset('storage/'.$post->stage1->post_img) }}" alt="">
          </div>
        @endif
        <div class="card-body">
          <div class="float-right">
            <small class="text-muted mr-2">{{ \Carbon\Carbon::parse($post->created_at)->format('M j, Y') }}</small>
            @if($post->season == 'Spring')
              <td><img src="/data/asset/leaf.png" width="20px"></td>
            @elseif($post->season == 'Summer')
              <td><img src="/data/asset/sunset.png" width="20px"></td>
            @elseif($post->season == 'Autumn')
              <td><img src="/data/asset/oak.png" width="20px"></td>
            @else
              <td><img src="/data/asset/snow.png" width="20px"></td>
            @endif
          </div>
          <h4>{{ $post->stage1->title }}</h4>
          <div class="row mb-3">
            <div class="col-lg">
              <div class="float-right">
                <form method="POST" action="{{ route('like') }}">
                  @csrf
                    <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}" />
                    @guest
                      <button type="submit" class="btn btn-primary btn-sm like" title="Like"><i class="fa fa-thumbs-o-up"></i></button>
                    @elseif($post->isAuthUserLikedPost())
                      <small class="liked mx-1"><i class="fa fa-thumbs-o-up"></i> You've liked this idea</small>
                    @else
                      <button type="submit" class="btn btn-primary btn-sm like" title="Like"><i class="fa fa-thumbs-o-up"></i></button>
                    @endif
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#likermodal" title="@if($totallike > 1 )Likers @else Liker @endif">{{$totallike}} @if($totallike > 1 ) likes @else like @endif</button>
                    <a href="whatsapp://send?text={{url()->current()}}" class="btn btn-success btn-sm" title="Share on WhatsApp">Share <i class="fa fa-whatsapp"></i></a>
                </form>
              </div>
              @if($post->contributor != NULL)
                <img src="{{ asset('data/asset/person.png') }}" class="rounded-circle" style="width:25px; height:25px; object-fit:cover;" alt="">
                <b>{{ $post->user->name }} ({{ $post->user->unit->name }}), {{ $post->contributor }}</b>
              @else
                @if($post->user->profile_img == NULL)
                  <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:25px; height:25px; object-fit:cover;" alt="">
                @else
                  <img src="{{ asset('storage/'.$post->user->profile_img) }}" class="rounded-circle" style="width:25px; height:25px; object-fit:cover;" alt="">
                @endif    
                <b>{{ $post->user->name }} ({{ $post->user->unit->name }})</b>
              @endif
            </div>
          </div>
          <p align="justify">{!! nl2br(e($post->stage1->description)) !!}</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="text-center pt-1">
          <b>{{ $post->category->name }}</b>
        </div>
        <div class="text-center py-5">
          <a href="#stage-1" class="btn btn-outline-primary page-scroll mb-1">Stage 1</a>
          @if($post->stage >= 2)
            <br>
            <a href="#stage-2" class="btn btn-outline-primary page-scroll mb-1">Stage 2</a>
          @endif
          @if($post->stage >= 3)
            <br>
            <a href="#stage-3" class="btn btn-outline-primary page-scroll mb-1">Stage 3</a>
          @endif
          @if($post->stage >= 4)
            <br>
            <a href="#stage-4" class="btn btn-outline-primary page-scroll mb-1">Stage 4</a>
          @endif
          @if($post->stage >= 5)
            <br>
            <a href="#stage-5" class="btn btn-outline-primary page-scroll">Stage 5</a>
          @endif
        </div>
        <hr/>
        @guest
          <p class="lead text-center">Stage 1,</p>
        @endguest
        @auth
          @if(auth()->user()->id != $post->user_id && auth()->user()->role == 'User')
            @if(auth()->user()->id != $post->stage1->review->reviewerid)
              <p class="lead text-center">Stage 1,</p>
            @elseif(auth()->user()->id == $post->stage1->review->reviewerid && $post->stage1->review->status == 'In Progress')
              <p class="lead text-center">Stage 1, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-hourglass"></i></h1>
              </div>
              <p class="lead text-center" style="color:gray;">{{ $post->stage1->review->status }}</p>
            @elseif(auth()->user()->id == $post->stage1->review->reviewerid && $post->stage1->review->status == 'Approved')
              <p class="lead text-center">Stage 1, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center" style="color:green;">{{ $post->stage1->review->status }}</p>
            @elseif(auth()->user()->id == $post->stage1->review->reviewerid && $post->stage1->review->status == 'Declined')
              <p class="lead text-center">Stage 1, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center">Done</p>
            @endif
          @elseif(auth()->user()->id == $post->user_id && $post->stage1->review->status == 'Waiting' || auth()->user()->role == 'Administrator' && $post->stage1->review->status == 'Waiting' || auth()->user()->role == 'Master' && $post->stage1->review->status == 'Waiting')
            <p class="lead text-center">Stage 1, status:</p>
            <div class="section-title">
              <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-hourglass"></i></h1>
            </div>
            <p class="lead text-center" style="color:gray;">{{ $post->stage1->review->status }}</p>
          @elseif(auth()->user()->id == $post->user_id && $post->stage1->review->status == 'In Progress' || auth()->user()->role == 'Administrator' && $post->stage1->review->status == 'In Progress' || auth()->user()->role == 'Master' && $post->stage1->review->status == 'In Progress')
            <p class="lead text-center">Stage 1, status:</p>
            <div class="section-title">
              <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
            </div>
            <p class="lead text-center">{{ $post->stage1->review->status }}</p>
          @elseif(auth()->user()->id == $post->user_id && $post->stage1->review->status == 'Approved' || auth()->user()->role == 'Administrator' && $post->stage1->review->status == 'Approved' || auth()->user()->role == 'Master' && $post->stage1->review->status == 'Approved')
            <p class="lead text-center">Stage 1, status:</p>
            <div class="section-title">
              <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
            </div>
            <p class="lead text-center" style="color:green;">{{ $post->stage1->review->status }}</p>
            @if(auth()->user()->id == $post->user_id)
              <p class="text-center" style="color:green;">Proceed to Stage 2</p>
            @endif
          @elseif(auth()->user()->id == $post->user_id && $post->stage1->review->status == 'Declined' || auth()->user()->role == 'Administrator' && $post->stage1->review->status == 'Declined' || auth()->user()->role == 'Master' && $post->stage1->review->status == 'Declined')
            <p class="lead text-center">Stage 1, status:</p>
            <div class="section-title">
              <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
            </div>
            <p class="lead text-center">Done</p>
            @if(auth()->user()->id == $post->user_id)
              <p class="text-center" style="color:gray;">Thankyou for your submission</p>
            @endif
          @endif
          @if(auth()->user()->id == $post->user_id)
            <p class="text-center">
              <a href="{{ route('editpost', $post->id) }}" class="btn btn-warning" style="color:white;"><i class="fa fa-edit"></i> Edit Stage 1</a>
            </p>
          @endif
        @endauth
        @if($post->stage1->post_file != NULL)
          <p class="text-center">
            <a data-toggle="modal" href="#previewfilemodal" class="btn btn-secondary">View <i class="fa fa-file"></i></a>
          </p>
          <div class="modal fade" id="previewfilemodal" tabindex="-1" role="dialog" aria-labelledby="previewfilemodallabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:100%; height:100%;">
              <div class="modal-content bg-secondary" style="width:100%; height:100%;">
                <div class="modal-header bg-dark border-dark">
                  <h6 class="modal-title" style="color:white;"><i class="fa fa-file"></i> File Preview</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <iframe src="{{ asset('storage/'.$post->stage1->post_file) }}" width="100%" height="100%" frameBorder="0"></iframe>
              </div>
            </div>
          </div>
        @endif
        @auth
          @if(auth()->user()->role == 'Administrator' && auth()->user()->id != $post->user_id && $post->stage1->review->switch == 0 || auth()->user()->role == 'Master' && auth()->user()->id != $post->user_id && $post->stage1->review->switch == 0)
            <p class="text-center">
              <a data-toggle="modal" href="#reviewideamodal" class="btn btn-primary" style="color:white;">Review <i class="fa fa-eye"></i></a>
            </p>
            <div class="modal fade" id="reviewideamodal" tabindex="-1" role="dialog" aria-labelledby="reviewideamodallabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content idea-modal">
                  <div class="modal-body text-center">    
                    <img src="/data/asset/satellite.png" class="m-4" width="100px" alt="">
                    <p class="display-4" style="color:white;">Review this idea?</p>
                    <form action="{{ route('updatestatus', $post->id) }}" method="POST">
                      @method('PATCH')
                      @csrf
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Review <i class="fa fa-eye"></i></button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @elseif(auth()->user()->id == $post->stage1->review->reviewerid && $post->stage1->review->switch == 1)
            <p class="text-center">
              <a data-toggle="modal" href="#contactinfomodal" class="btn btn-primary" style="color:white;">Contact <i class="fa fa-id-card"></i></a>
            </p>
            @if($post->stage1->review->status == 'In Progress')
              <div class="d-flex justify-content-center mb-2">
                <a data-toggle="modal" href="#declineideamodal" class="btn btn-danger mr-1">Decline <i class="fa fa-remove"></i></a>
                <a data-toggle="modal" href="#approveideamodal" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
              </div>
              <div class="modal fade" id="declineideamodal" tabindex="-1" role="dialog" aria-labelledby="declineideamodallabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content idea-modal">
                    <div class="modal-body text-center">    
                      <img src="/data/asset/astronaut1.png" class="m-4" width="100px" alt="">
                      <p class="display-4" style="color:white;">Decline this idea?</p>
                      <form action="{{ route('declinestatus', $post->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Decline <i class="fa fa-times"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="approveideamodal" tabindex="-1" role="dialog" aria-labelledby="approveideamodallabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content idea-modal">
                    <div class="modal-body text-center">    
                      <img src="/data/asset/astronaut3.png" class="m-4" width="100px" alt="">
                      <p class="display-4" style="color:white;">Approve this idea?</p>
                      <form action="{{ route('approvestatus', $post->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-success">Approve <i class="fa fa-check"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <p class="text-center">
                <a data-toggle="modal" href="#unreviewideamodal">Unreview?</a>
              </p>
              <div class="modal fade" id="unreviewideamodal" tabindex="-1" role="dialog" aria-labelledby="unreviewideamodallabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content idea-modal">
                    <div class="modal-body text-center">    
                      <img src="/data/asset/sputnik.png" class="m-4" width="100px" alt="">
                      <p class="display-4" style="color:white;">Unreview this idea?</p>
                      <form action="{{ route('destroystatus', $post->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Unreview <i class="fa fa-eye-slash"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @elseif($post->stage1->review->status == 'Approved' && $post->stage2->review->switch == 0)
              <p class="text-center">
                <a data-toggle="modal" href="#disapproveideamodal" style="color:red;">Disapprove</a>
              </p>
              <div class="modal fade" id="disapproveideamodal" tabindex="-1" role="dialog" aria-labelledby="disapproveideamodallabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content idea-modal">
                    <div class="modal-body text-center">    
                      <img src="/data/asset/astronaut2.png" class="m-4" width="100px" alt="">
                      <p class="display-4" style="color:white;">Disapprove this idea?</p>
                      <form action="{{ route('disapprovestatus', $post->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Disapprove <i class="fa fa-times"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>      
            @elseif($post->stage1->review->status == 'Declined')
              <p class="text-center">
                <a data-toggle="modal" href="#rereviewideamodal">Re-review?</a>
              </p>
              <div class="modal fade" id="rereviewideamodal" tabindex="-1" role="dialog" aria-labelledby="rereviewideamodallabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content idea-modal">
                    <div class="modal-body text-center">    
                      <img src="/data/asset/astronaut4.png" class="m-4" width="100px" alt="">
                      <p class="display-4" style="color:white;">Re-review this idea?</p>
                      <form action="{{ route('rereviewstatus', $post->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Re-review <i class="fa fa-eye"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endif
          @if(auth()->user()->id == $post->user_id)
            <div class="d-flex justify-content-center mb-3">
              @if($post->stage1->post_img != NULL)
                <form action="{{ route('removepostimg', $post->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                    <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-image"></i></button>
                </form>
              @endif
              @if($post->stage1->post_file != NULL)
                <form action="{{ route('removepostfile', $post->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-file"></i></button>
                </form>
              @endif
            </div>
          @endif
          @if($post->stage1->review->reviewerid != NULL && auth()->user()->id == $post->user_id || $post->stage1->review->reviewerid != NULL && auth()->user()->role == 'Administrator' || $post->stage1->review->reviewerid != NULL && auth()->user()->role == 'Master' || $post->stage1->review->reviewerid != NULL && auth()->user()->id == $post->stage1->review->reviewerid)
            <p class="text-center mb-0" style="color:gray;">Reviewed by,</p>
            @if(auth()->user()->id == $post->stage1->review->reviewerid)
              <p class="text-center" style="color:gray;">You</p>
            @else
              <p class="text-center" style="color:gray;">{{ $post->stage1->review->reviewername }} ({{ $post->stage1->review->reviewerunit }})</p>
            @endif
          @endif
        @endauth
        @if($post->stage >= 2)
          <p class="text-center">
            <a href="#stage-2" class="page-scroll">Next <i class="fa fa-chevron-right"></i></a>
          </p>
        @endif
      </div>
    </div>
    <!-- End Stage 1 -->

    <!-- Stage 2 -->
    @if($post->stage >= 2)
      <hr/>
      <div class="row" id="stage-2">
        <div class="col-lg">
          <div class="card-body">
            @guest
              @if($post->stage2->title == NULL && $post->stage2->post_img == NULL && $post->stage2->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:teal;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage2->review->switch == 1 || $post->stage2->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 2</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage2->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage2->title }}</h4>
                @endif
                @if($post->stage2->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage2->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage2->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage2->description)) !!}</p>
                @endif
              @endif
            @endguest
            @auth
              @if($post->stage2->title == NULL && $post->stage2->post_img == NULL && $post->stage2->description == NULL && auth()->user()->id == $post->user_id)
                <p class="display-4 text-center" style="font-size:40px;">Stage 2</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 18px; border-radius:50%; background:teal;"><i class="fa fa-unlock-alt"></i></h1>
                </div>
                <p class="display-4 text-center" style="font-size:40px;">Unlocked!</p>
                <p class="lead text-center">You can add something here by using the panel
                  <span><i class="fa fa-right"></i></span>
                </p>
              @elseif($post->stage2->title == NULL && $post->stage2->post_img == NULL && $post->stage2->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:teal;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage2->review->switch == 1 || $post->stage2->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 2</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage2->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage2->title }}</h4>
                @endif
                @if($post->stage2->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage2->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage2->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage2->description)) !!}</p>
                @endif
              @endif
            @endauth
          </div>
        </div>
        <div class="col-lg-3">   
          @guest
            <p class="lead text-center">Stage 2,</p>
          @endguest
          @auth
            @if(auth()->user()->id != $post->user_id && auth()->user()->role == 'User')
              @if(auth()->user()->id != $post->stage2->review->reviewerid)
                <p class="lead text-center">Stage 2,</p>
              @elseif(auth()->user()->id == $post->stage2->review->reviewerid && $post->stage2->review->status == 'In Progress')
                <p class="lead text-center">Stage 2, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
                </div>
                <p class="lead text-center">{{ $post->stage2->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage2->review->reviewerid && $post->stage2->review->status == 'Approved')
                <p class="lead text-center">Stage 2, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center" style="color:green;">{{ $post->stage2->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage2->review->reviewerid && $post->stage2->review->status == 'Declined')
                <p class="lead text-center">Stage 2, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center">Done</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage2->review->status == 'Waiting' || auth()->user()->role == 'Administrator' && $post->stage2->review->status == 'Waiting' || auth()->user()->role == 'Master' && $post->stage2->review->status == 'Waiting')
              <p class="lead text-center">Stage 2, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-hourglass"></i></h1>
              </div>
              <p class="lead text-center" style="color:gray;">{{ $post->stage2->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage2->review->status == 'In Progress' || auth()->user()->role == 'Administrator' && $post->stage2->review->status == 'In Progress' || auth()->user()->role == 'Master' && $post->stage2->review->status == 'In Progress')
              <p class="lead text-center">Stage 2, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
              </div>
              <p class="lead text-center">{{ $post->stage2->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage2->review->status == 'Approved' || auth()->user()->role == 'Administrator' && $post->stage2->review->status == 'Approved' || auth()->user()->role == 'Master' && $post->stage2->review->status == 'Approved')
              <p class="lead text-center">Stage 2, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center" style="color:green;">{{ $post->stage2->review->status }}</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:green;">Proceed to Stage 3</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage2->review->status == 'Declined' || auth()->user()->role == 'Administrator' && $post->stage2->review->status == 'Declined' || auth()->user()->role == 'Master' && $post->stage2->review->status == 'Declined')
              <p class="lead text-center">Stage 2, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center">Done</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:gray;">Thankyou for your submission</p>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <p class="text-center">
                <a href="{{ route('editpost2', $post->id) }}" class="btn btn-warning" style="color:white;"><i class="fa fa-edit"></i> Add/Edit Stage 2</a>
              </p>
            @endif
          @endauth
          @if($post->stage2->post_file != NULL)
            <p class="text-center">
              <a data-toggle="modal" href="#previewfilemodal2" class="btn btn-secondary">View <i class="fa fa-file"></i></a>
            </p>
            <div class="modal fade" id="previewfilemodal2" tabindex="-1" role="dialog" aria-labelledby="previewfilemodal2label" aria-hidden="true">
              <div class="modal-dialog modal-lg" style="width:100%; height:100%;">
                <div class="modal-content bg-secondary" style="width:100%; height:100%;">
                  <div class="modal-header bg-dark border-dark">
                    <h6 class="modal-title" style="color:white;"><i class="fa fa-file"></i> File Preview</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <iframe src="{{ asset('storage/'.$post->stage2->post_file) }}" width="100%" height="100%" frameBorder="0"></iframe>
                </div>
              </div>
            </div>
          @endif
          @auth
            @if(auth()->user()->role == 'Administrator' && auth()->user()->id != $post->user_id && $post->stage2->review->switch == 0 || auth()->user()->role == 'Master' && auth()->user()->id != $post->user_id && $post->stage2->review->switch == 0)
              @if($post->stage2->title != NULL || $post->stage2->post_img != NULL || $post->stage2->description != NULL || $post->stage2->post_file != NULL)
                <p class="text-center">
                  <a data-toggle="modal" href="#reviewideamodal2" class="btn btn-primary" style="color:white;">Review <i class="fa fa-eye"></i></a>
                </p>
                <div class="modal fade" id="reviewideamodal2" tabindex="-1" role="dialog" aria-labelledby="reviewideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/satellite.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Review this idea?</p>
                        <form action="{{ route('updatestatus2', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @elseif(auth()->user()->id == $post->stage2->review->reviewerid && $post->stage2->review->switch == 1)
              <p class="text-center">
                <a data-toggle="modal" href="#contactinfomodal" class="btn btn-primary" style="color:white;">Contact <i class="fa fa-id-card"></i></a>
              </p>
              @if($post->stage2->review->status == 'In Progress')
                <div class="d-flex justify-content-center mb-2">
                  <a data-toggle="modal" href="#declineideamodal2" class="btn btn-danger mr-1">Decline <i class="fa fa-remove"></i></a>
                  <a data-toggle="modal" href="#approveideamodal2" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
                </div>
                <div class="modal fade" id="declineideamodal2" tabindex="-1" role="dialog" aria-labelledby="declineideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut1.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Decline this idea?</p>
                        <form action="{{ route('declinestatus2', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Decline <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="approveideamodal2" tabindex="-1" role="dialog" aria-labelledby="approveideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">
                        <img src="/data/asset/astronaut3.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Approve this idea?</p>
                        <form action="{{ route('approvestatus2', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve <i class="fa fa-check"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="text-center">
                  <a data-toggle="modal" href="#unreviewideamodal2">Unreview?</a>
                </p>
                <div class="modal fade" id="unreviewideamodal2" tabindex="-1" role="dialog" aria-labelledby="unreviewideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/sputnik.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Unreview this idea?</p>
                        <form action="{{ route('destroystatus2', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Unreview <i class="fa fa-eye-slash"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage2->review->status == 'Approved' && $post->stage3->review->switch == 0)
                <p class="text-center">
                  <a data-toggle="modal" href="#disapproveideamodal2" style="color:red;">Disapprove</a>
                </p>
                <div class="modal fade" id="disapproveideamodal2" tabindex="-1" role="dialog" aria-labelledby="disapproveideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut2.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Disapprove this idea?</p>
                        <form action="{{ route('disapprovestatus2', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Disapprove <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage2->review->status == 'Declined')
                <p class="text-center">
                  <a data-toggle="modal" href="#rereviewideamodal2">Re-review?</a>
                </p>
                <div class="modal fade" id="rereviewideamodal2" tabindex="-1" role="dialog" aria-labelledby="rereviewideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut4.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Re-review this idea?</p>
                        <form action="{{ route('rereviewstatus2', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Re-review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <div class="d-flex justify-content-center mb-3">
                @if($post->stage2->post_img != NULL)
                  <form action="{{ route('removepostimg2', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-image"></i></button>
                  </form>
                @endif
                @if($post->stage2->post_file != NULL)
                  <form action="{{ route('removepostfile2', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-file"></i></button>
                  </form>
                @endif
              </div>
              @if($post->stage2->title != NULL || $post->stage2->post_img != NULL || $post->stage2->description != NULL || $post->stage2->post_file != NULL)  
                <p class="text-center">
                    <a data-toggle="modal" href="#reset2ideamodal2" class="btn btn-info" style="background-color:teal; border-color:teal;">Reset <i class="fa fa-refresh"></i></a>
                </p>
                <div class="modal fade" id="reset2ideamodal2" tabindex="-1" role="dialog" aria-labelledby="reset2ideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/meteor.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Reset Stage 2?</p>
                        <form action="{{ route('resetpost2', $post->id) }}" method="POST" class="text-center">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-info" style="background-color:teal; border-color:teal;" onclick="return confirm('Are you sure?')">Reset <i class="fa fa-refresh"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if($post->stage2->review->reviewerid != NULL && auth()->user()->id == $post->user_id || $post->stage2->review->reviewerid != NULL && auth()->user()->role == 'Administrator' || $post->stage2->review->reviewerid != NULL && auth()->user()->role == 'Master' || $post->stage2->review->reviewerid != NULL && auth()->user()->id == $post->stage2->review->reviewerid)
              <p class="text-center mb-0" style="color:gray;">Reviewed by,</p>
              @if(auth()->user()->id == $post->stage2->review->reviewerid)
                <p class="text-center" style="color:gray;">You</p>
              @else
                <p class="text-center" style="color:gray;">{{ $post->stage2->review->reviewername }} ({{ $post->stage2->review->reviewerunit }})</p>
              @endif
            @endif
          @endauth
          @if($post->stage >= 2)
            <p class="text-center">
              <a href="#stage-1" class="page-scroll mr-2"><i class="fa fa-chevron-left"></i> Back</a>
              <a href="#stage-1" class="page-scroll"><i class="fa fa-bars"></i></a>
              @if($post->stage >= 3)
                <a href="#stage-3" class="page-scroll ml-2">Next <i class="fa fa-chevron-right"></i></a>
              @endif
            </p>
          @endif
        </div>
      </div>
    @endif
    <!-- End Stage 2 -->

    <!-- Stage 3 -->
    @if($post->stage >= 3)
      <hr/>
      <div class="row" id="stage-3">
        <div class="col-lg">      
          <div class="card-body">
            @guest
              @if($post->stage3->title == NULL && $post->stage3->post_img == NULL && $post->stage3->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:navy;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage3->review->switch == 1 || $post->stage3->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 3</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage3->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage3->title }}</h4>
                @endif
                @if($post->stage3->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage3->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage3->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage3->description)) !!}</p>
                @endif
              @endif
            @endguest
            @auth
              @if($post->stage3->title == NULL && $post->stage3->post_img == NULL && $post->stage3->description == NULL && auth()->user()->id == $post->user_id)
                <p class="display-4 text-center" style="font-size:40px;">Stage 3</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 18px; border-radius:50%; background:navy;"><i class="fa fa-unlock-alt"></i></h1>
                </div>
                <p class="display-4 text-center" style="font-size:40px;">Unlocked!</p>
                <p class="lead text-center">You can add something here by using the panel
                  <span><i class="fa fa-right"></i></span>
                </p>
              @elseif($post->stage3->title == NULL && $post->stage3->post_img == NULL && $post->stage3->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:navy;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage3->review->switch == 1 || $post->stage3->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 3</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage3->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage3->title }}</h4>
                @endif
                @if($post->stage3->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage3->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage3->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage3->description)) !!}</p>
                @endif
              @endif
            @endauth
          </div>
        </div>
        <div class="col-lg-3">
          @guest
            <p class="lead text-center">Stage 3,</p>
          @endguest
          @auth
            @if(auth()->user()->id != $post->user_id && auth()->user()->role == 'User')
              @if(auth()->user()->id != $post->stage3->review->reviewerid)
                <p class="lead text-center">Stage 3,</p>
              @elseif(auth()->user()->id == $post->stage3->review->reviewerid && $post->stage3->review->status == 'In Progress')
                <p class="lead text-center">Stage 3, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
                </div>
                <p class="lead text-center">{{ $post->stage3->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage3->review->reviewerid && $post->stage3->review->status == 'Approved')
                <p class="lead text-center">Stage 3, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center" style="color:green;">{{ $post->stage3->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage3->review->reviewerid && $post->stage3->review->status == 'Declined')
                <p class="lead text-center">Stage 3, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center">Done</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage3->review->status == 'Waiting' || auth()->user()->role == 'Administrator' && $post->stage3->review->status == 'Waiting' || auth()->user()->role == 'Master' && $post->stage3->review->status == 'Waiting')
              <p class="lead text-center">Stage 3, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-hourglass"></i></h1>
              </div>
              <p class="lead text-center" style="color:gray;">{{ $post->stage3->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage3->review->status == 'In Progress' || auth()->user()->role == 'Administrator' && $post->stage3->review->status == 'In Progress' || auth()->user()->role == 'Master' && $post->stage3->review->status == 'In Progress')
              <p class="lead text-center">Stage 3, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
              </div>
              <p class="lead text-center">{{ $post->stage3->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage3->review->status == 'Approved' || auth()->user()->role == 'Administrator' && $post->stage3->review->status == 'Approved' || auth()->user()->role == 'Master' && $post->stage3->review->status == 'Approved')
              <p class="lead text-center">Stage 3, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center" style="color:green;">{{ $post->stage3->review->status }}</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:green;">Proceed to Stage 4</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage3->review->status == 'Declined' || auth()->user()->role == 'Administrator' && $post->stage3->review->status == 'Declined' || auth()->user()->role == 'Master' && $post->stage3->review->status == 'Declined')
              <p class="lead text-center">Stage 3, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center">Done</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:gray;">Thankyou for your submission</p>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <p class="text-center">
                <a href="{{ route('editpost3', $post->id) }}" class="btn btn-warning" style="color:white;"><i class="fa fa-edit"></i> Add/Edit Stage 3</a>
              </p>
            @endif
          @endauth
          @if($post->stage3->post_file != NULL)
            <p class="text-center">
              <a data-toggle="modal" href="#previewfilemodal3" class="btn btn-secondary">View <i class="fa fa-file"></i></a>
            </p>
            <div class="modal fade" id="previewfilemodal3" tabindex="-1" role="dialog" aria-labelledby="previewfilemodal3label" aria-hidden="true">
              <div class="modal-dialog modal-lg" style="width:100%; height:100%;">
                <div class="modal-content bg-secondary" style="width:100%; height:100%;">
                  <div class="modal-header bg-dark border-dark">
                    <h6 class="modal-title" style="color:white;"><i class="fa fa-file"></i> File Preview</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <iframe src="{{ asset('storage/'.$post->stage3->post_file) }}" width="100%" height="100%" frameBorder="0"></iframe>
                </div>
              </div>
            </div>
          @endif
          @auth
            @if(auth()->user()->role == 'Administrator' && auth()->user()->id != $post->user_id && $post->stage3->review->switch == 0 || auth()->user()->role == 'Master' && auth()->user()->id != $post->user_id && $post->stage3->review->switch == 0)
              @if($post->stage3->title != NULL || $post->stage3->post_img != NULL || $post->stage3->description != NULL || $post->stage3->post_file != NULL)
                <p class="text-center">
                  <a data-toggle="modal" href="#reviewideamodal3" class="btn btn-primary" style="color:white;">Review <i class="fa fa-eye"></i></a>
                </p>
                <div class="modal fade" id="reviewideamodal3" tabindex="-1" role="dialog" aria-labelledby="reviewideamodal3label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/satellite.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Review this idea?</p>
                        <form action="{{ route('updatestatus3', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @elseif(auth()->user()->id == $post->stage3->review->reviewerid && $post->stage3->review->switch == 1)
              <p class="text-center">
                <a data-toggle="modal" href="#contactinfomodal" class="btn btn-primary" style="color:white;">Contact <i class="fa fa-id-card"></i></a>
              </p>
              @if($post->stage3->review->status == 'In Progress')
                <div class="d-flex justify-content-center mb-2">
                  <a data-toggle="modal" href="#declineideamodal3" class="btn btn-danger mr-1">Decline <i class="fa fa-remove"></i></a>
                  <a data-toggle="modal" href="#approveideamodal3" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
                </div>
                <div class="modal fade" id="declineideamodal3" tabindex="-1" role="dialog" aria-labelledby="declineideamodal3label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut1.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Decline this idea?</p>
                        <form action="{{ route('declinestatus3', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Decline <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="approveideamodal3" tabindex="-1" role="dialog" aria-labelledby="approveideamodal3label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">
                        <img src="/data/asset/astronaut3.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Approve this idea?</p>
                        <form action="{{ route('approvestatus3', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve <i class="fa fa-check"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="text-center">
                  <a data-toggle="modal" href="#unreviewideamodal3">Unreview?</a>
                </p>
                <div class="modal fade" id="unreviewideamodal3" tabindex="-1" role="dialog" aria-labelledby="unreviewideamodal3label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/sputnik.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Unreview this idea?</p>
                        <form action="{{ route('destroystatus3', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Unreview <i class="fa fa-eye-slash"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage3->review->status == 'Approved' && $post->stage4->review->switch == 0)
                <p class="text-center">
                  <a data-toggle="modal" href="#disapproveideamodal3" style="color:red;">Disapprove</a>
                </p>
                <div class="modal fade" id="disapproveideamodal3" tabindex="-1" role="dialog" aria-labelledby="disapproveideamodal3label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut2.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Disapprove this idea?</p>
                        <form action="{{ route('disapprovestatus3', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Disapprove <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage3->review->status == 'Declined')
                <p class="text-center">
                  <a data-toggle="modal" href="#rereviewideamodal3">Re-review?</a>
                </p>
                <div class="modal fade" id="rereviewideamodal3" tabindex="-1" role="dialog" aria-labelledby="rereviewideamodal3label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut4.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Re-review this idea?</p>
                        <form action="{{ route('rereviewstatus3', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Re-review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <div class="d-flex justify-content-center mb-3">
                @if($post->stage3->post_img != NULL)
                  <form action="{{ route('removepostimg3', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-image"></i></button>
                  </form>
                @endif
                @if($post->stage3->post_file != NULL)
                  <form action="{{ route('removepostfile3', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-file"></i></button>
                  </form>
                @endif
              </div>
              @if($post->stage3->title != NULL || $post->stage3->post_img != NULL || $post->stage3->description != NULL || $post->stage3->post_file != NULL)
                <p class="text-center">
                    <a data-toggle="modal" href="#reset3ideamodal2" class="btn btn-primary" style="background-color:navy; border-color:navy;">Reset <i class="fa fa-refresh"></i></a>
                </p>
                <div class="modal fade" id="reset3ideamodal2" tabindex="-1" role="dialog" aria-labelledby="reset3ideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/meteor.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Reset Stage 3?</p>
                        <form action="{{ route('resetpost3', $post->id) }}" method="POST" class="text-center">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" style="background-color:navy; border-color:navy;" onclick="return confirm('Are you sure?')">Reset <i class="fa fa-refresh"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if($post->stage3->review->reviewerid != NULL && auth()->user()->id == $post->user_id || $post->stage3->review->reviewerid != NULL && auth()->user()->role == 'Administrator' || $post->stage3->review->reviewerid != NULL && auth()->user()->role == 'Master' || $post->stage3->review->reviewerid != NULL && auth()->user()->id == $post->stage3->review->reviewerid)
              <p class="text-center mb-0" style="color:gray;">Reviewed by,</p>
              @if(auth()->user()->id == $post->stage3->review->reviewerid)
                <p class="text-center" style="color:gray;">You</p>
              @else
                <p class="text-center" style="color:gray;">{{ $post->stage3->review->reviewername }} ({{ $post->stage3->review->reviewerunit }})</p>
              @endif
            @endif
          @endauth
          @if($post->stage >= 3)
            <p class="text-center">
              <a href="#stage-2" class="page-scroll mr-2"><i class="fa fa-chevron-left"></i> Back</a>
              <a href="#stage-1" class="page-scroll"><i class="fa fa-bars"></i></a>
              @if($post->stage >= 4)
                <a href="#stage-4" class="page-scroll ml-2">Next <i class="fa fa-chevron-right"></i></a>
              @endif
            </p>
          @endif
        </div>
      </div>
    @endif
    <!-- End Stage 3 -->

    <!-- Stage 4 -->
    @if($post->stage >= 4)
      <hr/>
      <div class="row" id="stage-4">
        <div class="col-lg">
          <div class="card-body">
            @guest
              @if($post->stage4->title == NULL && $post->stage4->post_img == NULL && $post->stage4->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:maroon;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage4->review->switch == 1 || $post->stage4->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 4</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage4->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage4->title }}</h4>
                @endif
                @if($post->stage4->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage4->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage4->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage4->description)) !!}</p>
                @endif
              @endif
            @endguest
            @auth
              @if($post->stage4->title == NULL && $post->stage4->post_img == NULL && $post->stage4->description == NULL && auth()->user()->id == $post->user_id)
                <p class="display-4 text-center" style="font-size:40px;">Stage 4</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 18px; border-radius:50%; background:maroon;"><i class="fa fa-unlock-alt"></i></h1>
                </div>
                <p class="display-4 text-center" style="font-size:40px;">Unlocked!</p>
                <p class="lead text-center">You can add something here by using the panel
                  <span><i class="fa fa-right"></i></span>
                </p>
              @elseif($post->stage4->title == NULL && $post->stage4->post_img == NULL && $post->stage4->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:maroon;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage4->review->switch == 1 || $post->stage4->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 4</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage4->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage4->title }}</h4>
                @endif
                @if($post->stage4->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage4->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage4->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage4->description)) !!}</p>
                @endif
              @endif
            @endauth
          </div>
        </div>
        <div class="col-lg-3">
          @guest
            <p class="lead text-center">Stage 4,</p>
          @endguest
          @auth
            @if(auth()->user()->id != $post->user_id && auth()->user()->role == 'User')
              @if(auth()->user()->id != $post->stage4->review->reviewerid)
                <p class="lead text-center">Stage 4,</p>
              @elseif(auth()->user()->id == $post->stage4->review->reviewerid && $post->stage4->review->status == 'In Progress')
                <p class="lead text-center">Stage 4, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
                </div>
                <p class="lead text-center">{{ $post->stage4->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage4->review->reviewerid && $post->stage4->review->status == 'Approved')
                <p class="lead text-center">Stage 4, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center" style="color:green;">{{ $post->stage4->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage4->review->reviewerid && $post->stage4->review->status == 'Declined')
                <p class="lead text-center">Stage 4, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center">Done</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage4->review->status == 'Waiting' || auth()->user()->role == 'Administrator' && $post->stage4->review->status == 'Waiting' || auth()->user()->role == 'Master' && $post->stage4->review->status == 'Waiting')
              <p class="lead text-center">Stage 4, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-hourglass"></i></h1>
              </div>
              <p class="lead text-center" style="color:gray;">{{ $post->stage4->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage4->review->status == 'In Progress' || auth()->user()->role == 'Administrator' && $post->stage4->review->status == 'In Progress' || auth()->user()->role == 'Master' && $post->stage4->review->status == 'In Progress')
              <p class="lead text-center">Stage 4, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
              </div>
              <p class="lead text-center">{{ $post->stage4->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage4->review->status == 'Approved' || auth()->user()->role == 'Administrator' && $post->stage4->review->status == 'Approved' || auth()->user()->role == 'Master' && $post->stage4->review->status == 'Approved')
              <p class="lead text-center">Stage 4, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center" style="color:green;">{{ $post->stage4->review->status }}</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:green;">Proceed to Stage 5</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage4->review->status == 'Declined' || auth()->user()->role == 'Administrator' && $post->stage4->review->status == 'Declined' || auth()->user()->role == 'Master' && $post->stage4->review->status == 'Declined')
              <p class="lead text-center">Stage 4, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center">Done</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:gray;">Thankyou for your submission</p>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <p class="text-center">
                <a href="{{ route('editpost4', $post->id) }}" class="btn btn-warning" style="color:white;"><i class="fa fa-edit"></i> Add/Edit Stage 4</a>
              </p>
            @endif
          @endauth
          @if($post->stage4->post_file != NULL)
            <p class="text-center">
              <a data-toggle="modal" href="#previewfilemodal4" class="btn btn-secondary">View <i class="fa fa-file"></i></a>
            </p>
            <div class="modal fade" id="previewfilemodal4" tabindex="-1" role="dialog" aria-labelledby="previewfilemodal4label" aria-hidden="true">
              <div class="modal-dialog modal-lg" style="width:100%; height:100%;">
                <div class="modal-content bg-secondary" style="width:100%; height:100%;">
                  <div class="modal-header bg-dark border-dark">
                    <h6 class="modal-title" style="color:white;"><i class="fa fa-file"></i> File Preview</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <iframe src="{{ asset('storage/'.$post->stage4->post_file) }}" width="100%" height="100%" frameBorder="0"></iframe>
                </div>
              </div>
            </div>
          @endif
          @auth
            @if(auth()->user()->role == 'Administrator' && auth()->user()->id != $post->user_id && $post->stage4->review->switch == 0 || auth()->user()->role == 'Master' && auth()->user()->id != $post->user_id && $post->stage4->review->switch == 0)
              @if($post->stage4->title != NULL || $post->stage4->post_img != NULL || $post->stage4->description != NULL || $post->stage4->post_file != NULL)
                <p class="text-center">
                  <a data-toggle="modal" href="#reviewideamodal4" class="btn btn-primary" style="color:white;">Review <i class="fa fa-eye"></i></a>
                </p>
                <div class="modal fade" id="reviewideamodal4" tabindex="-1" role="dialog" aria-labelledby="reviewideamodal4label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/satellite.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Review this idea?</p>
                        <form action="{{ route('updatestatus4', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @elseif(auth()->user()->id == $post->stage4->review->reviewerid && $post->stage4->review->switch == 1)
              <p class="text-center">
                <a data-toggle="modal" href="#contactinfomodal" class="btn btn-primary" style="color:white;">Contact <i class="fa fa-id-card"></i></a>
              </p>
              @if($post->stage4->review->status == 'In Progress')
                <div class="d-flex justify-content-center mb-2">
                  <a data-toggle="modal" href="#declineideamodal4" class="btn btn-danger mr-1">Decline <i class="fa fa-remove"></i></a>
                  <a data-toggle="modal" href="#approveideamodal4" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
                </div>
                <div class="modal fade" id="declineideamodal4" tabindex="-1" role="dialog" aria-labelledby="declineideamodal4label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">
                        <img src="/data/asset/astronaut1.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Decline this idea?</p>
                        <form action="{{ route('declinestatus4', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Decline <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="approveideamodal4" tabindex="-1" role="dialog" aria-labelledby="approveideamodal4label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut3.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Approve this idea?</p>
                        <form action="{{ route('approvestatus4', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve <i class="fa fa-check"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="text-center">
                  <a data-toggle="modal" href="#unreviewideamodal4">Unreview?</a>
                </p>
                <div class="modal fade" id="unreviewideamodal4" tabindex="-1" role="dialog" aria-labelledby="unreviewideamodal4label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/sputnik.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Unreview this idea?</p>
                        <form action="{{ route('destroystatus4', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Unreview <i class="fa fa-eye-slash"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage4->review->status == 'Approved' && $post->stage5->review->switch == 0)
                <p class="text-center">
                  <a data-toggle="modal" href="#disapproveideamodal4" style="color:red;">Disapprove</a>
                </p>
                <div class="modal fade" id="disapproveideamodal4" tabindex="-1" role="dialog" aria-labelledby="disapproveideamodal4label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut2.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Disapprove this idea?</p>
                        <form action="{{ route('disapprovestatus4', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Disapprove <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage4->review->status == 'Declined')
                <p class="text-center">
                  <a data-toggle="modal" href="#rereviewideamodal4">Re-review?</a>
                </p>
                <div class="modal fade" id="rereviewideamodal4" tabindex="-1" role="dialog" aria-labelledby="rereviewideamodal4label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut4.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Re-review this idea?</p>
                        <form action="{{ route('rereviewstatus4', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Re-review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <div class="d-flex justify-content-center mb-2">
                @if($post->stage4->post_img != NULL)
                  <form action="{{ route('removepostimg4', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-image"></i></button>
                  </form>
                @endif
                @if($post->stage4->post_file != NULL)
                  <form action="{{ route('removepostfile4', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-file"></i></button>
                  </form>
                @endif
              </div>
              @if($post->stage4->title != NULL || $post->stage4->post_img != NULL || $post->stage4->description != NULL || $post->stage4->post_file != NULL)
                <p class="text-center">
                    <a data-toggle="modal" href="#reset4ideamodal2" class="btn btn-danger" style="background-color:maroon; border-color:maroon;">Reset <i class="fa fa-refresh"></i></a>
                </p>
                <div class="modal fade" id="reset4ideamodal2" tabindex="-1" role="dialog" aria-labelledby="reset4ideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/meteor.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Reset Stage 4?</p>
                        <form action="{{ route('resetpost4', $post->id) }}" method="POST" class="text-center">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" style="background-color:maroon; border-color:maroon;" onclick="return confirm('Are you sure?')">Reset <i class="fa fa-refresh"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if($post->stage4->review->reviewerid != NULL && auth()->user()->id == $post->user_id || $post->stage4->review->reviewerid != NULL && auth()->user()->role == 'Administrator' || $post->stage4->review->reviewerid != NULL && auth()->user()->role == 'Master' || $post->stage4->review->reviewerid != NULL && auth()->user()->id == $post->stage4->review->reviewerid)
              <p class="text-center mb-0" style="color:gray;">Reviewed by,</p>
              @if(auth()->user()->id == $post->stage4->review->reviewerid)
                <p class="text-center" style="color:gray;">You</p>
              @else
                <p class="text-center" style="color:gray;">{{ $post->stage4->review->reviewername }} ({{ $post->stage4->review->reviewerunit }})</p>
              @endif
            @endif
          @endauth
          @if($post->stage >= 4)
            <p class="text-center">
              <a href="#stage-3" class="page-scroll mr-2"><i class="fa fa-chevron-left"></i> Back</a>
              <a href="#stage-1" class="page-scroll"><i class="fa fa-bars"></i></a>
              @if($post->stage >= 5)
                <a href="#stage-5" class="page-scroll ml-2">Next <i class="fa fa-chevron-right"></i></a>
              @endif
            </p>
          @endif
        </div>
      </div>
    @endif
    <!-- End Stage 4 -->

    <!-- Stage 5 -->
    @if($post->stage >= 5)
      <hr/>
      <div class="row" id="stage-5">
        <div class="col-lg">
          <div class="card-body">
            @guest
              @if($post->stage5->title == NULL && $post->stage5->post_img == NULL && $post->stage5->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:orange;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage5->review->switch == 1 || $post->stage5->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 5</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage5->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage5->title }}</h4>
                @endif
                @if($post->stage5->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage5->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage5->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage5->description)) !!}</p>
                @endif
              @endif
            @endguest
            @auth
              @if($post->stage5->title == NULL && $post->stage5->post_img == NULL && $post->stage5->description == NULL && auth()->user()->id == $post->user_id)
                <p class="display-4 text-center" style="font-size:40px;">Stage 5</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 18px; border-radius:50%; background:orange;"><i class="fa fa-unlock-alt"></i></h1>
                </div>
                <p class="display-4 text-center" style="font-size:40px;">Unlocked!</p>
                <p class="lead text-center">You can add something here by using the panel
                  <span><i class="fa fa-right"></i></span>
                </p>
              @elseif($post->stage5->title == NULL && $post->stage5->post_img == NULL && $post->stage5->description == NULL)
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:orange;"><i class="fa fa-rocket"></i></h1>
                </div>
                @if($post->stage5->review->switch == 1 || $post->stage5->post_file != NULL)
                  <p class="display-4 text-center" style="font-size:40px;">Stage 5</p>
                @else
                  <p class="display-4 text-center" style="font-size:40px;">Coming soon!</p>
                @endif
              @else
                @if($post->stage5->title != NULL)
                  <h4 class="text-center mb-4">{{ $post->stage5->title }}</h4>
                @endif
                @if($post->stage5->post_img != NULL)
                  <div class="post-picture text-center mb-4">
                    <img src="{{ asset('storage/'.$post->stage5->post_img) }}" alt="">
                  </div>
                @endif
                @if($post->stage5->description != NULL)
                  <p align="justify">{!! nl2br(e($post->stage5->description)) !!}</p>
                @endif
              @endif
            @endauth
          </div>
        </div>
        <div class="col-lg-3">
          @guest
            <p class="lead text-center">Stage 5,</p>
          @endguest
          @auth
            @if(auth()->user()->id != $post->user_id && auth()->user()->role == 'User')
              @if(auth()->user()->id != $post->stage5->review->reviewerid)
                <p class="lead text-center">Stage 5,</p>
              @elseif(auth()->user()->id == $post->stage5->review->reviewerid && $post->stage5->review->status == 'In Progress')
                <p class="lead text-center">Stage 5, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
                </div>
                <p class="lead text-center">{{ $post->stage5->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage5->review->reviewerid && $post->stage5->review->status == 'Approved')
                <p class="lead text-center">Stage 5, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center" style="color:green;">{{ $post->stage5->review->status }}</p>
              @elseif(auth()->user()->id == $post->stage5->review->reviewerid && $post->stage5->review->status == 'Declined')
                <p class="lead text-center">Stage 5, status:</p>
                <div class="section-title">
                  <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
                </div>
                <p class="lead text-center">Done</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage5->review->status == 'Waiting' || auth()->user()->role == 'Administrator' && $post->stage5->review->status == 'Waiting' || auth()->user()->role == 'Master' && $post->stage5->review->status == 'Waiting')
              <p class="lead text-center">Stage 5, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-hourglass"></i></h1>
              </div>
              <p class="lead text-center" style="color:gray;">{{ $post->stage5->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage5->review->status == 'In Progress' || auth()->user()->role == 'Administrator' && $post->stage5->review->status == 'In Progress' || auth()->user()->role == 'Master' && $post->stage5->review->status == 'In Progress')
              <p class="lead text-center">Stage 5, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:gray;"><i class="fa fa-tasks"></i></h1>
              </div>
              <p class="lead text-center">{{ $post->stage5->review->status }}</p>
            @elseif(auth()->user()->id == $post->user_id && $post->stage5->review->status == 'Approved' || auth()->user()->role == 'Administrator' && $post->stage5->review->status == 'Approved' || auth()->user()->role == 'Master' && $post->stage5->review->status == 'Approved')
              <p class="lead text-center">Stage 5, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:green;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center" style="color:green;">{{ $post->stage5->review->status }}</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:green;">Congratulations!</p>
              @endif
            @elseif(auth()->user()->id == $post->user_id && $post->stage5->review->status == 'Declined' || auth()->user()->role == 'Administrator' && $post->stage5->review->status == 'Declined' || auth()->user()->role == 'Master' && $post->stage5->review->status == 'Declined')
              <p class="lead text-center">Stage 5, status:</p>
              <div class="section-title">
                <h1 class="display-4" style="padding:10px 14px; border-radius:50%; background:black;"><i class="fa fa-check"></i></h1>
              </div>
              <p class="lead text-center">Done</p>
              @if(auth()->user()->id == $post->user_id)
                <p class="text-center" style="color:gray;">Thankyou for your submission</p>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <p class="text-center">
                <a href="{{ route('editpost5', $post->id) }}" class="btn btn-warning" style="color:white;"><i class="fa fa-edit"></i> Add/Edit Stage 5</a>
              </p>
            @endif
          @endauth
          @if($post->stage5->post_file != NULL)
            <p class="text-center">
              <a data-toggle="modal" href="#previewfilemodal5" class="btn btn-secondary">View <i class="fa fa-file"></i></a>
            </p>
            <div class="modal fade" id="previewfilemodal5" tabindex="-1" role="dialog" aria-labelledby="previewfilemodal5label" aria-hidden="true">
              <div class="modal-dialog modal-lg" style="width:100%; height:100%;">
                <div class="modal-content bg-secondary" style="width:100%; height:100%;">
                  <div class="modal-header bg-dark border-dark">
                    <h6 class="modal-title" style="color:white;"><i class="fa fa-file"></i> File Preview</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <iframe src="{{ asset('storage/'.$post->stage5->post_file) }}" width="100%" height="100%" frameBorder="0"></iframe>
                </div>
              </div>
            </div>
          @endif
          @auth
            @if(auth()->user()->role == 'Administrator' && auth()->user()->id != $post->user_id && $post->stage5->review->switch == 0 || auth()->user()->role == 'Master' && auth()->user()->id != $post->user_id && $post->stage5->review->switch == 0)
              @if($post->stage5->title != NULL || $post->stage5->post_img != NULL || $post->stage5->description != NULL || $post->stage5->post_file != NULL)
                <p class="text-center">
                  <a data-toggle="modal" href="#reviewideamodal5" class="btn btn-primary" style="color:white;">Review <i class="fa fa-eye"></i></a>
                </p>
                <div class="modal fade" id="reviewideamodal5" tabindex="-1" role="dialog" aria-labelledby="reviewideamodal5label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/satellite.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Review this idea?</p>
                        <form action="{{ route('updatestatus5', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @elseif(auth()->user()->id == $post->stage5->review->reviewerid && $post->stage5->review->switch == 1)
              <p class="text-center">
                <a data-toggle="modal" href="#contactinfomodal" class="btn btn-primary" style="color:white;">Contact <i class="fa fa-id-card"></i></a>
              </p>
              @if($post->stage5->review->status == 'In Progress')
                <div class="d-flex justify-content-center mb-2">
                  <a data-toggle="modal" href="#declineideamodal5" class="btn btn-danger mr-1">Decline <i class="fa fa-remove"></i></a>
                  <a data-toggle="modal" href="#approveideamodal5" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
                </div>
                <div class="modal fade" id="declineideamodal5" tabindex="-1" role="dialog" aria-labelledby="declineideamodal5label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut1.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Decline this idea?</p>
                        <form action="{{ route('declinestatus5', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Decline <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="approveideamodal5" tabindex="-1" role="dialog" aria-labelledby="approveideamodal5label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut3.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Approve this idea?</p>
                        <form action="{{ route('approvestatus5', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve <i class="fa fa-check"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="text-center">
                  <a data-toggle="modal" href="#unreviewideamodal5">Unreview?</a>
                </p>
                <div class="modal fade" id="unreviewideamodal5" tabindex="-1" role="dialog" aria-labelledby="unreviewideamodal5label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/sputnik.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Unreview this idea?</p>
                        <form action="{{ route('destroystatus5', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Unreview <i class="fa fa-eye-slash"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage5->review->status == 'Approved')
                <p class="text-center">
                  <a data-toggle="modal" href="#disapprovedideamodal5" style="color:red;">Disapprove</a>
                </p>
                <div class="modal fade" id="disapprovedideamodal5" tabindex="-1" role="dialog" aria-labelledby="disapprovedideamodal5label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut2.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white; font-size:40px;">Disapprove this idea?</p>
                        <form action="{{ route('disapprovestatus5', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Disapproved <i class="fa fa-times"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @elseif($post->stage5->review->status == 'Declined')
                <p class="text-center">
                  <a data-toggle="modal" href="#rereviewideamodal5">Re-review?</a>
                </p>
                <div class="modal fade" id="rereviewideamodal5" tabindex="-1" role="dialog" aria-labelledby="rereviewideamodal5label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/astronaut4.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Re-review this idea?</p>
                        <form action="{{ route('rereviewstatus5', $post->id) }}" method="POST">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Re-review <i class="fa fa-eye"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if(auth()->user()->id == $post->user_id)
              <div class="d-flex justify-content-center mb-2">
                @if($post->stage5->post_img != NULL)
                  <form action="{{ route('removepostimg5', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-image"></i></button>
                  </form>
                @endif
                @if($post->stage5->post_file != NULL)
                  <form action="{{ route('removepostfile5', $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove <i class="fa fa-file"></i></button>
                  </form>
                @endif
              </div>
              @if($post->stage5->title != NULL || $post->stage5->post_img != NULL || $post->stage5->description != NULL || $post->stage5->post_file != NULL)
                <p class="text-center">
                  <a data-toggle="modal" href="#reset5ideamodal2" class="btn btn-warning" style="color:white; background-color:orange; border-color:orange;">Reset <i class="fa fa-refresh"></i></a>
                </p>
                <div class="modal fade" id="reset5ideamodal2" tabindex="-1" role="dialog" aria-labelledby="reset5ideamodal2label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content idea-modal">
                      <div class="modal-body text-center">    
                        <img src="/data/asset/meteor.png" class="m-4" width="100px" alt="">
                        <p class="display-4" style="color:white;">Reset Stage 5?</p>
                        <form action="{{ route('resetpost5', $post->id) }}" method="POST" class="text-center">
                          @method('PATCH')
                          @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" style="color:white; background-color:orange; border-color:orange;" onclick="return confirm('Are you sure?')">Reset <i class="fa fa-refresh"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
            @if($post->stage5->review->reviewerid != NULL && auth()->user()->id == $post->user_id || $post->stage5->review->reviewerid != NULL && auth()->user()->role == 'Administrator' || $post->stage5->review->reviewerid != NULL && auth()->user()->role == 'Master' || $post->stage5->review->reviewerid != NULL && auth()->user()->id == $post->stage5->review->reviewerid)
              <p class="text-center mb-0" style="color:gray;">Reviewed by,</p>
              @if(auth()->user()->id == $post->stage5->review->reviewerid)
                <p class="text-center" style="color:gray;">You</p>
              @else
                <p class="text-center" style="color:gray;">{{ $post->stage5->review->reviewername }} ({{ $post->stage5->review->reviewerunit }})</p>
              @endif
            @endif
          @endauth
          @if($post->stage >= 5)
            <p class="text-center">
              <a href="#stage-4" class="page-scroll mr-2"><i class="fa fa-chevron-left"></i> Back</a>
              <a href="#stage-1" class="page-scroll"><i class="fa fa-bars"></i></a>
            </p>
          @endif
        </div>
      </div>
    @endif
    <!-- End Stage 5 -->

    <!-- Comment Section -->
    <div class="row">
      <div class="col-lg-9">
        <hr/>
        <div class="card-body">
          <form method="POST" action="{{ route('comment') }}">
            @csrf
            <div class="form-group">
              <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}" />
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
                          <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}" />
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
    </div>
    <!-- End Comment Section -->

    <!-- Delete Article -->
    @auth
      @if(auth()->user()->id == $post->user_id)
        <div class="row justify-content-end">
          <div class="col-lg-3 text-center">
            <hr/>
            <div class="text-center pb-3">
              <a data-toggle="modal" href="#deleteideamodal" style="color: red;">Delete Idea</a>
            </div>
            <div class="modal fade" id="deleteideamodal" tabindex="-1" role="dialog" aria-labelledby="deleteideamodallabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content idea-modal">
                  <div class="modal-body">    
                    <img src="/data/asset/moon.png" class="m-4" width="100px" alt="">
                    <p class="lead text-center mb-0" style="color:white;">Warning: <br>All your progress will be lost!</p>
                    <p class="display-4" style="color:white;">Are you sure?</p>
                    <form action="{{ route('deletepost', $post->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('This action can\'t be undone! Do you want to proceed?')">Delete <i class="fa fa-trash"></i></button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endauth
    <!-- End Delete Article -->

  </div>
</div>
<!-- End Article -->
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
                <h6 class="mt-2">{{ \Illuminate\Support\Str::limit($liker->user->name, 22) }}</h6>
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

<div class="modal fade" id="contactinfomodal" tabindex="-1" role="dialog" aria-labelledby="contactinfomodallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <h5 class="card-header text-center">Contact Information
        <span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:black;">&times;</span>
          </button>
        </span>
      </h5>
      <div class="modal-body text-center">    
        <p class="lead text-center">Innovator,</p>
        <div class="contact-picture">
          @if($post->user->profile_img == NULL)
            <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:100px; height:100px; object-fit:cover;" alt="">
          @else
            <img src="{{ asset('storage/'.$post->user->profile_img) }}" class="rounded-circle" style="width:100px; height:100px; object-fit:cover;" alt="">
          @endif
        </div>
        <p class="lead text-center mb-0">{{$post->user->employeeid}}</p>
        <p class="lead text-center mb-0">Unit {{$post->user->unit->name}}</p>
        <h1 class="display-4" style="font-size:40px;">{{$post->user->name}}</h1>
        <p class="lead text-center">
          <span><i class="fa fa-envelope fa-fw" style="color:black;" aria-hidden="true"></i> </span>{{$post->user->email}}
        </p>
        @if($post->user->phonenumber != NULL)
          <p class="lead text-center">
            <i class="fa fa-whatsapp fa-fw" style="color:#25D366;"></i>
            <a href="https://wa.me/62{{$post->user->phonenumber}}?text={{url()->current()}}">Chat Via WhatsApp</a>
          </p>
        @endif
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection