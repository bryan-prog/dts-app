<style>
    /* MEDIA */
    @media screen and (max-width: 767px) {
        .row.dashboard1{
            flex-direction:column !important;
        }
        .dash {
            max-width: 100% !important;
        }
    }
    @media (min-width: 1200px){
        .container {
            max-width: 1475px !important;
        }
        .modal-dialog.modal-lg.modal-dialog-centered.modal- {
            width: 100% !important;
        }
    }
    @media screen and (max-width:574px){
        .modal-dialog.modal-lg.modal-dialog-centered.modal- {
            width: 100% !important;
        }
    }
    
    /* CARD STYLE */
    .card.card-stats {
        /* transform: scale(1.05); */
        border-radius: 4px;
        box-shadow: rgba(29, 5, 5, 0.295) -5px 5px, rgba(29, 5, 5, 0.295) -10px 10px;
    }
    .card.card-stats:hover {
        transform: scale(1.05);
        box-shadow: rgba(255, 0, 0, 0.295) -5px 5px, rgba(255, 0, 0, 0.329) -10px 10px;
    }
    body{
        background-color:#e7e7e7 !important;
    }
    span.mb-0.text-sm.font-weight-bold {
    color: white;
    }
</style>
@extends('layouts.masterlayout')

@section('content')

<div class="container" style="padding-top: 20px; width:95%;">
<!--CARD STATS-->

<div class="row dashboard1">
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Released</h5>
                        <span class="h2 font-weight-bold mb-0">{{$released}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                            <i class="fa fa-folder"></i>
                        </div>
                    </div>
                </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                        <span class="text-nowrap">Last Updated</span>
                    </p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">For Release</h5>
                        <span class="h2 font-weight-bold mb-0">{{$pending}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                            <i class="fa fa-upload"></i>
                        </div>
                    </div>
                </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                        <span class="text-nowrap">Last Updated</span>
                    </p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Incoming</h5>
                        <span class="h2 font-weight-bold mb-0">{{$incoming}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="fa fa-download"></i>
                        </div>
                    </div>
                </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                        <span class="text-nowrap">Last Updated</span>
                    </p>
            </div>
        </div>
    </div>
</div>
<div class="row dashboard1">
    <div class="col-6 col-md-4 dash" style="margin-bottom: 1rem;">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Received</h5>
                        <span class="h2 font-weight-bold mb-0">{{$received}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                            <i class="fa fa-archive"></i>
                        </div>
                    </div>
                </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                        <span class="text-nowrap">Last Updated</span>
                    </p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Terminal</h5>
                        <span class="h2 font-weight-bold mb-0">{{$terminal}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-purple text-white rounded-circle shadow">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                        <span class="text-nowrap">Last Updated</span>
                    </p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Drafts</h5>
                        <span class="h2 font-weight-bold mb-0">{{$draft}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                            <i class="fa fa-file"></i>
                        </div>
                    </div>
                </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                        <span class="text-nowrap">Last Updated</span>
                    </p>
            </div>
        </div>
    </div>
</div>

<!--ALERT MODAL FOR LOW QR COUNT-->
<div class="modal fade" id="modal_alert" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document" style="width: 25%;">
        <div class="modal-content" style="border: 1px solid;">
            <div class="modal-body">
                <div class="row" style="display:flex; justify-content:center;">
                    <img width="100" height="100" src="https://img.icons8.com/stickers/100/alarm.png" alt="alarm"/>
                </div>
                <div class="row mx-0 mt-3" style="display:flex; justify-content:center;">
                    <p style="font-weight:700; text-align:center;">The system has detected that your office currently have a <span class="text-red">low number</span> of available QR codes. Please contact ICTO to get an additional set of QR series.</p>
                </div>
                <div class="row" style="display:flex; justify-content:center;">
                    <button class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div> 

<script type="text/javascript">
$(document).ready(function(){

    var office = "{{Auth::user()->office_dept}}";
    $.get("{{url('/remaining_qr')}}/" + office, function(data){
        console.log(data);

        if(data<10)
        { 
            $('#modal_alert').modal('toggle');
        }
    });

});
</script>

@endsection
