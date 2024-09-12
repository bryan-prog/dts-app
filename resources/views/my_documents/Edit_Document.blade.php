@extends('layouts.masterlayout')

@section('content')
<div class="header pb-6" style="background-color: #16213E">
    <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Edit Documents</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{url('/my_documents')}}">My Documents</a></li>
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
                <div class="card-body">
                    <form method="POST" action="../save_edit_doc" enctype="multipart/form-data" id="edit_form">
                        @csrf
                        <input type="hidden" name="doc_id" value="{{$docs->id}}">
                        <div class="form-group">
                            <label class="form-control-label" for="doctitle">Document Title:</label>
                            <input type="text" class="form-control" id="doctitle" name="doctitle" placeholder="Your document title" value="{{$docs->doc_title}}" style="color:black;"> 
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="doctype">Document Type:</label>
                            <!-- <input type="text" class="form-control" value="{{$docs->doc_type}}"> -->
                            <select class="form-control" id="doctype" name="doctype" style="color:black;" disabled>
                                <option>----</option>
                                @foreach($doctypes as $doctypes)
                                <option value="{{$doctypes->code}}" {{$docs->doc_type == $doctypes->code  ? 'selected' : ''}}>{{$doctypes->doc_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="docsubj">Document Subject:</label>
                            <!-- <input type="text" class="form-control" value="{{$docs->doc_subject}}"> -->
                            <select class="form-control" id="docsubj" name="docsubj" style="color:black;">
                                <option>----</option>
                                @foreach($docsubj as $docsubj)
                                <option value="{{$docsubj->doc_subject}}" {{$docs->doc_subject == $docsubj->doc_subject  ? 'selected' : ''}}>{{$docsubj->doc_subject}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="remarks">Remarks:</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" style="resize:none;" style="color:black;">{{$docs->remarks}}</textarea>
                        </div>

                        <!--FILE UPLOAD-->
                        <div class="form-group">
                            <div class="form-group control-group increment">
                                <label class="form-control-label" for="filename">Choose Files to Upload (if any)</label>
                                <input type="file" name="filename[]" id="file" class="form-control" onchange="javascript:updateList()" multiple>
                            </div>
                            <p>Selected files:</p>

                            <div id="fileList"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="attached_list">Attached Files:</label>
                            <table class="table align-items-center table-flush" id="listof_files">
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="form-group" style="float: right;">
                            <input type="hidden" id="status" name="status" readonly>
                            <input type="hidden" id="file_id" name="file_id" readonly>
                            <button type="submit" id="draft" class="btn btn-secondary">Save as Draft</button>
                            <button type="submit" id="add" class="btn btn-primary">Add Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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

    $('#draft').on('click', function(){
        $('#status').val(2);
    });

    $('#add').on('click', function(){
        $('#status').val(1);
    });   

    $("#file").change(function () {
        var fileExtension = ['pdf', 'doc', 'docx', 'xlsx', 'xls', 'csv', 'xml', 'xps', 'ods'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only the following formats are allowed : "+fileExtension.join(', '));
            $(this).val("");
            $('#fileList').empty();
        }
        else
        {
            updateList();
        }
    });

    $.get("{{url('/attached_files')}}/" + "{{$docs->id}}", function(data){
        $.each(data, function(i, item){
            console.log("{{$docs->originating_office}}");
            $('#listof_files > tbody:last-child').append("<tr id='"+item.id+"'><td><a href='{{url('/')}}/files/"+item.from_office+"/"+item.filename+"'>"+item.filename+"</a></td><td><button type='submit' id='del_button' class='table-action table-action-delete'>X</button></td></tr>");
        });
    });

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
    });

});

$(document).on('click', '#del_button', function(){
    console.log("I was clicked");
    $('#edit_form').prop('action', '../remove_file');
    $('#file_id').val($(this).closest('tr').attr('id'));
});

</script>

@endsection