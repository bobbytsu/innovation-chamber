@extends('layout/main')
@section('title', 'Dashboard · Innovation Chamber')
@section('content')
<!-- Profile -->
<div class="container profile">
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
  <div class="card profile-card shadow px-4 pb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-lg">
          <p class="lead d-inline">Innovator,</p>
          @if(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Master')
            <p class="lead d-inline float-right">{{auth()->user()->role}}</p>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 profile-picture">
          @if(auth()->user()->profile_img == NULL)
            <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" alt="">
          @else
            <img src="{{ asset('storage/'.auth()->user()->profile_img) }}" class="rounded-circle" alt="">
          @endif
          @if(auth()->user()->profile_img != NULL)
            <form action="{{ route('removeprofileimg') }}" method="POST">
              @method('DELETE')
              @csrf
                <button type="submit" class="btn btn-danger mt-4" onclick="return confirm('Are you sure?')">Remove Profile <i class="fa fa-image"></i></button>
            </form>
          @endif
        </div>
        <div class="col-lg">
          <div class="row">
            <div class="col-lg">
              <p class="lead mb-0">{{auth()->user()->employeeid}}</p>
              <p class="lead mb-0">Unit {{auth()->user()->unit->name}}</p>
            </div>
            <div class="col-lg">
              <a class="btn btn-warning float-right" href="{{ route('editprofile') }}" style="color: white;"><i class="fa fa-edit"></i> Edit Profile</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <h1 class="display-4">{{auth()->user()->name}}</h1>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <p class="lead">
                <span><i class="fa fa-envelope fa-fw" style="color:black;" aria-hidden="true"></i> </span>{{auth()->user()->email}}
              </p>
            </div>
            <div class="col-lg">
              @if(auth()->user()->phonenumber != NULL)
                <p class="lead">
                  <span><i class="fa fa-whatsapp fa-fw" style="color:#25D366;" aria-hidden="true"></i> </span>0{{auth()->user()->phonenumber}}
                </p>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              @if(auth()->user()->bio != NULL)
                <p class="lead">
                  <span><i class="fa fa-quote-left fa-fw" style="color:black;" aria-hidden="true"></i> </span>{{auth()->user()->bio}}
                  <span> <i class="fa fa-quote-right fa-fw" style="color:black;" aria-hidden="true"></i></span>
                </p>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="row pt-4">
        <div class="col-lg-3 mb-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-agenda-list" data-toggle="list" href="#list-agenda" role="tab" aria-controls="agenda">AGENDA</a>
            <a class="list-group-item list-group-item-action" id="list-notification-list" data-toggle="list" href="#list-notification" role="tab" aria-controls="notification">NOTIFICATION <span class="badge badge-danger float-right">0</span></a>
            <a class="list-group-item list-group-item-action" id="list-mypost-list" data-toggle="list" href="#list-mypost" role="tab" aria-controls="mypost">MY POST</a>
            @if(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Master')
              <a class="list-group-item list-group-item-action" id="list-upload-list" data-toggle="list" href="#list-upload" role="tab" aria-controls="upload">MY VIDEO</a>
              <a class="list-group-item list-group-item-action" id="list-manage-idea-list" data-toggle="list" href="#list-manage-idea" role="tab" aria-controls="manage-idea">MANAGE IDEA</a>
            @endif
            @if(auth()->user()->role == 'Master')
              <a class="list-group-item list-group-item-action" id="list-manage-user-list" data-toggle="list" href="#list-manage-user" role="tab" aria-controls="manage-user">MANAGE USER</a>
            @endif
          </div>
        </div>
        <div class="col-lg">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-agenda" role="tabpanel" aria-labelledby="list-agenda-list">
              <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.min.css' />
              <div class="mb-3" id='calendar'></div>
              <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js'></script>
              <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.min.js'></script>
              <script>
                $(document).ready(function() {
                  $('#calendar').fullCalendar({
                    eventLimit: 3,
                    events : [
                      @foreach($events as $event)
                      {
                        id : '{{ $event->id }}',
                        title : '{{ $event->title }}',
                        start : '{{ $event->start }}',
                        @if($event->end)
                          end : '{{ $event->endplus }}',
                        @endif
                      },
                      @endforeach
                    ],
                    eventRender: function(eventObj, $el) {
                      $el.popover({
                        title: eventObj.title,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                      });
                    },
                    contentHeight: "auto"
                  });
                });
              </script>
              @if(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Master')
                <a href="{{ route('event') }}" class="btn btn-primary float-right">Add Event <i class="fa fa-calendar-plus"></i></a>
              @endif
              <p class="lead">Upcoming Event</p>
              <hr/>
              @forelse($events as $event)
                @if($event->start >= $now)
                  <div class="alert alert-info">
                    <div>
                      <span class="float-right"><small class="text-muted"><i class="fa fa-calendar"></i> {{ $event->user->name }} ({{ $event->user->unit->name }})</small></span>
                      <h4 class="alert-heading">{{ $event->title }}</h4>
                    </div>
                    <p>{!! nl2br(e($event->description)) !!}</p>
                    <hr>
                    @if(auth()->user()->id == $event->user_id)
                      <a href="{{ route('editevent', $event->id) }}" class="btn btn-warning rounded-circle float-right"><i class="fa fa-edit" style="color:white;"></i></a>
                    @endif
                    <p>
                      {{ \Carbon\Carbon::parse($event->start)->format('l, j M Y') }}
                      @if($event->end != NULL)
                        - {{ \Carbon\Carbon::parse($event->end)->format('l, j M Y') }}
                      @endif
                    </p>
                  </div>
                @elseif($event->end != NULL && $event->end >= $now)
                  <div class="alert alert-info">
                    <div>
                      <span class="float-right"><small class="text-muted"><i class="fa fa-calendar"></i> {{ $event->user->name }} ({{ $event->user->unit->name }})</small></span>
                      <h4 class="alert-heading">{{ $event->title }}</h4>
                    </div>
                    <p>{!! nl2br(e($event->description)) !!}</p>
                    <hr>
                    @if(auth()->user()->role == 'Administrator' && auth()->user()->id == $event->user_id)
                      <a href="{{ route('editevent', $event->id) }}" class="btn btn-warning rounded-circle float-right"><i class="fa fa-edit" style="color:white;"></i></a>
                    @endif
                    <p>
                      {{ \Carbon\Carbon::parse($event->start)->format('l, j M Y') }}
                      @if($event->end != NULL)
                        - {{ \Carbon\Carbon::parse($event->end)->format('l, j M Y') }}
                      @endif
                    </p>
                  </div>
                @endif
              @empty
                <p class="lead text-center py-5">No event yet</p>
              @endforelse
              <p class="lead" style="margin-top:200px;">All Event</p>
              <hr/>
              @forelse($events as $event)
                @if($thisyear == \Carbon\Carbon::parse($event->start)->format('Y'))
                  <div class="alert alert-info">
                    <div>
                      <span class="float-right"><small class="text-muted"><i class="fa fa-calendar"></i> {{ $event->user->name }} ({{ $event->user->unit->name }})</small></span>
                      <h4 class="alert-heading">{{ $event->title }}</h4>
                    </div>
                    <p>{!! nl2br(e($event->description)) !!}</p>
                    <hr>
                    @if(auth()->user()->id == $event->user_id)
                      <a href="{{ route('editevent', $event->id) }}" class="btn btn-warning rounded-circle float-right"><i class="fa fa-edit" style="color:white;"></i></a>
                    @endif
                    <p>
                      {{ \Carbon\Carbon::parse($event->start)->format('l, j M Y') }}
                      @if($event->end != NULL)
                        - {{ \Carbon\Carbon::parse($event->end)->format('l, j M Y') }}
                      @endif
                    </p>
                  </div>
                @endif
              @empty
                <p class="lead text-center py-5">No event yet</p>
              @endforelse
            </div>
            <div class="tab-pane fade" id="list-notification" role="tabpanel" aria-labelledby="list-notification-list">
              <div class="list-group">
                <div>
                  <p class="lead">Notification</p>
                  <hr/>
                </div>
                <div class="text-center p-5">
                  <i class="fas fa-drafting-compass"></i>
                  <p class="lead text-center">This feature is currently under development</p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade show" id="list-mypost" role="tabpanel" aria-labelledby="list-mypost-list">
              <div class="list-group">
                <div>
                  <p class="lead">My Post</p>
                  <hr/>
                </div>
                @forelse($posts as $post)
                  @if(auth()->user()->id == $post->user_id)
                    <a href="{{ route('post', $post->id) }}" class="list-group-item list-group-item-action">
                      {{ $post->stage1->title }}
                      <b class="float-right">
                        Stage {{ $post->stage }},
                        @if( $post->stage == 1)
                          status:
                          @if($post->stage1->review->status == 'Declined')
                            Done
                          @else
                            {{ $post->stage1->review->status }}
                          @endif
                        @elseif($post->stage == 2)
                          status:
                          @if($post->stage2->review->status == 'Declined')
                            Done
                          @else
                            {{ $post->stage2->review->status }}
                          @endif
                        @elseif($post->stage == 3)
                          status:
                          @if($post->stage3->review->status == 'Declined')
                            Done
                          @else
                            {{ $post->stage3->review->status }}
                          @endif
                        @elseif($post->stage == 4)
                          status:
                          @if($post->stage4->review->status == 'Declined')
                            Done
                          @else
                            {{ $post->stage4->review->status }}
                          @endif
                        @elseif($post->stage == 5)
                          status:
                          @if($post->stage5->review->status == 'Declined')
                            Done
                          @else
                            {{ $post->stage5->review->status }}
                          @endif
                        @endif
                      </b>
                    </a>
                  @endif
                @empty
                  <p class="lead text-center py-5">No post yet</p>
                @endforelse
                <div class="text-center mt-5">
                  <p class="lead text-muted text-center">You can submit your idea here</p>
                  <a href="{{ route('submit') }}" class="btn btn-primary" style="color:white">Submit <i class="fa fa-rocket" style="color:yellow"></i></a>
                </div>
              </div>
            </div>
            @if(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Master')
              <div class="tab-pane fade show" id="list-upload" role="tabpanel" aria-labelledby="list-upload-list">
                <div class="list-group">
                  <div>
                    <p class="lead">My Video</p>
                    <hr/>
                  </div>
                  @forelse($uploads as $upload)
                    @if(auth()->user()->id == $upload->user_id)
                      <div class="card thumbnail-card mx-3 mt-3">
                        <a href="{{ route('video', $upload->id) }}" style="text-decoration:none; color:black;">
                          <div class="row no-gutters">
                            <div class="col-md">
                              <div class="thumbnail">
                                <img src="{{ asset('data/knowledge system/'.$upload->thumbnail) }}" class="card-img" alt="">
                                <div class="overlay">     
                                  <i class="fa fa-play"></i>           
                                </div>
                              </div>
                            </div>
                            <div class="col-md">
                              <div class="card-body">
                                <h5 class="card-title mb-0" title="{{ $upload->title }}">{{ \Illuminate\Support\Str::limit($upload->title, 62) }}</h5>
                                <p class="text-muted">
                                  <small>{{ \Carbon\Carbon::parse($upload->created_at)->format('M j, Y') }}</small>
                                </p>
                                <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($upload->description, 88) }}</p>
                              </div>
                            </div>
                          </div>     
                        </a>
                      </div>
                    @endif
                  @empty
                    <p class="lead text-center py-5">No upload yet</p>
                  @endforelse
                  <div class="text-center mt-5">
                    <p class="lead text-muted text-center">You can upload your video here</p>
                    <a href="{{ route('upload') }}" class="btn btn-danger" style="color:white">Upload <i class="fa fa-video"></i></a>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="list-manage-idea" role="tabpanel" aria-labelledby="list-manage-idea-list">
                <div class="row">
                  <div class="col-lg">
                    <p class="lead">Manage Idea</p>
                  </div>
                  <div class="col-lg">
                    <div class="input-group justify-content-end">
                      <div class="input-group-prepend">
                        <input class="form-control" style="box-shadow: none; border-color:lightgray;" type="text" id="i-input" placeholder="Search">
                      </div>
                      <div class="input-group-append">
                        <div class="input-group-text" style="background-color:white; border-left:white;">
                          <i class="fa fa-search"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr/>
                <div class="list-group">
                  @forelse($posts as $post)
                    @if(auth()->user()->id != $post->user_id)
                      <a href="{{ route('post', $post->id) }}" class="list-group-item list-group-item-action" data-role="i">
                        {{ $post->stage1->title }}
                        <b class="float-right">
                          Stage {{ $post->stage }},
                          @if( $post->stage == 1)
                            status: {{ $post->stage1->review->status }}
                          @elseif($post->stage == 2)
                            status: {{ $post->stage2->review->status }}
                          @elseif($post->stage == 3)
                            status: {{ $post->stage3->review->status }}
                          @elseif($post->stage == 4)
                            status: {{ $post->stage4->review->status }}
                          @elseif($post->stage == 5)
                            status: {{ $post->stage5->review->status }}
                          @endif
                        </b>
                      </a>
                    @endif
                  @empty
                    <p class="lead text-center py-5">No post yet</p>
                  @endforelse
                </div>
              </div>
            @endif
            @if(auth()->user()->role == 'Master')
              <div class="tab-pane fade show" id="list-manage-user" role="tabpanel" aria-labelledby="list-manage-user-list">
                <div class="row">
                  <div class="col-lg">
                    <p class="lead">Manage User</p>
                  </div>
                  <div class="col-lg">
                    <div class="input-group justify-content-end">
                      <div class="input-group-prepend">
                        <input class="form-control" style="box-shadow: none; border-color:lightgray;" type="text" id="u-input" placeholder="Search">
                      </div>
                      <div class="input-group-append">
                        <div class="input-group-text" style="background-color:white; border-left:white;">
                          <i class="fa fa-search"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr/>
                <ul class="list-group">  
                  @foreach($users as $user)
                    @if(auth()->user()->id != $user->id)
                      <li class="list-group-item list-group-item-action" data-role="u">
                        <div class="row">
                          <div class="col-lg-2">
                            {{ $user->employeeid }}
                          </div>
                          <div class="col-lg">
                            {{ $user->name }}
                          </div>
                          <div class="col-lg-1">
                            {{ $user->unit->name }}
                          </div>
                          <div class="col-lg-2">
                            @if($user->role == 'Administrator')
                              Admin
                            @else
                              {{ $user->role }}
                            @endif
                          </div>
                          <div class="col-lg">
                            <form method="POST" action="{{ route('resetpassword', $user->id) }}">
                              @method('PATCH')
                              @csrf
                                <button type="submit" class="btn btn-warning btn-sm float-right" style="color:white;" onclick="return confirm('Reset {{$user->name}} password?')">Reset Password</button>
                            </form>
                          </div>
                          <div class="col-lg">
                            @if($user->role == 'User')
                              <form method="POST" action="{{ route('upgradeuser', $user->id) }}">
                                @method('PATCH')
                                @csrf
                                  <button type="submit" class="btn btn-success btn-sm float-right" onclick="return confirm('Upgrade User to Administrator?')">Upgrade</button>
                              </form>
                            @elseif($user->role == 'Administrator')
                              <form method="POST" action="{{ route('downgradeuser', $user->id) }}">
                                @method('PATCH')
                                @csrf
                                  <button type="submit" class="btn btn-danger btn-sm float-right" onclick="return confirm('Downgrade Administrator to User?')">Downgrade</button>
                              </form>
                            @endif
                          </div>
                        </div>
                      </li>
                    @endif
                  @endforeach
                </ul>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Profile -->
@endsection