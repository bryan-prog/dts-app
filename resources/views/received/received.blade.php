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
          			<h6 class="h2 text-white d-inline-block mb-0">Received Documents</h6>
                      <!-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{url('/incoming')}}">Incoming Documents</a></li>
                                </ol>
                      </nav> -->
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
              		<table class="table table-flush" id="datatable_received">
                		<thead class="thead-light">
                  			<tr>
                                <th>Tracking No.</th>
			                    <th>Document Title</th>
			                    <th>Document Subject</th>
			                    <th>Originating Office</th>
                                <th>Received By</th>
			                    <th>Received Date</th>
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

<!--Modal View-->
<button type="button" class="btn btn-success" id="releaseDocBtn" style="float:right;">Release Document</button>
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
                @if(Auth::user()->office_dept === 'MO' && Auth::user()->designation === 'City Mayor')
                    <div class="form-group">
                        <label class="form-control-label" for="mayors_remarks" id="receiving_office">Mayor's Remarks</label>
                        <textarea class="form-control" id="mayors_remarks" name="mayors_remarks" rows="3" style="resize:none;" style="color:black;" form="approval_form"></textarea>
                    </div>
                @elseif(Auth::user()->office_dept === 'MO' && Auth::user()->designation !== 'City Mayor')
                    <div class="form-group">
                        <label class="form-control-label" for="mayors_remarks" id="receiving_office">Mayor's Remarks</label>
                        <textarea class="form-control" id="mayors_remarks" name="mayors_remarks" rows="3" style="resize:none;" style="color:black;" readonly></textarea>
                    </div>
                @else
                @endif
                <div class="form-group">
                    <label class="form-control-label">Attached Files:</label>
                    <ul id="listof_files">
                        
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                @if(Auth::user()->designation === 'City Mayor')
                    <form method="POST" action="approval" id="approval_form">
                        @csrf
                        <input type="hidden" name="letter_id" id="letter_id" readonly>
                        <input type="hidden" name="approval_level" id="approval_level" readonly>
                        <button type="submit" class="btn btn-success response" value="Approved">Approved</button>
                        <button type="submit" class="btn btn-default response" value="For Review">For Review</button>
                        <button type="submit" class="btn btn-danger response" value="Disapproved/Rejected">Disapproved/Rejected</button>
                    </form>
                @endif
                <button type="button" class="btn btn-link ml-auto close_button" data-dismiss="modal">Close</button>
            </div> 
        </div>
    </div>
</div> 

<!--MODAL REELASE DOCUMENT-->
<div class="modal fade" id="modal-release" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Releasing of Documents</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <form id="frmcreateRelease" name="frmcreateRelease" method="POST" action="release_received_doc" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="released_dtsid" name="released_dtsid">
                    <div class="form-group">
                        <input type ="text" class="form-control" id="released_tracking_number" name="released_tracking_number" placeholder="Tracking Number" readonly>
                    </div>                                
                    <div class="col-xs-6 form-group">
                        <label for="released_date">Release Date (mm/dd/yyyy)</label>
                        <input type="date" class="form-control format" id="released_date" name="released_date">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="released_to_office">Receiving Office (Choose all that applies) :</label>
                        <select class="form-control js-example-basic-multiple" multiple="multiple" id="released_to_office" name="released_to_office[]">
                            @foreach($Offices as $receiving_office)
                            <option value="{{$receiving_office->dept_code}}">{{$receiving_office->dept_description}}</option>
                            @endforeach
                        </select>
                    </div>      
                    <!-- <div class="form-group">
                        <label class="form-control-label" for="sel_floor">Select Floor Destination</label>
                        <select class="form-control" id="sel_floor" name="sel_floor">
                            <option>----</option>
                            <option value="4th FLOOR">4th Floor</option>
                            <option value="3rd FLOOR">3rd Floor</option>
                            <option value="2nd FLOOR">2nd Floor</option>
                            <option value="1st FLOOR">Upper Ground Floor</option>
                            <option value="LG FLOOR">Lower Ground Floor</option>
                            <option value="NEO">CDRRMO Building</option>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label class="form-control-label" for="office_dept">Select Office/Deparment</label>
                        <select class="form-control multiple" multiple="multiple" id="office_dept" name="office_dept">
                            <option>----</option>
                        </select>
                    </div> -->        
                    <div class="form-group">
                        <label class="form-control-label" for="released_remarks">Remarks:</label>
                        <textarea class="form-control" id="released_remarks" name="released_remarks" rows="2" style="resize:none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="release" class="btn btn-primary">Release</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>
            </form>   
        </div>
    </div>
</div>
    
<script type="application/javascript">

$(function() {
    var ajax_url;
    if("{{Auth::user()->designation}}" === 'City Mayor')
    {
        var ajax_url = '{{ url('mayors_for_review') }}';
    }
    else
    {
        var ajax_url = '{{ url('received_list') }}';
    }
    $('#datatable_received').dataTable({
        ajax: ajax_url,
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
            { data: 'qr_code', name: 'qr_code' }, 
            
        ],
        pagingType: "full_numbers",
    });
    var table = $('#datatable_received').DataTable();

    $('#datatable_received tbody').on('click', 'tr', function () {
        console.log(table.row(this).data());
        var data = table.row(this).data();
        if (data.receiver_type == "CC") 
        {
            $('#releaseDocBtn').prop('disabled', true);
        }
        else
        {
            $('#releaseDocBtn').prop('disabled', false);
        }

    });

       
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

$('#releaseDocBtn').on('click', function(){
    var check = $('.selected').attr('id');
    var selectedId = $('.selected').attr('id');
    var dts_id;
    var office;
    if(check == null)
    {
        alert("Please select document to release");
    }
    else
    {
        $.get("{{url('/doc_view')}}/" + selectedId, function(data){
            console.log(data);
            $('#released_tracking_number').val(data.tracking_number);

        });
        $('#modal-release').modal({
            backdrop: 'static',
            keyboard: true
        });
    }
});

$('.response').on('click', function(){
    $('#approval_level').val($(this).val());
});

// $('#modal-view-document').on("hidden", function(){
//     $("#listof_files").empty();
//     console.log('MODAL WAS CLOSED');
// });

$('.close_button').on('click', function(){
    $("#listof_files").empty();
    console.log('MODAL WAS CLOSED');
});

$('form').on('submit', function(){
    $(this).find('button').prop('disabled', true);
});

$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        tags: true
    });
});
            
</script>

 
@endsection
