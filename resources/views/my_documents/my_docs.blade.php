<style>
	table#documents_list {
		color:black !important;
	}
	.form-control {
        color:black !important;
    }
	@media only screen and (max-width: 414px){
        button.btn.btn-primary, button.btn.btn-success, button.btn.btn-default, button.btn.btn-secondary{
			display: inline !important;
		}
		.btn{
			width: 100% !important;
			margin-bottom:10px;
		}
		.row.buttons {
			flex-direction: column;
		}
		button#viewDocBtn {
			left: 0px !important;
		}
		button#deleteDocBtn {
			left: 0 !important;
		}
    }
	@media only screen and (max-width:767px){
		/* button.btn.btn-primary{
			display: inline !important;
		}
		button.btn.btn-success{
			display: inline !important;
		} */
		.btn{
			width: 100% !important;
			margin-bottom:10px;
		}
		.row.buttons {
			flex-direction: column;
		}
		button#viewDocBtn {
			left: 0px !important;
		}
		button#deleteDocBtn {
			left: 0 !important;
		}
    }
</style>
@extends('layouts.masterlayout')
@inject('carbon', 'Carbon\Carbon')
@section('content')
<div class="header pb-6" style="background-color: #16213E">
  	<div class="container-fluid">
    	<div class="header-body">
      		<div class="row align-items-center py-4">
        		<div class="col-lg-6 col-7">
          			<h6 class="h2 text-white d-inline-block mb-0">My Documents</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
		                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
		                  <li class="breadcrumb-item"><a href="{{url('/add_doc')}}">Add Document</a></li>
		                  <li class="breadcrumb-item"><a type="button" id="editBtn">Edit Document</a></li>
		                  <li class="breadcrumb-item"><a type="button" id="viewDocBtn">View Document</a></li>
		                  <li class="breadcrumb-item"><a type="button" id="trackDocBtn">Track Document</a></li>
		                </ol>
	              	</nav>
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
			                    <th>Document Title</th>
			                    <th>Tracking No.</th>
			                    <th>Originating Office</th>
			                    <th>Last Transaction</th>
			                    <th>Status</th>
			                    <th></th>
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


	<button type="button" class="btn btn-success" style="display:none;"><a href="{{url('/add_doc')}}" style="color:white;">Add Document</a></button>
	<button type="button" class="btn btn-primary" id="editCollapseBtn" style="display:none;">Edit Document</button>
	<button type="button" class="btn btn-default" id="viewDocCollapseBtn" style="display:none;">View Document</button>
	<button type="button" class="btn btn-secondary" id="trackDocCollapseBtn" style="display:none;">Track Document</button>
	<button type="button" class="btn btn-danger" id="deleteDocBtn">Delete Document</button>



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
					<button type="button" class="btn btn-link  ml-auto" data-dismiss="modal" style="text-align:end;">Close</button>
				</div> 
			</div>
		</div>
	</div> 

	<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form method="POST" action="delete_doc">
						@csrf
						<input type="hidden" id="delID" name="delID" readonly>
						<div style="text-align: center;">
							<img src="{{asset('images/220px-Achtung.svg.png')}}">
						</div>
						<br>
						<center><h2>Are you sure you want to delete this document?</h2></center>
						<div style="text-align: center;">
							<button type="submit" class="btn btn-danger">Yes</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> 

	<!--TRACK DOC MODAL-->
	<div class="modal fade" id="track_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="modal-view-doc-title">DOCUMENT TRACKER</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
				</div>
				<div class="modal-body">
					<label for="tracking_table" id="tracking_table_label"></label>
					<div class="card">
						<div class="table-responsive py-4">
							<table class="table align-items-center table-flush" id="tracking_table">
								<thead class="thead-light">
									<tr>
										<th>Receiving Office</th>
										<th>Status</th>
										<th>Date Received</th>
										<th>Date Returned</th>
									</tr>
								</thead>
								<tbody class="list">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>	
 
<script type="application/javascript">
updateList = function() {
    var input = document.getElementById('file');
    var output = document.getElementById('fileList');
    var children = "";
    for (var i = 0; i < input.files.length; ++i) {
        children += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML = '<ul>'+children+'</ul>';
}
	
$(document).ready(function(){
	$('#documents_list').dataTable({
		ajax: '{{ url('my_documents_list') }}',
		processing: true,
    	serverSide: true,
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
	    "order": [[ 0, "desc" ]],
	    columns: 
	        [
	        	{data: 'id', name: 'id'},
	            {data: 'doc_title', name: 'doc_title'},
	            {data: 'tracking_number', name: 'tracking_number'},
	            {data: 'originating_office', name: 'originating_office'},
	            {data: 'latest_transaction', name: 'latest_transaction'},
	            {data: 'status', name: 'status'},
	            { 
              		data: null,
              		render: function(data, type, full, meta)
              		{
                  		return null;
              		} 
            	},

	        ],
	});

	var table = $('#documents_list').DataTable();
    var data;
    $('#documents_list tbody').on('click', 'tr', function(){
        $(this).addClass('selected').siblings().removeClass("selected");
        data = table.row(this).data();
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
            $.get("{{url('/my_docs_view')}}/" + selectedId, function(data){
                $('#modal-view-doc-title').html(data.tracking_number);
                $('#doc_title').val(data.doc_title);

                var doc_type = data.doc_type;
                if(doc_type == "OD")
                {
                	$('#doc_type').val("Office Document");
                }
                else if(doc_type == "RL")
                {
                	$('#doc_type').val("Request Letter");
                }
                else if(doc_type == "T")
                {
                	$('#doc_type').val("Transmittal");
                }
                else if(doc_type == "U")
                {
                	$('#doc_type').val("Unclassified");
                }
                else{}
                
                $('#doc_subject').val(data.doc_subject);
                $('#doc_origin').val(data.originating_office);
                $('#doc_remarks').val(data.remarks);
            });

            $.get("{{url('/attached_files')}}/" + selectedId, function(data){
                $.each(data, function(i, item){
                	console.log(item.from_office);
	                $('#listof_files').append("<li><a href='{{url('/')}}/files/"+item.from_office+"/"+item.filename+"'>"+item.filename+"</a></li>");
	            }); 
            });
            
            $('#modal-view-document').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
    });

	$('#viewDocCollapseBtn').on('click', function(){
        var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        var office;
        if(check == null)
        {
            alert("Please select document to view");
        }
        else
        {
            $.get("{{url('/my_docs_view')}}/" + selectedId, function(data){
                $('#modal-view-doc-title').html(data.tracking_number);
                $('#doc_title').val(data.doc_title);

                var doc_type = data.doc_type;
                if(doc_type == "OD")
                {
                	$('#doc_type').val("Office Document");
                }
                else if(doc_type == "RL")
                {
                	$('#doc_type').val("Request Letter");
                }
                else if(doc_type == "T")
                {
                	$('#doc_type').val("Transmittal");
                }
                else if(doc_type == "U")
                {
                	$('#doc_type').val("Unclassified");
                }
                else{}
                
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

    $('#editBtn').on('click', function(){
    	var check = $('.selected').attr('id');
    	var stat = data.status;
        var selectedId = $('.selected').attr('id');
        if(check == null)
        {
            alert("Please select documents to edit!");
        }
        else if(check != null && stat != 'Draft')
        {
        	if(stat != 'Available')
        	{
        		alert("Document cannot be edited once released!");
        	}
        	else
        	{
        		window.location = "{{url('/edit_document')}}/"+check;
        	}
        }
        else
        {
            window.location = "{{url('/edit_document')}}/"+check;
         
        }
        
    });

	$('#editCollapseBtn').on('click', function(){
    	var check = $('.selected').attr('id');
    	var stat = data.status;
        var selectedId = $('.selected').attr('id');
        if(check == null)
        {
            alert("Please select documents to edit!");
        }
        else if(check != null && stat != 'Draft')
        {
        	if(stat != 'Available')
        	{
        		alert("Document cannot be edited once released!");
        	}
        	else
        	{
        		window.location = "{{url('/edit_document')}}/"+check;
        	}
        }
        else
        {
            window.location = "{{url('/edit_document')}}/"+check;
         
        }
        
    });

    $('#trackDocBtn').on('click', function(){
		var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        var track_no = data.tracking_number;
        if(check == null)
        {
            alert("Please select documents to track!");
        }
        else
        {
            $('#tracking_table tbody').empty();
        	$('#tracking_table_label').html("");

            $.get("{{url('/track_doc')}}/" + track_no, function(data){
            	$('#tracking_table_label').html(track_no);
            	console.log(data);
                $.each(data, function(i, item){
                	// console.log(data);
                	var stat;var received_date;var returned_date;
                	if(item.status == 4)
                	{
                		stat = "Document Incoming";
                	}
                	else if(item.status == 5)
                	{
                		stat = "Document Received";
                	}
                	else if(item.status == 7)
                	{
                		stat = "Document Returned";
                	}
                	else{}

	                if(item.received_date != null)
	                {
	                	received_date = moment(item.received_date).format('MMMM D, YYYY');
	                }
	                else
	                {
	                	received_date = "";
	                }

	                if(item.returned_date != null)
	                {
	                	returned_date = moment(item.returned_date).format('MMMM D, YYYY');
	                }
	                else
	                {
	                	returned_date = "";
	                }


	                $('#tracking_table tbody').append("<tr><td>"+item.receiving_office+"</td><td>"+stat+"</td><td>"+received_date+"</td><td>"+returned_date+"</td></tr>");
	            }); 
            });

            $('#track_modal').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
    });

	$('#trackDocCollapseBtn').on('click', function(){
		var check = $('.selected').attr('id');
        var selectedId = $('.selected').attr('id');
        var track_no = data.tracking_number;
        if(check == null)
        {
            alert("Please select documents to track!");
        }
        else
        {
            $('#tracking_table tbody').empty();
        	$('#tracking_table_label').html("");

            $.get("{{url('/track_doc')}}/" + track_no, function(data){
            	$('#tracking_table_label').html(track_no);
            	console.log(data);
                $.each(data, function(i, item){
                	// console.log(data);
                	var stat;var received_date;var returned_date;
                	if(item.status == 4)
                	{
                		stat = "Document Incoming";
                	}
                	else if(item.status == 5)
                	{
                		stat = "Document Received";
                	}
                	else if(item.status == 7)
                	{
                		stat = "Document Returned";
                	}
                	else{}

	                if(item.received_date != null)
	                {
	                	received_date = moment(item.received_date).format('MMMM D, YYYY');
	                }
	                else
	                {
	                	received_date = "";
	                }

	                if(item.returned_date != null)
	                {
	                	returned_date = moment(item.returned_date).format('MMMM D, YYYY');
	                }
	                else
	                {
	                	returned_date = "";
	                }


	                $('#tracking_table tbody').append("<tr><td>"+item.receiving_office+"</td><td>"+stat+"</td><td>"+received_date+"</td><td>"+returned_date+"</td></tr>");
	            }); 
            });

            $('#track_modal').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
    });


    $('#deleteDocBtn').on('click', function(){
    	var check = $('.selected').attr('id');
    	var stat = data.status;
        var selectedId = $('.selected').attr('id');
        if(check == null)
        {
            alert("Please select documents to edit!");
        }
        else if(stat == 'Available' || stat == 'Draft')
        {
        	$('#delID').val(check)
        	$('#delete_modal').modal({
                backdrop: 'static',
                keyboard: true
            });
        }
        else
        {
        	alert("Cannot delete file that has been released!");
        }
    });

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
    });

});

</script>

@endsection
