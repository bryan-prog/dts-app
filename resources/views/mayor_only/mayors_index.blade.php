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
    }
    
    /* CARD STYLE */
    .card.card-stats {
        /* transform: scale(1.05); */
        border-radius: 4px;
        box-shadow: rgba(255, 0, 0, 0.295) -5px 5px, rgba(255, 0, 0, 0.329) -10px 10px;
    }
    .card.card-stats:hover {
        transform: scale(1.05);
        box-shadow: rgb(50 53 153 / 30%) -5px 5px, rgb(0 64 255 / 33%) -10px 10px;
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
                        <h5 class="card-title text-uppercase text-muted mb-0">Highly Urgent Letters</h5>
                        <span class="h2 font-weight-bold mb-0">{{$highly_urgent_letters}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                            <i class="fa fa-folder"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Medium Urgency Letters</h5>
                        <span class="h2 font-weight-bold mb-0">{{$medium_urgent_letters}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                            <i class="fa fa-folder"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 dash">
        <div class="card card-stats">
        <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Low Urgency Letters</h5>
                        <span class="h2 font-weight-bold mb-0">{{$low_urgent_letters}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                            <i class="fa fa-folder"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row dflex justify-content-center">
    <div class="card">
        <div class="card-header">
            <h6 class="surtitle">Data Visualization</h6>
        </div>
        <div class="card-body">
            <div class="chart">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="urgencyFile" class="chart-canvas chartjs-render-monitor" width="734" height="350" style="display: block; width: 734px; height: 350px;"></canvas>
            </div>
        </div>
    </div>
</div>   

<script type="text/javascript">
$(document).ready(function(){
    // BIRTHCERT CHART
    var level = ["High", "Medium", "Low"];
    var level_count = ["{{$highly_urgent_letters}}", "{{$medium_urgent_letters}}", "{{$low_urgent_letters}}"];
    var bar_color = ["#11cdef", "#f5365c", "#172b4d"];

    const myChart = new Chart("urgencyFile", {
        type: "pie",
        data: {
            labels: level,
            datasets: [{
            backgroundColor: bar_color,
            data: level_count
            }]
        },
        options: {
            title: { display: true, text: 'URGENCY DOCUMENT LEVEL'},
        }
    });
});
</script> 
@endsection
