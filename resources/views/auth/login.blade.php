<!-- =========================================================
* Argon Dashboard PRO v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro
* Copyright 2019 Creative Tim (https://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 -->
 <style>

h1.text-white {
    font-size:30px;
}
.logo{
    padding-bottom: 20px;
}
input#password, input#username {
    color:black;
}
/* .logo img{
    box-shadow: -5px 5px  rgba(0,0,0,0.6);
} */
.card.bg-secondary.border-0.mb-0 {
    border-radius: 30px;
}
.card-body.px-lg-5.py-lg-5 {
    background: linear-gradient(45deg, #b92d2d, #263689);
    border-radius: 25px;
}
h2 {
    font-size: 33px!important;
    color: white!important;
    line-height: 1.5!important;
    margin-bottom: 2rem!important;
}
@media screen and (max-width: 768px) {
    .logo img{
        width:30% !important;
    }
    h1{
        font-size:25px !important;
    }
    h2{
        font-size: 19px!important;
    }
    .pb-7, .py-7 {
        padding-bottom: 4rem !important;
    }
    .pt-7, .py-7 {
        padding-top: 4rem !important;
    }
    .logo,.npc{
        display:flex;
        justify-content:center;
    }
    button.npc {
        left:0 !important;
    }
    img.rounded-circle.npc {
        width: 90px !important;
    }
    .text-center.text-muted.mb-4 {
        margin-bottom: -28px !important;
    }
}

@media screen and (max-width: 1199px) {
    .logo img{
        width:30% !important;
    }
    .modal-lg, .modal-xl {
        max-width: 885px !important;
    }
    .logo,.npc{
        display:flex;
        justify-content:center;
    }
    button.npc {
        left:0 !important;
    }
}
@media screen and (max-width: 945px) {
    .sidenav-toggler.sidenav-toggler-dark {
        padding-right: 0 !important;
    }
    ol.breadcrumb.breadcrumb-links.breadcrumb-dark {
        width: 101%;
    }
}

button.npc {
    position: relative;
    bottom: 15px;
    left: 60px;
    border: none;
    padding: 10px;
    background: #0d135b;
    border-radius: 72px;
    box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgb(0 0 0 / 25%) 0px 32px 16px;;
}
button.npc:focus{
    outline:none;
}
.modal-header.npc {
    padding: 10px !important;
}

</style>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">

  <title>Document Tracking System</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('images/sjc.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.1.0')}}" type="text/css">
 
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('sjcicon.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

</head>

<body style="background-image: url({{asset('/assets/img/logo-nav/bg.png')}});">
    <!-- Main content -->
    <div class="main-content">
        <div class="header py-7 py-lg-5 pt-lg-6">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-6 col-md-8 px-5">
                            <div class="logo">
                            <img src="{{asset('/assets/img/logo-nav/bagong-pilipinas.png')}}" style="width: 120px;">
                            <img src="{{asset('/assets/img/logo-nav/sjc.png')}}" class="rounded-circle" style="width: 120px;">
                            <img src="{{asset('/assets/img/logo-nav/mayor.png')}}" class="rounded-circle" style="width: 120px;">
                            <img src="{{asset('assets/img/brand/icto.png')}}" class="rounded-circle" style="width: 110px;">
                            </div>
                            <h1 class="text-white" style="font-family:cursive;">Welcome!</h1>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div> --}}
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <h2>DOCUMENT TRACKING SYSTEM</h2>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    @if (session('error'))
                                        <div class="form-group mb-3">
                                            <div class="alert alert-danger col-md-12">
                                                {{ session('error') }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Username" autofocus>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-default my-4">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="npc">
            <button class="npc" data-toggle="modal" data-target="#exampleModal"><img src="{{asset('/assets/img/logo-nav/npc-2.png')}}" class="rounded-circle npc" style="width: 120px;"></button>
        </div>
    </div>

    <!-- NPC Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header npc">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{asset('/assets/img/npc.jpg')}}" style="width: 100%;">
            </div>
            </div>
        </div>
    </div>

  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
  <!-- Argon JS -->
  <script src="{{asset('assets/js/argon.js?v=1.1.0')}}"></script>

    <script type="application/javascript">
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
               $(this).remove();
           });
        }, 3000);
    </script>

</body>

</html>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>