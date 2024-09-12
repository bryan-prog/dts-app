<style>
    @media only screen and (max-width: 414px){
        .card-body.d-flex.justify-content-center {
            flex-direction: column !important;
        }
        .btn {
            margin-bottom:0.5rem;
        }
    }
    @media only screen and (max-width:560px){
        .card-body.d-flex.justify-content-center {
            flex-direction: column !important;
        }
        .btn {
            margin-bottom:0.5rem;
        }
    }
    .card-body.d-flex.justify-content-center{
    box-shadow: 5px 5px #8888;
    border-bottom-right-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    }
    table#datatable_incoming {
        color:black;
    }
</style>
@extends('layouts.masterlayout')

@section('content')
<div class="header pb-6" style="background-color: #16213E">
    <div class="container-fluid">
         <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Incoming Documents</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{url('/received')}}">Received Documents</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="btn-cards card-body d-flex justify-content-center">
                    <!-- <button class="btn btn-default" type="button">Scan QR</button> -->
                    <!--Modal View-->
                    <button type="button" class="btn btn-primary" id="viewDocBtn">View Document</button>
                    
                    <!--Modal Return-->
                    <button type="button" class="btn btn-default" id="return_button">Return Document</button>
                    <div class="modal fade" id="modal-return" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="modal-title-default">Returning of Documents</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                </div>
                                <form id="frmcreateReturn" name="frmcreateReturn" method="POST" action="return_document">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="returned_dtsid" name="returned_dtsid">
                                        <div class="form-group">
                                            <input type ="text" class="form-control" id="returned_tracking_number" name="returned_tracking_number" placeholder="Tracking Number" readonly>
                                        </div>
                                        <div class="col-xs-6 form-group">
                                            <label for="returned_date">Returned Date</label>
                                            <input type="date" class="form-control format" id="returned_date" name="returned_date" min="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d', time()); echo $date; ?>" max="3000-12-31" value="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d', time()); echo $date; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="OfficeDept">Returning Office</label>
                                            <input type ="text" class="form-control" id="returned_by_office" name="returned_by_office" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="returned_remarks">Remarks:</label>
                                            <textarea class="form-control" id="returned_remarks" name="returned_remarks" rows="2" style="resize:none;"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="returned" class="btn btn-primary">Return</button>
                                        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                                    </div>
                                </form>  
                            </div>
                        </div>
                    </div>     
                    <!--Modal Receive-->
                    <button type="button" class="btn btn-success" id="receive_button" >Receive Document</button>
                    <div class="modal fade" id="modal-receive" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="modal-title-default">Receiving of Documents</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                </div>
                                <form id="frmcreateReceive" name="frmcreateReceive" method="POST" action="receive_document">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="received_dtsid" name="received_dtsid">
                                        <div class="form-group">
                                            <input type ="text" class="form-control" id="received_tracking_number" name="received_tracking_number" placeholder="Tracking Number" readonly>
                                        </div>
                                        <div class="col-xs-6 form-group">
                                            <label for="received_date">Received Date</label>
                                                <input type="date" class="form-control format" id="received_date" name="received_date" min="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d', time()); echo $date; ?>" max="3000-12-31" value="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d', time()); echo $date; ?>">
                                        </div>
                                        <div class="col-xs-6 form-group">
                                            <label for="declared_urgency">Declared Urgency</label>
                                            <input type="text" class="form-control format" id="declared_urgency" name="declared_urgency" readonly>
                                        </div>
                                        @if(Auth::user()->office_dept === "MO")
                                            <div class="col-xs-6 form-group">
                                                <label for="actual_urgency">Actual Urgency</label>
                                                <select class="form-control" id="actual_urgency" name="actual_urgency" style="color:black;" required>
                                                    <option>----</option>
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low">Low</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="form-control-label" for="OfficeDept">Receiving Office</label>
                                            <input type ="text" class="form-control" id="received_by_office" name="received_by_office" placeholder="Receiving Office" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="receiving_person">Received By</label>
                                            <input type ="text" class="form-control" id="receiving_person" name="receiving_person" value="{{Auth::user()->last_name}}, {{Auth::user()->name}} {{Auth::user()->middle_name}}" readonly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="form-control-label" for="forward_to_office">Forward to Office ( if applicable )</label>
                                            <select class="form-control" id="forward_to_office" name="forward_to_office" style="color:black;" required>
                                            </select>
                                        </div> -->
                                        <div class="form-group">
                                            <label class="form-control-label" for="received_remarks">Remarks:</label>
                                            <textarea class="form-control" id="received_remarks" name="received_remarks" rows="2" style="resize:none;"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="received" class="btn btn-primary">Receive</button>
                                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                                    </div>
                                </form>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="row">
        <div class="col">
          	<div class="card">
            	<!-- Card header -->
            	<div class="table-responsive py-4">
              		<table class="table table-flush" id="datatable_incoming">
                		<thead class="thead-light">
                  			<tr>
                                <th>Tracking Number</th>
			                    <th>Document Title</th>
			                    <th>Document Subject</th>
                                <th>Urgency</th>
			                    <th>Originating Office</th>
                                <th>Date Released</th>
                                <th>QR Assigned</th>
                  			</tr>
                		</thead>
                		<tbody>
        
                		</tbody>
              		</table>
            	</div>                
     	 	</div>
        </div>
  	</div>
</div>

<!--MODAL VIEW DOCUMENT-->
<div class="modal fade" id="modal-view-document" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                    <label for="doc_urgency">Urgency</label>
                    <input type="text" class="form-control" id="doc_urgency" name="doc_urgency" readonly>
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
                    <label class="form-control-label" for="attached_list">Attached Files:</label>
                    <ul id="listof_files">
                        
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-link ml-auto" data-dismiss="modal">Close</button>
            </div> 
        </div>
    </div>
</div> 
<script src="{{asset('assets/vendor/html-barcode/html5-qrcode.min.js')}}"></script>
<script type="application/javascript">

    $(function() {
        
            $('#datatable_incoming').dataTable( {
                ajax: '{{ url('incoming_list') }}',
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
                    { data: 'doc_urgency', name: 'doc_urgency' },
                    { data: 'originating_office', name: 'originating_office' },
                    { data: 'released_date', name: 'released_date' },
                    { data: 'qr_code', name: 'qr_code' },                 
                ],
                pagingType: "full_numbers",
            } );
            var table = $('#datatable_incoming').DataTable();
            var data;

            $('#datatable_incoming tbody').on('click', 'tr', function(){
                $(this).addClass('selected').siblings().removeClass("selected");
                data = table.row(this).data();

                console.log(data.receiver_type);

                if(data.receiver_type == "CC")
                {
                    $('#return_button').prop('disabled', true);
                }
                else
                {
                    $('#return_button').prop('disabled', false);
                }
                
                if ("{{Auth::user()->office_dept}}"=="MO")
                {
                    $.get("{{url('/mayors_payroll_receive')}}/" + data.dts_id, function(data){
                        if(data == 1)
                        {
                            $('#receive_button').prop('disabled', true);
                        }
                        else
                        {
                            $('#receive_button').prop('disabled', false);
                        }
                    });
                }
                
                $('#forward_to_office').empty();

                $.get("{{url('/forward_office')}}/" + data.dts_id, function(data){
                    console.log(data);
                    
                    $('#forward_to_office').append(new Option("----", ""));
                    $.each(data, function(i, item){
                        $('#forward_to_office').append(new Option(item, item));
	                });
                });
            })

            $('#receive_button').on('click', function(){
                var check = $('.selected').attr('id');
                var selectedId = $('.selected').attr('id');
                if(check == null)
                {
                    alert("Please select document to receive");
                }
                else
                {
                    $('#received_tracking_number').val(data.tracking_number);
                    $('#received_by_office').val(data.receiving_office);
                    $('#declared_urgency').val(data.doc_urgency);
                    $('#modal-receive').modal({
                        backdrop: 'static',
                        keyboard: true
                    });
                }
            });

            $('#modal-default').on('hidden.bs.modal', function(){
                $(this).find('form').trigger('reset');
            });
            
            $('#return_button').on('click', function(){
                var check = $('.selected').attr('id');
                var selectedId = $('.selected').attr('id');
                if(check == null)
                {
                    alert("Please select document to return");
                }
                else
                {
                    $('#returned_tracking_number').val(data.tracking_number);
                    $('#returned_by_office').val(data.receiving_office);
                    $('#modal-return').modal({
                        backdrop: 'static',
                        keyboard: true
                    });
                }
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
            $.get("{{url('/doc_view')}}/" + selectedId, function(data){
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
                $('#doc_urgency').val(data.doc_urgency);
                $('#doc_origin').val(data.originating_office);
                $('#doc_remarks').val(data.remarks);
                office = data.originating_office;
            });

            $.get("{{url('/attached_files')}}/" + selectedId, function(data){
                $.each(data, function(i, item){
                	console.log(office);
	                $('#listof_files').append("<li><a href='{{url('/')}}/files/"+item.from_office+"/"+item.filename+"' target='__blank'>"+item.filename+"</a></li>");
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

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
    });
            
    });
</script>
@endsection