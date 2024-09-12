<style>
    table#datatable_pending {
    color: black;
    }
    .form-control {
        color:black !important;
    }
    button.btn.dropdown-toggle.btn-light {
        background-color: white;
        border: 1px solid #aaa;
    }
    .filter-option-inner-inner {
        color: #696969;
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
            	<div class="table-responsive py-4">
              		<table class="table table-flush" id="datatable_pending">
                		<thead class="thead-light">
                  			<tr>
                                <th>Tracking Number</th>
			                    <th>Document Title</th>
			                    <th>Purpose</th>
                  			</tr>
                		</thead>
                		<tbody>
                  
                		</tbody>
              		</table>
            	</div>
     	 	</div>            
            <!--Modal View button-->
            <button type="button" class="btn btn-primary" id="viewDocBtn" style="margin-bottom:15px;">View Document</button>

            <!--MODAL VIEW DOCUMENT-->
            <div class="modal fade" id="modal-view-document" tabindex="-1" role="dialog" aria-labelledby="modal-view-document" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-view-doc-title"></h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="doc_title">Title</label>
                                <input type="text" class="form-control" id="doc_title" name="doc_title" readonly>
                            </div>
                            <div class="form-group">
                                <label for="doc_type">Document Type</label>
                                <input type="text" class="form-control" id="doc_type" name="doc_type" readonly>
                            </div>
                            <div class="form-group">
                                <label for="doc_subject">Document Subject</label>
                                <input type="text" class="form-control" id="doc_subject" name="doc_subject" readonly>
                            </div>
                            <div class="form-group">
                                <label for="doc_origin">Originating Office</label>
                                <input type="text" class="form-control" id="doc_origin" name="doc_origin" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="doc_remarks">Remarks</label>
                                <textarea class="form-control" id="doc_remarks" name="doc_remarks" rows="3" style="resize:none;" style="color:black;" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="listof_files">Attached Files:</label>
                                <ul id="listof_files">
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                        </div> 
                    </div>
                </div>
            </div> 

            <!--Modal Release-->
            <button type="button" class="btn btn-default" style="float:right;" id="release_button">Release Document</button>
            <div class="modal fade" id="sel_office_modal" tabindex="-1" role="dialog" aria-labelledby="sel_office_modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-default">Releasing of Documents</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                        </div>
                        <form id="frmcreateRelease" name="frmcreateRelease" method="POST" action="release_document" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="released_dtsid" name="released_dtsid">
                                <div class="form-group">
                                    <input type ="text" class="form-control" id="released_tracking_number" name="released_tracking_number" placeholder="Tracking Number" readonly>
                                </div>                                
                                <div class="col-xs-6 form-group">
                                    <label for="released_date">Release Date</label>
                                    <input type="date" class="form-control format" id="released_date" name="released_date" min="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d', time()); echo $date; ?>" value="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d', time()); echo $date; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="released_to_office">For Receiving Office (Choose all that applies) :</label>
                                    <select class="form-control selectpicker" multiple id="released_to_office" name="released_to_office[]" data-live-search="true" title="Select Office">
                                        @foreach($Offices as $receiving_office)
                                        <option value="{{$receiving_office->dept_code}}">{{$receiving_office->dept_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="cc_released_to_office">CC: Office (Choose all that applies) :</label>
                                    <select class="form-control selectpicker" multiple="multiple" id="cc_released_to_office" name="cc_released_to_office[]" data-live-search="true" title="Select Office">
                                        @foreach($CC_Offices as $cc_receiving_office)
                                        <option value="{{$cc_receiving_office->dept_code}}">{{$cc_receiving_office->dept_description}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label class="form-control-label" for="released_remarks">Remarks:</label>
                                    <textarea class="form-control" id="released_remarks" name="released_remarks" rows="2" style="resize:none;"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="next_button" class="btn btn-primary">Next</button>
                                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                            </div>
                        </form>   
                    </div>
                </div>
            </div>

            <!-- TAGGING DOCUMENT TO QR -->
            <div class="modal fade" id="tag-qr-modal" tabindex="-1" role="dialog" aria-labelledby="tag-qr-modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-default">Tag QR to Document</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-control-label" for="available_qr_list">Available QR Codes</label>
                                <select class="form-control" id="available_qr_list" name="available_qr_list" form="frmcreateRelease" required>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="release" class="btn btn-primary" form="frmcreateRelease">Release</button>
                            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
  	</div>
</div>

<script type="application/javascript">

$(document).ready(function() {
    
    $('#datatable_pending').dataTable( {
        ajax: '{{ url('pending_list') }}',
        processing: true,
        serverSide: true,
        select: true,
        "lengthChange": false,
        pageLength: 10,
        "order": [[ 0, "desc" ]],
        language: {
            paginate: {
                next: '>', 
                previous: '<',
                first: '<<',
                last: '>>'
            }
        },
        columns: 
        [
            { data: 'tracking_number', name: 'tracking_number' },
            { data: 'doc_title', name: 'doc_title' },
            { data: 'doc_subject', name: 'doc_subject' },     
        ],
        pagingType: "full_numbers",
    } );
    var table = $('#datatable_pending').DataTable();
    var data;
    $('#datatable_pending tbody').on('click', 'tr', function(){
        $(this).addClass('selected').siblings().removeClass("selected");
        data = table.row(this).data();
        console.log(data);
    })

    $('#release_button').on('click', function(){
        var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        if(check == null)
        {
            alert("Please select documents to release");
        }
        else
        {
            $('#released_tracking_number').val(data.tracking_number);
            $('#sel_office_modal').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
    });

    $(".select-tags").select2({ tags: true });

    $('#sel_floor').on('change', function(){
        var selFloor = $(this).val();
        $('#office_dept').empty();
        $.get("{{url('/floor')}}/" + selFloor, function(data){
            $.each(data, function(i, item){
                
                $('#office_dept').append($('<option>', {
                    value: item.dept_code,
                    text : item.dept_description
                }));
            });
        });
    });

    $('#viewDocBtn').on('click', function(){
        var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        var office;
        if(check == null)
        {
            alert("Please select document to view");
        }
        else
        {
            $.get("{{url('/pending_doc_view')}}/" + selectedId, function(data){
                $('#modal-view-doc-title').html(data.tracking_number);
                $('#doc_title').val(data.doc_title);
                
                var doc_type;
                if(data.doc_type == "OD")
                {
                    doc_type = "Office Document"
                }
                else if(data.doc_type == "RL")
                {
                    doc_type = "Request Letter"
                }
                else if(data.doc_type == "T")
                {
                    doc_type = "Transmittal"
                }
                else if(data.doc_type == "U")
                {
                    doc_type = "Unclassified"
                }
                else if(data.doc_type == "P")
                {
                    doc_type = "Payroll"
                }
                else
                {
                    doc_type = ""
                }

                $('#doc_type').val(doc_type);
                $('#doc_subject').val(data.doc_subject);
                $('#doc_origin').val(data.originating_office);
                $('#doc_remarks').val(data.remarks);
                office = data.originating_office;
            });

            $.get("{{url('/attached_files')}}/" + selectedId, function(data){
                $.each(data, function(i, item){
                	console.log(office);
	                $('#listof_files').append("<li><a href='{{url('/')}}/files/"+item.from_office+"/"+item.filename+"'>"+item.filename+"</a></li>");
	            });
            });
            
            $('#modal-view-document').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
    });
    $('#modal-view-document').on("hidden.bs.modal", function(){
	    $("#listof_files").empty();
	});

    $('#next_button').on('click', function(){
        $('#sel_office_modal').modal('toggle');

        $('#available_qr_list').empty();

        $.get("{{url('/available_qr')}}/" + data.originating_office, function(data){
            
            $("#available_qr_list").append(new Option("----", ""));

            //ASSIGNS THE NEXT NUMBER OF THE SERIES
            $("#available_qr_list").append(new Option(data[0], data[0]));
        });

        $('#tag-qr-modal').modal('toggle');
    });

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
        $('#release').prop('disabled', true);
    });
       
});

</script>


@endsection