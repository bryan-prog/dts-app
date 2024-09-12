@extends('layouts.masterlayout')

@section('content')

<div class="header pb-6" style="background-color: #16213E">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Tag as Terminal</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
          	<div class="card">
            	<!-- Card header -->
            	<div class="table-responsive py-4">
              		<table class="table table-flush" id="datatable_terminal">
                		<thead class="thead-light">
                  			<tr>
                                <th>Tracking No.</th>
			                    <th>Document Title</th>
			                    <th>Originating Office</th>
			                    <th>Last Transaction</th>
			                    <th>Status</th>
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
    <!-- MODAL VIEW -->
      <button type="button" id="viewDocBtn" class="btn btn-default" style="float:right;">View Document</button>
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
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="document_details_tab" data-toggle="tab" href="#document_details" role="tab" aria-controls="document_details" aria-selected="true"><i class="ni ni-archive-2 mr-2"></i>Document Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="office_remarks_tab" data-toggle="tab" href="#office_remarks" role="tab" aria-controls="office_remarks" aria-selected="false"><i class="ni ni-bullet-list-67 mr-2"></i>Office Remarks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="office_remarks_tab" data-toggle="tab" href="#returned_remarks" role="tab" aria-controls="returned_remarks" aria-selected="false"><i class="ni ni-bullet-list-67 mr-2"></i>Office Returned Remarks</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="document_details" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
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
                                    <label class="form-control-label" for="attached_list">Attached Files:</label>
                                    <ul id="listof_files">
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="office_remarks" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                            </div>
                            <div class="tab-pane fade" id="returned_remarks" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div> 
        </div>
    </div>
</div> 


<script type="application/javascript">

$(function() {
    
        $('#datatable_terminal').dataTable( {
            ajax: '{{ url('terminal_list') }}',
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
                { data: 'originating_office', name: 'originating_office' },
                { data: 'latest_transaction', name: 'latest_transaction' },
                { data: 'status', name: 'status' },
                { data: 'qr_code', name: 'qr_code' }, 
            ],
            pagingType: "full_numbers",
        } );
        var table = $('#terminal.terminal').DataTable();
     
    $('#viewDocBtn').on('click', function(){
        var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        var office;
        var track_id = $('.selected').find("td").eq(0).html(); 
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

            console.log(track_id);

            $.get("{{url('/terminal_remarks_list')}}/" + track_id, function(data){
                $.each(data, function(i, item){
                    if(item.received_remarks == null)
                    {
                        var received_rems = '';
                    }
                    else
                    {
                        var received_rems = item.received_remarks;
                    }
                    $('#office_remarks').append("<label for="+item.receiving_office+"'_remarks'>"+item.receiving_office+" Remarks</label><textarea class='form-control' id="+item.receiving_office+"'_remarks' name="+item.receiving_office+"'_remarks' rows='3' style='resize:none;' style='color:black;' readonly>"+received_rems+"</textarea><br>");
                });
            });

            $.get("{{url('/terminal_returned_remarks_list')}}/" + track_id, function(data){
                $.each(data, function(i, item){
                    if(item.returned_remarks == null)
                    {
                        var returned_rems = '';
                    }
                    else
                    {
                        var returned_rems = item.returned_remarks;
                    }
                    $('#returned_remarks').append("<label for="+item.receiving_office+"'_remarks'>"+item.receiving_office+" Remarks</label><textarea class='form-control' id="+item.receiving_office+"'_remarks' name="+item.receiving_office+"'_remarks' rows='3' style='resize:none;' style='color:black;' readonly>"+returned_rems+"</textarea><br>");
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
});
</script>
@endsection