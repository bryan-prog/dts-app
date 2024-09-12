<style>
  @media screen and (max-width: 767px ){
    .navbar-expand .navbar-collapse {
      flex-direction: row-reverse;
    }
    .sidenav-toggler.sidenav-toggler-dark{
      padding-right: 34rem !important;
    }
  }
  @media screen and (max-width:575px){
    .navbar-expand .navbar-collapse {
      flex-direction: row-reverse;
    }
    .sidenav-toggler.sidenav-toggler-dark{
      padding-right: 18rem !important;
    }
    .secondary-logo{
      display:none !important;
    }
  }
  @media screen and (max-width:414px){
    .navbar-expand .navbar-collapse {
      flex-direction: row-reverse;
    }
    .sidenav-toggler.sidenav-toggler-dark{
      padding-right: 11rem !important;
    }
    img.rounded-circle,img.secondary-logo {
      width: 40px !important;
    }
    .npc{
      padding: 0 !important;
    }
    .secondary-logo{
      display:block !important;
    }
  }
  @media screen and (max-width:460px){
    .npc{
      display:none;
    }
    img.rounded-circle.mayor {
      display: none;
    }
  }
  button.npc:focus{
    outline:none;
  }
  .modal-header.npc {
    padding: 10px !important;
  }

</style>
<nav class="navbar navbar-top navbar-expand navbar-dark bg-dark border-bottom">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <img class="secondary-logo" src="{{asset('/assets/img/logo-nav/lbp.png')}}" style="width: 65px;">
      <img src="{{asset('/assets/img/logo-nav/sjc.png')}}" class="rounded-circle" style="width: 65px;">
      <img src="{{asset('/assets/img/logo-nav/mayor.png')}}" class="rounded-circle mayor" style="width: 60px;">
      <button class="npc" data-toggle="modal" data-target="#exampleModal" style="background:transparent;border:none;"><img src="{{asset('/assets/img/logo-nav/npc-2.png')}}" class="rounded-circle" style="width: 60px; border: 2px solid black;"></button>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center ml-md-auto">
        <li class="nav-item d-xl-none">
          <!-- Sidenav toggler -->
          <div class=" sidenav-toggler sidenav-toggler-dark" style="padding-right:3rem;" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </li>

      <ul class="navbar-nav align-items-center ml-auto ml-md-0">
        <li class="nav-item dropdown">
          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <div class="media-body ml-2 d-none d-lg-block">
                <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="{{url('edit_profile')}}" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{-- {{ __('Logout') }} --}}
                <i class="fa fa-user-circle"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

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