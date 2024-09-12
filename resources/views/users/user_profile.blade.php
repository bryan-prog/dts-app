<style>
    @media only screen and (max-width: 515px){
        .btn {
            width:100%;
            margin:0 !important;
        }
        button#edit_button {
            margin-bottom: 5px !important;
        }
    }

</style>
@extends('layouts.masterlayout')

@section('content')
<div class="header pb-2" style="background-color: #16213E">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">My profile</h6>
                    <!-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                          <li class="breadcrumb-item"><a type="button" >Edit user details</a></li>
                          <li class="breadcrumb-item"><a type="button" >Change password</a></li>
                        </ol>
                    </nav> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mx-5 mt-3" style="display:flex; justify-content:center;">
    <button id="edit_button" class="btn btn-danger">Edit User Details</button>
    <button id="change_pass_btn" class="btn btn-default">Change Password</button>
</div>


<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="edit_save" enctype="multipart/form-data" id="user_info_form">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">First Name</label>

                            <div class="col">
                                <input id="name" type="text" class="form-control" name="name" style="color:black" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-end">Middle Name</label>

                            <div class="col">
                                <input id="middle_name" type="text" class="form-control" name="middle_name" style="color:black" value="{{Auth::user()->middle_name}}" readonly>

                                @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>

                            <div class="col">
                                <input id="last_name" type="text" class="form-control" name="last_name" style="color:black" value="{{Auth::user()->last_name}}" readonly>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="suffix" class="col-md-4 col-form-label text-md-end">Suffix</label>

                            <div class="col">
                                <input id="suffix" type="text" class="form-control" name="suffix" style="color:black" value="{{Auth::user()->suffix}}" readonly>

                                @error('suffix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="designation" class="col-md-4 col-form-label text-md-end">Contact No.</label>

                            <div class="col">
                                <input id="contact" type="text" class="form-control" name="contact" style="color:black" value="{{Auth::user()->contact}}" readonly>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="designation" class="col-md-4 col-form-label text-md-end"></label>

                            <div class="col">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <button type="submit" class="btn btn-primary" id="user_info_save" disabled>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr style="margin-bottom:10; margin-top:10;">
                <div class="card-body">
                    <form method="POST" action="change_pass_save" id="change_pass_form">
                        @csrf
                        <div class="row mb-3">
                            <label for="change_pass" class="col-md-4 col-form-label text-md-end">Change Password</label>

                            <div class="col">
                                <input id="change_pass" type="password" class="form-control" name="change_pass" style="color:black" readonly>

                                @error('change_pass')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <button class="btn btn-primary" type="submit" id="change" disabled>Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    
$(document).ready(function(){
    $('#edit_button').on('click', function(){
        $('#user_info_form input').prop('readonly', false);
        $('#user_info_save').prop('disabled', false);
    });

    $('#change_pass_btn').on('click', function(){
        $('#change_pass_form input').prop('readonly', false);
        $('#change').prop('disabled', false);
    });

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
    });
});

</script>

@endsection
