<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Stylesheet CSS -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="icon" href="/data/asset/logo.png">

    <title>@yield('title')</title>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg bg-light navbar-light" id="navbar">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img src="/data/asset/Logo innovation chamber.png" height="50px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('bankofidea') }}">BANK OF IDEA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('knowledgesystem') }}">KNOWLEDGE SYSTEM</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('about') }}">ABOUT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-info mb-1" href="https://forms.office.com/Pages/DesignPage.aspx#FormId=ChlQsfMWuk-L9jpiCrdgeUN_cTVQH2ROoRgTYaJqiwNUNFk3NllHOVpHUk9KRzAxWVYyVEZFMjc3Ny4u&Token=5fae18ea85204e60b18d5b1cc99c1a69" style="color: white; border-radius: 0%;">JOIN RDCX</a>
            </li>
            @auth
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="notificationdropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <span class="badge badge-danger">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="notificationdropdown">
                  <p class="lead text-center">Notification</p>
                  <hr>
                  <div class="dropdown-item">
                    <i class="fas fa-drafting-compass"></i>
                    <p>This feature is currently under development</p>
                  </div>
                  <hr>
                  <a href="#">Mark all as read</a>
                </div>
              </li>
            @endauth
          </ul>
          <ul class="navbar-nav ml-auto">
          @guest
            <li class="nav-item">
              <a class="btn btn-primary tombol-sign" href="{{ route('login') }}" style="color: white;">Sign in / Sign up</a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              @if(auth()->user()->profile_img == NULL)
                <span><img src="{{ asset('data/asset/user.png') }}" class="rounded-circle" style="width:25px; height:25px; object-fit:cover;" alt=""> </span>
              @else
                <span><img src="{{ asset('storage/'.auth()->user()->profile_img) }}" class="rounded-circle" style="width:25px; height:25px; object-fit:cover;" alt=""> </span>
              @endif
              {{ \Illuminate\Support\Str::limit(auth()->user()->name, 15) }}
              <span class="caret"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('dashboard') }}">
                  <span><i class="fa fa-id-card-o fa-fw" style="color:black" aria-hidden="true"></i> </span>Dashboard
                </a>
                <a class="dropdown-item" href="{{ route('editprofile') }}">
                  <span><i class="fa fa-pencil-square-o fa-fw" style="color:black" aria-hidden="true"></i> </span>Edit Profile
                </a>
                <a class="dropdown-item" href="{{ route('changepassword') }}">
                  <span><i class="fa fa-key fa-fw" style="color:black" aria-hidden="true"></i> </span>Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                  <span><i class="fa fa-sign-out fa-fw" style="color:black" aria-hidden="true"></i> </span>Sign out
                </a>
              </div>
            </li>
          @endguest
          </ul>
        </div>
       </div>
     </nav>
    <!-- End Navbar -->
    @yield('content')  
    <!-- Footer -->
    <div class="footer bg-dark">
      <div class="row">
        <div class="col">
          <div class="container">
            <img src="/data/asset/GMF AeroAsia Logo White.png" class="logo" height="50px" alt="">
            <img src="/data/asset/Logo RDCX white.png" class="logo" height="50px" alt="">
            <img src="/data/asset/Logo ideIN white.png" class="logo" height="50px" alt="">
            <img src="/data/asset/Logo innovation chamber white.png" class="logo" height="50px" alt="">
          </div>
        </div>
      </div>
      <div class="row footer-copyright mt-5">
        <div class="col">
          <a href="{{ route('credits') }}" style="color:white;">Credits</a>
          <p style="color:white;">©2019 GMF Aero Asia. All Rights Reserved</p>
        </div>
      </div>
    </div>
    <!-- End Footer -->

    <!-- Optional JavaScript -->
    <script src="/js/script.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>

</html>