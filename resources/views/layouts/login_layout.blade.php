 <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
   

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DTS</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   
</head>
 <style>
body {
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    width: 100%;
    /*background-image: url("images/background2.jpg");*/
}
</style>
<body>
    <div id="app" >
        <nav class="navbar navbar-default navbar-static-top" style=" height: 80px; max-width: 100%;" >
            <img src="/dts-cgsj/public/images/sjc.png"  width="65" height="65" align="left" style="margin-left: 10px;" />
            <a class=" navbar-brand">
                <font color="white" style="font-weight: bold; font-size: 20px;">Document Tracking System</font> 
            </a>
            <div class="container"  >
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
</body>
</html>