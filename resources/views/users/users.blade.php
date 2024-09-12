<style>
    @media only screen and (max-width: 767px){
        .btn-edit-user {
            display:inline !important;
            margin-left: 1.5rem;
        }
    }
    @media only screen and (max-width: 375px){
        .btn-edit-user {
            display:inline !important;
            margin-left: 10.5rem;
            width:7rem;
        }
    }
    @media only screen and (max-width: 515px){
        .btn-edit-user {
            display:inline !important;
            margin-left: auto;
            width:7rem;
        }
    }
    @media only screen and (max-width: 414px){
        .btn-edit-user {
            display:inline !important;
            margin-left: 13rem;
            width:9rem;
            margin-right:0;
        }
    }
</style>
@extends('layouts.masterlayout')

@section('content')
<div class="header pb-6" style="background-color: #16213E">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">List of Users</h6>
                    <button type="button" class="btn-edit-user btn btn-primary" id="edit_button_collapse" style="display:none;">Edit User</button>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                          <li class="breadcrumb-item"><a href="{{url('/register')}}">Register New User</a></li>
                          <li class="breadcrumb-item"><a type="button" id="edit_button">Edit user details</a></li>
                        </ol>
                    </nav>
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
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="documents_list">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Assigned Office</th>
                                <th>Designation</th>
                                <th>Username</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--EDIT USER MODAL-->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Edit User Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <form id="frmcreateRelease" method="POST" action="edit_user" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" readonly>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                        <div class="col">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" style="color:black" required autocomplete="name" autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>

                        <div class="col">
                            <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" style="color:black" autocomplete="middle_name" autofocus>

                            @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                        <div class="col">
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" style="color:black" required autocomplete="last_name" autofocus>

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="suffix" class="col-md-4 col-form-label text-md-end">{{ __('Suffix') }}</label>

                        <div class="col">
                            <input id="suffix" type="text" class="form-control @error('suffix') is-invalid @enderror" name="suffix" value="{{ old('suffix') }}" style="color:black"autocomplete="suffix" autofocus>

                            @error('suffix')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="office_dept" class="col-md-4 col-form-label text-md-end">{{ __('Assigned Office/Department') }}</label>

                        <div class="col">
                            <select class="form-control @error('office_dept') is-invalid @enderror" id="office_dept" name="office_dept" value="{{ old('office_dept') }}" style="color:black"autocomplete="office_dept" required autofocus>
                                <option>----</option>
                                @foreach($departments as $departments)
                                    <option value="{{$departments->dept_code}}">{{$departments->dept_description}}</option>
                                @endforeach
                            </select>

                            @error('office_dept')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="designation" class="col-md-4 col-form-label text-md-end">{{ __('Designation') }}</label>

                        <div class="col">
                            <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" style="color:black" value="{{ old('designation') }}" required autocomplete="designation" autofocus>

                            @error('designation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                            <label for="designation" class="col-md-4 col-form-label text-md-end">{{ __('Contact No.') }}</label>

                            <div class="col">
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" style="color:black" value="{{ old('contact') }}"placeholder="Your contact"  required autocomplete="contact" autofocus>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    <div class="row mb-3">
                        <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                        <div class="col">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" style="color:black" value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="user_level" class="col-md-4 col-form-label text-md-end">{{ __('User Level') }}</label>

                        <div class="col">
                            <select class="form-control @error('user_level') is-invalid @enderror" id="user_level" name="user_level" style="color:black" value="{{ old('user_level') }}" autocomplete="user_level" required autofocus>
                                <option>----</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>

                            @error('user_level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="user_status" class="col-md-4 col-form-label text-md-end">{{ __('User Status') }}</label>

                        <div class="col">
                            <select class="form-control @error('user_status') is-invalid @enderror" id="user_status" name="user_status" style="color:black" value="{{ old('user_status') }}" autocomplete="user_status" required autofocus>
                                <option>----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            @error('user_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="change_pass" class="col-md-4 col-form-label text-md-end">{{ __('Change Password') }}</label>

                        <div class="col">
                            <input id="change_pass" type="password" class="form-control @error('change_pass') is-invalid @enderror" name="change_pass" style="color:black" autocomplete="change_pass" autofocus>

                            @error('change_pass')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col">
                            <button class="btn btn-primary" type="submit" id="change">Change</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                    <button type="submit" id="edit_detail" class="btn btn-primary">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>



<script type="application/javascript">
    
$(document).ready(function(){

$('#documents_list').dataTable({
    ajax: '{{ url('list_of_users') }}',
    select: true,
    "lengthChange": false,
    language: {
                paginate: {
                    next: '>', 
                    previous: '<',
                    first: '<<',
                    last: '>>'
                }
            },
    pageLength: 10,
    "order": [[ 0, "asc" ]],
    columns: 
        [
            {data: 'id', name: 'id'},
            { 
                data: null,
                render: function(data, type, full, meta)
                {
                    if(full["middle_name"] != null)
                    {
                        if(full["suffix"] != null)
                        {
                            return  full["name"] + " " + full["middle_name"] + " " + full["last_name"] + " " + full["suffix"];
                        }
                        else
                        {
                            return  full["name"] + " " + full["middle_name"] + " " + full["last_name"];
                        }
                    }
                    else
                    {
                        return  full["name"] + " " + full["last_name"];
                    }
                              
                        
                } 
            },
            {data: 'office_dept', name: 'office_dept'},
            {data: 'designation', name: 'designation'},
            {data: 'username', name: 'username'},
            { 
                data: null,
                render: function(data, type, full, meta)
                {
                    if(full["active"] == 1)
                    {
                        return "Active";
                    }
                    else
                    {
                        return  "Inactive";
                    }
                } 
            },
            

        ],
});

var table = $('#documents_list').DataTable();
var data;
$('#documents_list tbody').on('click', 'tr', function(){
    $(this).addClass('selected').siblings().removeClass("selected");
    data = table.row(this).data();
})

$('#edit_button').on('click', function(){
    var check = $('.selected').attr('id');
    var selectedId = $('.selected').attr('id');
    if(check == null)
    {
        alert("Please select user to edit");
    }
    else
    {
        $('#user_id').val(data.id);
        $('#name').val(data.name);
        $('#middle_name').val(data.middle_name);
        $('#last_name').val(data.last_name);
        $('#suffix').val(data.suffix);
        $('#office_dept').val(data.office_dept);
        $('#designation').val(data.designation);
        $('#username').val(data.username);
        $('#user_level').val(data.user_level);
        $('#user_status').val(data.active);
        $('#contact').val(data.contact);
        $('#edit_modal').modal({
            backdrop: 'static',
            keyboard: true
        });
    }
});

$('#edit_button_collapse').on('click', function(){
    var check = $('.selected').attr('id');
    var selectedId = $('.selected').attr('id');
    if(check == null)
    {
        alert("Please select user to edit");
    }
    else
    {
        $('#user_id').val(data.id);
        $('#name').val(data.name);
        $('#middle_name').val(data.middle_name);
        $('#last_name').val(data.last_name);
        $('#suffix').val(data.suffix);
        $('#office_dept').val(data.office_dept);
        $('#designation').val(data.designation);
        $('#username').val(data.username);
        $('#user_level').val(data.user_level);
        $('#user_status').val(data.active);
        $('#edit_modal').modal({
            backdrop: 'static',
            keyboard: true
        });
    }
});

$('.modal').on('hidden.bs.modal', function(){
    $(this).find('form').trigger('reset');
});

$('.btn-primary').on('click', function(){
    var btnID = $(this).attr('id');
    if(btnID == 'change')
    {
        $('#frmcreateRelease').prop('action', 'change_password');
        $('#name').prop('required', false);
        $('#middle_name').prop('required', false);
        $('#last_name').prop('required', false);
        $('#suffix').prop('required', false);
        $('#office_dept').prop('required', false);
        $('#designation').prop('required', false);
        $('#username').prop('required', false);
        $('#user_level').prop('required', false);
        $('#user_status').prop('required', false);
        $('#contact').prop('required', false);
    }
    else
    {
        $('#frmcreateRelease').prop('action', 'edit_user');
    }
});

$('form').on('submit', function(){
    $(this).find('button').prop('disabled', true);
});

});

</script>

@endsection
