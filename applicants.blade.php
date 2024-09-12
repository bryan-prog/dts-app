<!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Admin - Human Resource Information System</title>
   <style>
  @import url('https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;600;700;800&display=swap');</style>
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- {{-- Favicon --}} -->
   <link href="{{asset('img/sjc.png')}}" rel="icon">
   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
   <!-- Icons -->
   <link rel="stylesheet" href="{{asset('vendor/nucleo/css/nucleo.css')}}" type="text/css">
   <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
   
   <!-- Page plugins -->
   <link rel="stylesheet" href="{{asset('vendor/quill/dist/quill.core.css')}}">
   <!-- Argon CSS -->
   <link rel="stylesheet" href="{{asset('css/argon.css')}}" type="text/css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
 </head>
 
 <body style="font-family: 'Montserrat', sans-serif;">

   <!-- Sidenav -->
   <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
     <div class="scrollbar-inner">
       <!-- Brand -->
       <div class="sidenav-header d-flex align-items-center">
         <a class="navbar-brand" href="#">
           <img src="{{asset('img/brand/web-blue.png')}}" class="navbar-brand-img w-100" alt="..." style="max-height: 4rem;">
         </a>
         <div class="ml-auto">
           <!-- Sidenav toggler -->
           <!-- <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
             <div class="sidenav-toggler-inner">
               <i class="sidenav-toggler-line"></i>
               <i class="sidenav-toggler-line"></i>
               <i class="sidenav-toggler-line"></i>
             </div>
           </div> -->
         </div>
       </div>
       <div class="navbar-inner">
         <!-- Collapse -->
         <div class="collapse navbar-collapse" id="sidenav-collapse-main">
           <!-- Nav items -->
           <h6 class="navbar-heading p-0 text-muted">Text</h6>
           <ul class="navbar-nav">
            <li class="nav-item" onclick="openCity(event, 'work_exp')">
               <a class="nav-link" href="#" >
                <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/000000/external-applicants-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                 <span class="nav-link-text text-dark">Applicants</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">
                <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/null/external-user-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                 <span class="nav-link-text text-dark">Employees</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">
                <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-group-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                 <span class="nav-link-text text-dark">Promotion</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">
                <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-teamwork-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                 <span class="nav-link-text text-dark">Demotion</span>
               </a>
            </li>
          </ul>
           <!-- Divider -->
           <hr class="my-3">

           <h6 class="navbar-heading p-0 text-muted">Text</h6>
           <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" href="#" >
                <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-hierarchy-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                 <span class="nav-link-text text-dark">Offices</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#" >
                <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-email-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                 <span class="nav-link-text text-dark">Transfer</span>
               </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">

          <h6 class="navbar-heading p-0 text-muted">APPLICATIONS</h6>
          <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="#" >
              <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-management-management-flatart-icons-lineal-color-flatarticons.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                <span class="nav-link-text text-dark">DTR</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#" >
              <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-time-management-management-flatart-icons-lineal-color-flatarticons-1.png" style="filter: brightness(185%) contrast(160%);" class="ml--2 mr-2"/>
                <span class="nav-link-text text-dark">Leave</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#" >
              <img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/50/external-briefcase-management-flatart-icons-lineal-color-flatarticons.png"  class="ml--2 mr-2"/>
                <span class="nav-link-text text-dark">Official Business</span>
              </a>
          </li>
          </ul>
     </div>
   </nav>

   <!-- Main content -->
   <div class="main-content" id="panel">
     

     <!--New Topnav -->
    <nav class="navbar navbar-horizontal navbar-expand-lg navbar-dark" style="background-color: #172b4d">
       <div class="container-fluid">
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <!-- Navbar links -->
           <ul class="navbar-nav align-items-center ml-md-auto">
             <li class="nav-item d-xl-none">
               <!-- Sidenav toggler -->
               <div class="pr-3 sidenav-toggler sidenav-toggler-light" data-action="sidenav-pin" data-target="#sidenav-main">
                 <div class="sidenav-toggler-inner">
                   <i class="sidenav-toggler-line"></i>
                   <i class="sidenav-toggler-line"></i>
                   <i class="sidenav-toggler-line"></i>
                 </div>
               </div>
             </li>
           </ul>
           <ul class="navbar-nav align-items-center ml-auto ml-md-0">
           <a class="navbar-brand" href="#"><img class="d-block  logo-margin-left"src="{{asset('img/sjc.png')}}"></a>
           <li class="nav-item dropdown">
            
                      <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-address-card"></i>
                          <span class="nav-link-inner--text">Dropdown 1<i class="fas fa-chevron-down fa-fw"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1" style="border-radius: 5px;">
                          <a class="dropdown-item" href="{{ url('/payslip') }}" style="border-radius: 5px;"><i class="icon-money"></i>PaySlip</a>
                          <a class="dropdown-item" href="#"><i class="icon-time"></i>Daily Time Record</a>
                          <a class="dropdown-item" href="#"><i class="icon-user"></i>Personal Data Sheet</a>
                          <a class="dropdown-item" href="#"><i class="icon-file-text"></i>Service Records</a>
                          <a class="dropdown-item" href="#"><i class="icon-folder-close"></i>Individual Development Plan</a>
                          <a class="dropdown-item" href="#"><i class="icon-group"></i>Individual Performance Commitment and Review (IPCR)</a>
                      </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ni ni-settings-gear-65"></i>
                        <span class="nav-link-inner--text">Dropdown 2 <i class="fas fa-chevron-down fa-fw"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1" style="border-radius: 5px;">
                        <a class="dropdown-item" href="{{ url('/leave_application') }}" style="border-radius: 5px;"><i class="icon-calendar"></i>Leave Application</a>
                        <a class="dropdown-item" href="#"><i class="icon-home"></i>Gate Pass Application</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-calendar-minus-o"></i>CTO Application</a>
                        <a class="dropdown-item" href="#"><i class="icon-file"></i>OB Application</a>
                        <a class="dropdown-item" href="#"><i class="icon-thumbs-up"></i>Application for Promotion / Change of Status</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-bicycle"></i>Bike Reservation</a>
                    </div>
                  </li>
           <li class="nav-item dropdown User">
           <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle"></i>
                            <span class="nav-link-inner--text">@if(Auth::guard('employee')->check())
                              {{ Auth::guard('employee')->user()->email }}
                            @elseif(Auth::guard('guest')->check())
                              {{ Auth::guard('guest')->user()->email }}
                            @endif</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1" style="border-radius: 5px;">
                        <a class="dropdown-item" href="#" style="border-radius: 5px;">
                            <i class="fa fa-sign-out" style="font: normal normal normal 14px/1 FontAwesome;"></i>
                            <span>Logout</span>
                        </a>
                  </div>
                  </li>
           </ul>
         </div>
       </div>
     </nav>
     <!-- Main Body Content -->
     
    @yield('content')
    <div class="container" style="max-width: 100%;">
        <div class="row">
            <div class="col-11 mt-5 container-fluid">
                <!-- <div id="PersonalInfo" class="tabcontent" style="display: block;"> -->
                <!-- <div id="work_exp" class="tabcontent">
                    <div class="section features-7" style="padding-top:0;">
                        <div class="container" style="max-width:100%;">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="row row-grid">
                                        <div class="col-md-8 mx-auto text-center">
                                            <h3 class="display-3">SAMPLE TAB 1</h3>
                                        </div>
                                    <div class="col-lg-12" style="margin-top: 0rem;">
                                        <div class="card-header" style="background-color: #127676; padding: 69px 1.5rem; margin-bottom: -12px;  padding-top: 17px;">
                                            <button type="button" class="btn btn-primary full float-right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Add ELIGIBILITY</button>
                                            <button type="button" class="btn btn-primary collapse float-right" style="display:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="card card shadow border-0">
                                            <div class="card-body" style="padding-left: 50px; padding-right: 50px;">
                                                <div class="row">
                                                    <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 165%; color: lightcoral;"></i><p style="color: red;"> &nbsp; Services rendered in City Government of San Juan need not be encoded.</p>
                                                </div>
                                                <div class="table-responsive table-bordered">
                                                    <table class="table align-items-center table-flush table-striped">
                                                        <thead class="thead-light">
                                                                <tr>
                                                                <th>Inclusive Date (From)</th>
                                                                <th>Inclusive Date (To)</th>
                                                                <th>Position Title</th>
                                                                <th>Department</th>
                                                                <th>Monthly Salary</th>
                                                                <th>Salary Grade</th>
                                                                <th>Status of Appointment</th>
                                                                <th>Government Service</th>
                                                                <th>Work Experience Sheet</th>
                                                                <th>Action</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td contenteditable="true" class="table-user">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td contenteditable="true">
                                                                    <span class="font-weight-bold"></span>
                                                                </td>
                                                                <td class="table-actions">
                                                                    <a href="#!" class="table-action mr-3" data-toggle="tooltip" data-original-title="Edit product">
                                                                        <i class="fas fa-user-edit"></i>
                                                                    </a>
                                                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete product">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->



            <!-- Footer -->
            <footer class="footer pt-0 ml-1">
            <div class="row align-items-center justify-content-lg-between ">
                <div class="col-lg-6">
                <div class="copyright text-center text-lg-left text-muted ml-1">
                    &copy; {{now()->year}} <a href="#" class="font-weight-bold ">Public Information Department | City Government of San Juan</a>
                </div>
                </div>
            </div>
            </footer>
        </div>
    </div>


   <script src="{{asset('js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/core/popper.min.js')}}" type="text/javascript"></script>
   <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{asset('js/plugins/jasny-bootstrap.min.js')}}"></script>
<!-- Plugin for Headrom, full documentation here: https://wicky.nillia.ms/headroom.js/ -->
<script src="{{asset('js/plugins/headroom.min.js')}}"></script>
   <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
<script src="{{asset('js/argon-design-system.min.js')}}" type="text/javascript"></script>
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>


   <!-- Argon Scripts -->
   <!-- Core -->
   <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
   <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
   <script src="{{asset('vendor/js-cookie/js.cookie.js')}}"></script>
   <script src="{{asset('vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
   <script src="{{asset('vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
   <!-- Optional JS -->
   <script src="{{asset('vendor/quill/dist/quill.min.js')}}"></script>
   <script src="{{asset('vendor/chart.js/dist/Chart.min.js')}}"></script>
   <script src="{{asset('vendor/chart.js/dist/Chart.extension.js')}}"></script>
   <script src="{{asset('vendor/jvectormap-next/jquery-jvectormap.min.js')}}"></script>
   <script src="{{asset('js/vendor/jvectormap/jquery-jvectormap-world-mill.js')}}"></script>
   <!-- Argon JS -->
   <script src="{{asset('js/argon.js')}}"></script>
   <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
<script type="text/javascript">

    var my_handlers = {

        fill_provinces:  function(){

            var region_code = $(this).val();
            $('#CMS_BPlace_Province').ph_locations('fetch_list', [{"region_code": region_code}]);
            var CMS_BPlace_Region = $("#CMS_BPlace_Region option:selected" ).text();
            $("#CMS_BPlace_Region_Text" ).val(CMS_BPlace_Region);

        },

        fill_cities: function(){

            var province_code = $(this).val();
            $('#CMS_BPlace_City').ph_locations( 'fetch_list', [{"province_code": province_code}]);
            var CMS_BPlace_Province = $("#CMS_BPlace_Province option:selected" ).text();
            $("#CMS_BPlace_Province_Text" ).val(CMS_BPlace_Province);

        },


        fill_barangays: function(){

            var city_code = $(this).val();
            $('#CMS_Brgy').ph_locations('fetch_list', [{"city_code": city_code}]);
            var CMS_BPlace_City = $("#CMS_BPlace_City option:selected" ).text();
            $("#CMS_BPlace_City_Text" ).val(CMS_BPlace_City);
        },

        text_barangays: function(){

            var brgy_code = $(this).val();
            var CMS_Brgy = $("#CMS_Brgy option:selected" ).text();
            $("#CMS_Brgy_Text" ).val(CMS_Brgy);
        }
    };

    $(function(){
        $('#CMS_BPlace_Region').on('change', my_handlers.fill_provinces);
        $('#CMS_BPlace_Province').on('change', my_handlers.fill_cities);
        $('#CMS_BPlace_City').on('change', my_handlers.fill_barangays);
        $('#CMS_Brgy').on('change', my_handlers.text_barangays);

        $('#CMS_BPlace_Region').ph_locations({'location_type': 'regions'});
        $('#CMS_BPlace_Province').ph_locations({'location_type': 'provinces'});
        $('#CMS_BPlace_City').ph_locations({'location_type': 'cities'});
        $('#CMS_Brgy').ph_locations({'location_type': 'barangays'});

        $('#CMS_BPlace_Region').ph_locations('fetch_list');
    });

</script>
</body>
 
</html>