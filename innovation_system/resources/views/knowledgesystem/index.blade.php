@extends('layout/main')
@section('title', 'Knowledge System · Innovation Chamber')
@section('content')
<!-- Knowledge System -->
<div class="container knowledge-system">
  <div class="row mb-2">
    <div class="col-lg section-title">
      <h1 class="display-4 float-left">Knowledge System</h1>
    </div>
    <div class="col-lg">
      <div class="input-group justify-content-end">
        @guest
        @elseif(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Master')
          <a href="{{ route('upload') }}" class="mr-2">
            <button class="btn btn-danger">
              <i class="fa fa-video"></i>
            </button>
          </a>
        @endguest
        <div class="input-group-prepend">
          <input class="form-control" style="box-shadow: none; border-color:white;" type="text" id="ks-input" placeholder="Search">
        </div>
        <div class="input-group-append">
          <div class="input-group-text" style="background-color:white; border-color:white;">
            <i class="fa fa-search"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  <div class="card shadow" style="border-radius: 0%;">
    <div class="card-body pb-0">
      <div class="row">
        @forelse($uploads as $upload)
          <div class="col-lg-4 mb-4" data-role="ks">
            <div class="card border-0 thumbnail-card" style="border-radius: 0%;">
              <a href="{{ route('video', $upload->id) }}" style="text-decoration:none; color:black;"> 
                <div class="thumbnail">
                  <img src="{{ asset('data/knowledge system/'.$upload->thumbnail) }}" class="card-img-top" style="border-radius: 0%;" alt="">
                  <div class="overlay">    
                    <i class="fa fa-play"></i>           
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-2 pr-2">
                      @if($upload->user->profile_img == NULL)
                        <span><img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;" alt=""> </span>
                      @else
                        <span><img src="{{ asset('storage/'.$upload->user->profile_img) }}" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;" alt=""> </span>
                      @endif
                    </div>
                    <div class="col-xs">
                      <h6 class="card-title mb-0" title="{{ $upload->title }}">{{ \Illuminate\Support\Str::limit($upload->title, 34) }}</h6>
                      <p class="text-muted mb-0">
                        <span class="text-muted" title="{{ $upload->user->name }}">
                          {{ \Illuminate\Support\Str::limit($upload->user->name, 24) }}
                        </span> · <small>{{ \Carbon\Carbon::parse($upload->created_at)->format('M j, Y') }}</small>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        @empty
          <div class="col-lg">
            <p class="lead text-center py-5">No upload yet</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
<!-- End Knowledge System-->
@endsection