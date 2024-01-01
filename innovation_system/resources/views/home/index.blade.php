@extends('layout/main')
@section('title', 'Innovation Chamber')
@section('content')
<!-- Landing -->
<section class="landing">
  <div class="container">
    <div class="row welcome">
      <div class="col-lg">
        <h1 class="display-4">Welcome to <strong>Innovation Chamber</strong></h1>
        <p class="lead">Please submit your <strong>idea</strong> here</p>
        <div class="tombol-alignment">
            <a href="{{ route('submit') }}" type="button" class="btn btn-primary tombol">Submit</a>
        </div>
      </div>
      <div class="col-lg">
        <div class="card shadow float-right" style="width: 19rem;">
          <div class="card-body">
            <h5>
              <span><img src="/data/asset/crown.png" width="25px"> </span>Popular Ideas
            </h5>
            <ul class="list-unstyled popular-list">
              @forelse($populars as $popular)
                <a href="{{ route('post', $popular->id) }}" style="text-decoration: none;">
                  <li class="media">
                    <h2 class="rank" style="color: gold;">#{{$loop->iteration}}</h2>
                    <div class="media-body">
                      <h6 style="color:black;" title="{{$popular->stage1->title}}">{{ \Illuminate\Support\Str::limit($popular->stage1->title, 27) }}</h6>
                      @if($popular->contributor != NULL)
                        <img src="{{ asset('data/asset/person.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                        <small class="text-muted" title="{{ $popular->user->name }} ({{ $popular->user->unit->name }}), {{ $popular->contributor }}">{{ \Illuminate\Support\Str::limit($popular->user->name, 10) }} ({{ $popular->user->unit->name }}), {{ \Illuminate\Support\Str::limit($popular->contributor, 10) }}</small>
                      @else
                        @if($popular->user->profile_img == NULL)
                          <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                        @else
                          <img src="{{ asset('storage/'.$popular->user->profile_img) }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                        @endif
                        <small class="text-muted" title="{{ $popular->user->name }} ({{ $popular->user->unit->name }})">{{ \Illuminate\Support\Str::limit($popular->user->name, 25) }} ({{ $popular->user->unit->name }})</small>
                      @endif
                      <p class="ml-4">
                        <small style="color:#0275d8;" title="@if($popular->likes->count() > 1)Likes @else Like @endif"><i class="fa fa-thumbs-o-up"></i> {{ $popular->likes->count() }}</small>
                        &nbsp;
                        <small style="color:gray;" title="@if($popular->comments->count() > 1)Comments @else Comment @endif"><i class="fa fa-commenting"></i> {{ $popular->comments->count() }}</small>
                      </p>
                    </div>
                  </li>
                </a>
              @empty
                <p class="lead text-center py-5" style="color:black;">No post yet</p>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Landing -->
<!-- Carousel -->
<div class="section-title">
  <h1 class="display-4 text-center">Top This Season</h1>
</div>
<section class="top-season">
  <div class="container">  
    <div class="row">
      <div class="col-lg">
        <div id="SeasonCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#SeasonCarousel" data-slide-to="0" class="@if(\Carbon\Carbon::now()->format('n') == 3 || \Carbon\Carbon::now()->format('n') == 4 || \Carbon\Carbon::now()->format('n') == 5) active @endif"></li>
            <li data-target="#SeasonCarousel" data-slide-to="1" class="@if(\Carbon\Carbon::now()->format('n') == 6 || \Carbon\Carbon::now()->format('n') == 7 || \Carbon\Carbon::now()->format('n') == 8) active @endif"></li>
            <li data-target="#SeasonCarousel" data-slide-to="2" class="@if(\Carbon\Carbon::now()->format('n') == 9 || \Carbon\Carbon::now()->format('n') == 10 || \Carbon\Carbon::now()->format('n') == 11) active @endif"></li>
            <li data-target="#SeasonCarousel" data-slide-to="3" class="@if(\Carbon\Carbon::now()->format('n') == 12 || \Carbon\Carbon::now()->format('n') == 1 || \Carbon\Carbon::now()->format('n') == 2) active @endif"></li>
          </ol>
          <div class="carousel-inner">
            <div class="item carousel-item @if(\Carbon\Carbon::now()->format('n') == 3 || \Carbon\Carbon::now()->format('n') == 4 || \Carbon\Carbon::now()->format('n') == 5) active @endif">
              <h1 class="display-4 text-center">
                <span><img src="/data/asset/leaf.png" width="30px"> </span>Spring
              </h1>
              <div class="card-deck justify-content-center">
                @forelse($springs as $spring)
                  @if($thisyear == \Carbon\Carbon::parse($spring->created_at)->format('Y'))
                    <div class="card" style="max-width:14rem;">
                      @if($spring->stage1->post_img != NULL)
                        <img src="{{ asset('storage/'.$spring->stage1->post_img) }}" class="card-img-top mx-auto d-block" style="width:100%; height:130px; object-fit:cover;" alt="...">
                      @endif
                      <div class="card-body">
                        <small>{{ $spring->category->name }}</small>
                        <h6 title="{{$spring->stage1->title}}">{{ \Illuminate\Support\Str::limit($spring->stage1->title, 23) }}</h6>
                        @if($spring->contributor != NULL)
                          <img src="{{ asset('data/asset/person.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          <small class="text-muted" title="{{ $spring->user->name }} ({{ $spring->user->unit->name }}), {{ $spring->contributor }}">{{ \Illuminate\Support\Str::limit($spring->user->name, 8) }} ({{ $spring->user->unit->name }}), {{ \Illuminate\Support\Str::limit($spring->contributor, 8) }}</small>
                        @else
                          @if($spring->user->profile_img == NULL)
                            <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @else
                            <img src="{{ asset('storage/'.$spring->user->profile_img) }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @endif
                          <small class="text-muted" title="{{ $spring->user->name }} ({{ $spring->user->unit->name }})">{{ \Illuminate\Support\Str::limit($spring->user->name, 20) }} ({{ $spring->user->unit->name }})</small>
                        @endif
                        <p class="card-text pt-3">{{ \Illuminate\Support\Str::limit($spring->stage1->description, 89) }}</p>
                        <p>
                          <small style="color:#0275d8;" title="@if($spring->likes->count() > 1)Likes @else Like @endif"><i class="fa fa-thumbs-o-up"></i> {{ $spring->likes->count() }}</small>
                          &nbsp;
                          <small style="color:gray;" title="@if($spring->comments->count() > 1)Comments @else Comment @endif"><i class="fa fa-commenting"></i> {{ $spring->comments->count() }}</small>
                          <a href="{{ route('post', $spring->id) }}" class="card-link float-right">Read more</a>
                        </p>
                      </div>
                    </div>
                  @endif
                @empty
                  <h1 class="text-center mx-auto" style="padding-top:175px; padding-bottom:176px;">No post yet</h1>
                @endforelse
              </div>
            </div>
            <div class="item carousel-item @if(\Carbon\Carbon::now()->format('n') == 6 || \Carbon\Carbon::now()->format('n') == 7 || \Carbon\Carbon::now()->format('n') == 8) active @endif">
              <h1 class="display-4 text-center">
                <span><img src="/data/asset/sunset.png" width="30px"> </span>Summer
              </h1>
              <div class="card-deck justify-content-center">
                @forelse($summers as $summer)
                  @if($thisyear == \Carbon\Carbon::parse($summer->created_at)->format('Y'))
                    <div class="card" style="max-width:14rem;">
                      @if($summer->stage1->post_img != NULL)
                        <img src="{{ asset('storage/'.$summer->stage1->post_img) }}" class="card-img-top mx-auto d-block" style="width:100%; height:130px; object-fit:cover;" alt="...">
                      @endif
                      <div class="card-body">
                        <small>{{ $summer->category->name }}</small>
                        <h6 title="{{$summer->stage1->title}}">{{ \Illuminate\Support\Str::limit($summer->stage1->title, 23) }}</h6>
                        @if($summer->contributor != NULL)
                          <img src="{{ asset('data/asset/person.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          <small class="text-muted" title="{{ $summer->user->name }} ({{ $summer->user->unit->name }}), {{ $summer->contributor }}">{{ \Illuminate\Support\Str::limit($summer->user->name, 8) }} ({{ $summer->user->unit->name }}), {{ \Illuminate\Support\Str::limit($summer->contributor, 8) }}</small>
                        @else
                          @if($summer->user->profile_img == NULL)
                            <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @else
                            <img src="{{ asset('storage/'.$summer->user->profile_img) }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @endif
                          <small class="text-muted" title="{{ $summer->user->name }} ({{ $summer->user->unit->name }})">{{ \Illuminate\Support\Str::limit($summer->user->name, 20) }} ({{ $summer->user->unit->name }})</small>
                        @endif
                        <p class="card-text pt-3">{{ \Illuminate\Support\Str::limit($summer->stage1->description, 89) }}</p>
                        <p>
                          <small style="color:#0275d8;" title="@if($summer->likes->count() > 1)Likes @else Like @endif"><i class="fa fa-thumbs-o-up"></i> {{ $summer->likes->count() }}</small>
                          &nbsp;
                          <small style="color:gray;" title="@if($summer->comments->count() > 1)Comments @else Comment @endif"><i class="fa fa-commenting"></i> {{ $summer->comments->count() }}</small>
                          <a href="{{ route('post', $summer->id) }}" class="card-link float-right">Read more</a>
                        </p>
                      </div>
                    </div>
                  @endif
                @empty
                  <h1 class="text-center mx-auto" style="padding-top:175px; padding-bottom:176px;">No post yet</h1>
                @endforelse
              </div>
            </div>
            <div class="item carousel-item @if(\Carbon\Carbon::now()->format('n') == 9 || \Carbon\Carbon::now()->format('n') == 10 || \Carbon\Carbon::now()->format('n') == 11) active @endif">
              <h1 class="display-4 text-center">
                <span><img src="/data/asset/oak.png" width="30px"> </span>Autumn
              </h1>
              <div class="card-deck justify-content-center">
                @forelse($autumns as $autumn)
                  @if($thisyear == \Carbon\Carbon::parse($autumn->created_at)->format('Y'))
                    <div class="card" style="max-width:14rem;">
                      @if($autumn->stage1->post_img != NULL)
                        <img src="{{ asset('storage/'.$autumn->stage1->post_img) }}" class="card-img-top mx-auto d-block" style="width:100%; height:130px; object-fit:cover;" alt="...">
                      @endif
                      <div class="card-body">
                        <small>{{ $autumn->category->name }}</small>
                        <h6 title="{{$autumn->stage1->title}}">{{ \Illuminate\Support\Str::limit($autumn->stage1->title, 23) }}</h6>
                        @if($autumn->contributor != NULL)
                          <img src="{{ asset('data/asset/person.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          <small class="text-muted" title="{{ $autumn->user->name }} ({{ $autumn->user->unit->name }}), {{ $autumn->contributor }}">{{ \Illuminate\Support\Str::limit($autumn->user->name, 8) }} ({{ $autumn->user->unit->name }}), {{ \Illuminate\Support\Str::limit($autumn->contributor, 8) }}</small>
                        @else
                          @if($autumn->user->profile_img == NULL)
                            <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @else
                            <img src="{{ asset('storage/'.$autumn->user->profile_img) }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @endif
                          <small class="text-muted" title="{{ $autumn->user->name }} ({{ $autumn->user->unit->name }})">{{ \Illuminate\Support\Str::limit($autumn->user->name, 20) }} ({{ $autumn->user->unit->name }})</small>
                        @endif
                        <p class="card-text pt-3">{{ \Illuminate\Support\Str::limit($autumn->stage1->description, 89) }}</p>
                        <p>
                          <small style="color:#0275d8;" title="@if($autumn->likes->count() > 1)Likes @else Like @endif"><i class="fa fa-thumbs-o-up"></i> {{ $autumn->likes->count() }}</small>
                          &nbsp;
                          <small style="color:gray;" title="@if($autumn->comments->count() > 1)Comments @else Comment @endif"><i class="fa fa-commenting"></i> {{ $autumn->comments->count() }}</small>
                          <a href="{{ route('post', $autumn->id) }}" class="card-link float-right">Read more</a>
                        </p>
                      </div>
                    </div>
                  @endif
                @empty
                  <h1 class="text-center mx-auto" style="padding-top:175px; padding-bottom:176px;">No post yet</h1>
                @endforelse
              </div>
            </div>
            <div class="item carousel-item @if(\Carbon\Carbon::now()->format('n') == 12 || \Carbon\Carbon::now()->format('n') == 1 || \Carbon\Carbon::now()->format('n') == 2) active @endif">
              <h1 class="display-4 text-center">
                <span><img src="/data/asset/snow.png" width="30px"> </span>Winter
              </h1>
              <div class="card-deck justify-content-center">
                @forelse($winters as $winter)
                  @if($thisyear == \Carbon\Carbon::parse($winter->created_at)->format('Y'))
                    <div class="card" style="max-width:14rem;">
                      @if($winter->stage1->post_img != NULL)
                        <img src="{{ asset('storage/'.$winter->stage1->post_img) }}" class="card-img-top mx-auto d-block" style="width:100%; height:130px; object-fit:cover;" alt="...">
                      @endif
                      <div class="card-body">
                        <small>{{ $winter->category->name }}</small>
                        <h6 title="{{$winter->stage1->title}}">{{ \Illuminate\Support\Str::limit($winter->stage1->title, 23) }}</h6>
                        @if($winter->contributor != NULL)
                          <img src="{{ asset('data/asset/person.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          <small class="text-muted" title="{{ $winter->user->name }} ({{ $winter->user->unit->name }}), {{ $winter->contributor }}">{{ \Illuminate\Support\Str::limit($winter->user->name, 8) }} ({{ $winter->user->unit->name }}), {{ \Illuminate\Support\Str::limit($winter->contributor, 8) }}</small>
                        @else
                          @if($winter->user->profile_img == NULL)
                            <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @else
                            <img src="{{ asset('storage/'.$winter->user->profile_img) }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                          @endif
                          <small class="text-muted" title="{{ $winter->user->name }} ({{ $winter->user->unit->name }})">{{ \Illuminate\Support\Str::limit($winter->user->name, 20) }} ({{ $winter->user->unit->name }})</small>
                        @endif
                        <p class="card-text pt-3">{{ \Illuminate\Support\Str::limit($winter->stage1->description, 89) }}</p>
                        <p>
                          <small style="color:#0275d8;" title="@if($winter->likes->count() > 1)Likes @else Like @endif"><i class="fa fa-thumbs-o-up"></i> {{ $winter->likes->count() }}</small>
                          &nbsp;
                          <small style="color:gray;" title="@if($winter->comments->count() > 1)Comments @else Comment @endif"><i class="fa fa-commenting"></i> {{ $winter->comments->count() }}</small>
                          <a href="{{ route('post', $winter->id) }}" class="card-link float-right">Read more</a>
                        </p>
                      </div>
                    </div>
                  @endif
                @empty
                  <h1 class="text-center mx-auto" style="padding-top:175px; padding-bottom:176px;">No post yet</h1>
                @endforelse
              </div>
            </div>
          </div>
          <a class="carousel-control left carousel-control-prev" href="#SeasonCarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="carousel-control right carousel-control-next" href="#SeasonCarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Carousel -->
<!-- Video + Agenda -->
<section class="video-agenda">
  <div class="container">
    <div class="row">
      <div class="col-lg">
        <div class="section-title">
          <h1 class="display-4 text-center">Featured Video</h1>
        </div>
        <div class="card shadow mb-3" style="border-radius:0%;">
        @forelse($uploads as $upload)
          <div class="card border-0 thumbnail-card mx-3 mt-3" style="border-radius:0%;">
            <a href="{{ route('video', $upload->id) }}" style="text-decoration:none; color:black;">
              <div class="row no-gutters">
                <div class="col-md">
                  <div class="thumbnail">
                    <img src="{{ asset('data/knowledge system/'.$upload->thumbnail) }}" class="card-img" style="border-radius:0%;" alt="">
                    <div class="overlay">     
                      <i class="fa fa-play"></i>           
                    </div>
                  </div>
                </div>
                <div class="col-md">
                  <div class="card-body">
                    <h5 class="card-title mb-0" title="{{ $upload->title }}">{{ \Illuminate\Support\Str::limit($upload->title, 55) }}</h5>
                    <p class="text-muted">
                      @if($upload->user->profile_img == NULL)
                        <img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                      @else
                        <img src="{{ asset('storage/'.$upload->user->profile_img) }}" class="rounded-circle" style="width:20px; height:20px; object-fit:cover;" alt="">
                      @endif
                      <span class="text-muted" title="{{ $upload->user->name }}">{{ \Illuminate\Support\Str::limit($upload->user->name, 23) }}</span>
                      · 
                      <small>{{ \Carbon\Carbon::parse($upload->created_at)->format('M j, Y') }}</small>
                    </p>
                    <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($upload->description, 67) }}</p>
                  </div>
                </div>
              </div>     
            </a>
          </div>
        @empty
          <div class="card-body">
            <p class="lead text-center py-5">No upload yet</p>
          </div>
        @endforelse
        <a href="{{ route('knowledgesystem') }}" class="text-center my-3">Show more</a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="section-title">
          <h1 class="display-4 text-center">Agenda</h1>
        </div>
        <div class="card shadow" style="border-radius:0%;">
          <div class="card-body pb-3">
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.min.css' />
            <div id='calendar'></div>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.min.js'></script>
            <script>
              $(document).ready(function() {
                $('#calendar').fullCalendar({
                  eventLimit: 2,
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
                  }
                });
              });
            </script>
            @auth
              @if(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Master')
                <a href="{{ route('event') }}" class="btn btn-primary rounded-circle mt-2 float-right"><i class="fa fa-plus" style="color: white;"></i></a>
              @endif
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Video + Agenda -->
@endsection