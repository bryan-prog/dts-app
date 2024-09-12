<style>
    table#datatable_received {
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
          			<h6 class="h2 text-white d-inline-block mb-0">Approved Documents</h6>
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
            	<div class="table-responsive py-4">
              		<table class="table table-flush" id="datatable_approved">
                		<thead class="thead-light">
                  			<tr>
                                <th>Tracking No.</th>
			                    <th>Document Title</th>
			                    <th>Document Subject</th>
			                    <th>Originating Office</th>
                                <th>Received By</th>
			                    <th>Received Date</th>
                  			</tr>
                		</thead>
                		<tbody>
							
                		</tbody>
              		</table>
            	</div>
     	 	</div>
        </div>
  	</div>

<!--Modal View-->
<button type="button" class="btn btn-default" id="viewDocBtn" style="float:right;">View Document</button>

<!--MODAL VIEW DOCUMENT-->
<div class="modal fade" id="modal-view-document" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-view-doc-title"></h6>
                    <button type="button" class="close close_button" data-dismiss="modal" aria-label="Close">
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
                    <label class="form-control-label" for="doc_remarks" id="from_office">Remarks</label>
                    <textarea class="form-control" id="doc_remarks" name="doc_remarks" rows="3" style="resize:none;" style="color:black;" readonly></textarea>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="doc_receiving_remarks" id="receiving_office">Remarks</label>
                    <textarea class="form-control" id="doc_receiving_remarks" name="doc_receiving_remarks" rows="3" style="resize:none;" style="color:black;" readonly></textarea>
                </div>
                    <div class="form-group">
                        <label class="form-control-label" for="mayors_remarks">Mayor's Remarks</label>
                        <textarea class="form-control" id="mayors_remarks" name="mayors_remarks" rows="3" style="resize:none;" style="color:black;" readonly></textarea>
                    </div>
                <div class="form-group">
                    <label class="form-control-label">Attached Files:</label>
                    <ul id="listof_files">
                        
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link ml-auto close_button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 

<script type="application/javascript">
$(function() {
    
    $('#datatable_approved').dataTable({
        ajax: '{{ url('mayors_approved_list') }}',
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
            { data: 'originating_office', name: 'originating_office' },
            { data: 'received_by', name: 'received_by' },
            { data: 'received_date', name: 'received_date' },
            
        ],
        pagingType: "full_numbers",
    });

       
    $('#viewDocBtn').on('click', function(){
        var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        var dts_id;
        var office;
        if(check == null)
        {
            alert("Please select document to view");
        }
        else
        {
            $.get("{{url('/doc_view')}}/" + selectedId, function(data){
                console.log(data);
                $('#modal-view-doc-title').html(data.tracking_number);
                $('#doc_title').val(data.doc_title);
                $('#doc_type').val(data.doc_type);
                $('#doc_subject').val(data.doc_subject);
                $('#doc_origin').val(data.originating_office);
                $('#from_office').html(data.originating_office + " Remarks");
                $('#receiving_office').html(data.receiving_office + " Remarks");
                $('#doc_remarks').val(data.remarks);
                $('#doc_receiving_remarks').val(data.received_remarks);
                $('#letter_id').val(data.dts_id);
                $('#mayors_remarks').val(data.mayors_remarks);
                office = data.originating_office;
                $.get("{{url('/attached_files')}}/" + data.dts_id, function(data){
                    $.each(data, function(i, item){
                        console.log(office);
                        $('#listof_files').append("<li><a href='{{url('/')}}/files/"+item.from_office+"/"+item.filename+"'>"+item.filename+"</a></li>");
                    });
                });
            });
            
            $('#modal-view-document').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
    });

    $('.close_button').on('click', function(){
        $("#listof_files").empty();
        console.log('MODAL WAS CLOSED');
    });
});
</script>
 
@endsection
