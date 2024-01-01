@extends('layout/main')
@section('title', 'Bank of Idea · Innovation Chamber')
@section('content')
<!-- Bank of Idea -->
<div class="container bank-of-idea">
  <div class="row mb-2">
    <div class="col-lg section-title">
      <h1 class="display-4 float-left">Bank Of Idea</h1>
    </div>
    <div class="col-lg">
      <div class="input-group justify-content-end">
        @auth
          <a href="{{ route('submit') }}" class="mr-2">
            <button class="btn btn-dark">
              <i class="fa fa-rocket" style="color: yellow;"></i>
            </button>
          </a>
        @endauth
        <div class="input-group-prepend">
          <input class="form-control" style="box-shadow: none; border-color:white;" type="text" id="boi-input" placeholder="Search">
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
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="color:black;">&times;</span>
          </button>
        </div>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-lg">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Category</th>
            <th scope="col">Title</th>
            <th scope="col">Author(s)</th>
            <th scope="col">Season</th>
          </tr>
        </thead>
        <tbody id="table">
          @forelse($posts as $post)
            <tr>
              @if($post->category_id == 1)
                <td>RX</td>
              @elseif($post->category_id == 2)
                <td>DX</td>
              @elseif($post->category_id == 3)
                <td>CX</td>
              @else
                <td>New Value</td>
              @endif
              <td><a href="{{ route('post', $post->id) }}">{{ $post->stage1->title }}</a></td>
              @if($post->contributor != NULL)
                <td>{{ $post->user->name }} ({{ $post->user->unit->name }}), {{ $post->contributor }}</td>
              @else
                <td>{{ $post->user->name }} ({{ $post->user->unit->name }})</td>
              @endif
              @if($post->season == 'Spring')
                <td><img src="/data/asset/leaf.png" width="20px"> Spring</td>
              @elseif($post->season == 'Summer')
                <td><img src="/data/asset/sunset.png" width="20px"> Summer</td>
              @elseif($post->season == 'Autumn')
                <td><img src="/data/asset/oak.png" width="20px"> Autumn</td>
              @else
                <td><img src="/data/asset/snow.png" width="20px"> Winter</td>
              @endif
            </tr>
          @empty
            <tr>
              <td></td>
              <td><p class="lead text-center py-5">No post yet</p></td>
              <td></td>
              <td></td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- End Bank of Idea -->
@endsection