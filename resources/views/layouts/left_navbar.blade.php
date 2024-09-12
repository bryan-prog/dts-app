<style>
  nav#sidenav-main {
    background-color: #dddddd  !important;
    border-right: 1px solid red;
    border-style: outset;
}
a.nav-link {
  color:black !important;
}
.navbar-vertical .navbar-nav .nav-link > i {
    font-size: 1.3rem;
    line-height: 2rem;
    min-width: 2rem;
}
.text-pink {
    color: #b34e64 !important;
}
.dropdown-divider {
    border-top: 1px solid #9d9d9d;
}
@media only screen and (max-width:414px){
  img.navbar-brand-img.burger {
    display: block !important;
  }
}
</style>
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" href="{{ url('/home') }}" style="display:flex;">
        <img src="{{asset('assets/img/brand/DTS.png')}}"class="navbar-brand-img" alt="..." style="max-height:3rem;">
        <img src="{{asset('assets/img/brand/menu.png')}}"class="navbar-brand-img burger" alt="..." style="display:none; max-height: 2rem; margin-left: 15px; margin-top: 12px;" data-action="sidenav-unpin" data-target="#sidenav-main">
      </a>
      <div class="ml-auto">
        <!-- Sidenav toggler -->
        <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/home') }}">
                <i class="ni ni-archive-2 text-blue"></i>
              <span class="nav-link-text">Dashboard</span>
              </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#documents_item" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="documents_item">
              <i class="fa fa-folder text-green"></i>
              <span class="nav-link-text">Documents</span>
            </a>
            <div class="collapse" id="documents_item" style="">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ url('/my_documents') }}" class="nav-link">
                    <span class="nav-link-text">My Documents</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{  url('/received') }}" class="nav-link">
                    <span class="nav-link-text">Received Documents</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/returned_documents') }}" class="nav-link">
                    <span class="nav-link-text">Returned Documents</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{  url('/pending') }}">
              <i class="ni ni-calendar-grid-58 text-red"></i>
              <span class="nav-link-text">Pending for Release</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{  url('/incoming') }}">
              <i class="ni ni-single-copy-04 text-pink"></i>
              <span class="nav-link-text">Incoming Documents</span>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="{{  url('/received') }}">
              <i class="ni ni-ungroup text-orange"></i>
              <span class="nav-link-text">Received</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="{{  url('/terminal') }}">
              <i class="fa fa-calendar-check text-orange"></i>
              <span class="nav-link-text">Tagged as Terminal</span>
            </a>
          </li>
          @if(Auth::user()->user_level == 'Super Admin')
            <li class="nav-item">
              <a class="nav-link" href="#navbar-user" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-user">
                <i class="fa fa-user-plus text-purple"></i>
                <span class="nav-link-text">List / Register User</span>
              </a>
              <div class="collapse" id="navbar-user" style="">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{url('/users')}}" class="nav-link">
                      <span class="nav-link-text">List of Users</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/register')}}" class="nav-link">
                      <span class="nav-link-text">Register User</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li> 

          @endif
          
          @if(Auth::user()->user_level == 'Super Admin')
            <!-- <li class="nav-item">
              <a class="nav-link" href="{{  url('/Qr') }}">
                <i class="fa fa-qrcode text-orange"></i>
                <span class="nav-link-text">Generate QR</span>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="#qr_manager" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="qr_manager">
                <i class="fa fa-qrcode text-orange"></i>
                <span class="nav-link-text">QR Manager</span>
              </a>
              <div class="collapse" id="qr_manager" style="">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{  url('/assign_qr') }}" class="nav-link">
                      <span class="nav-link-text">Assign QR</span>
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a href="{{  url('/Qr') }}" class="nav-link">
                      <span class="nav-link-text">Generate QR</span>
                    </a>
                  </li> -->
                </ul>
              </div>
            </li>
          @endif

          

          <div class="dropdown-divider"></div>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-user-circle text-brown"></i>
                <span class="nav-link-text">{{ __('Logout') }}</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
            </a>
          </li>
          
        </ul>
      </div>
    </div>
  </div>
</nav>