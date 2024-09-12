<style>
    table#datatable_pending {
    color: black;
    }
    .form-control {
        color:black !important;
    }
</style>
@extends('layouts.masterlayout')
@section('content')
<div class="header pb-6" style="background-color: #16213E">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Releasing of Documents</h6>
                </div>
                <div id="result">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>{{ session()->get('message') }}</strong></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                    @elseif(session()->has('danger'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>{{ session()->get('danger') }}</strong></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                
            </div>  
            <div id="hey">
                <select class="form-control" data-toggle="select" data-placeholder="Select multiple options" id="released_to_office" name="released_to_office[]">
                    @foreach($office as $receiving_office)
                    <option value="{{$receiving_office->dept_code}}">{{$receiving_office->dept_description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

$(document).ready(function() {
    
    
       
});



</script>


@endsection