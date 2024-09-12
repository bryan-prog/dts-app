<style>
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
                            <h6 class="h2 text-white d-inline-block mb-0">Add Documents</h6>
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
                    <form method="POST" action="save_add_doc" enctype="multipart/form-data" id="add_doc_form">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label" for="doctitle">Document Title: <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="doctitle" name="doctitle" placeholder="Your document title" style="color:black;" required> 
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="doctype">Document Type: <span style="color: red;">*</span></label>
                            <select class="form-control" id="doctype" name="doctype" style="color:black;" required>
                                <option>----</option>
                                @foreach($doctypes as $doctypes)
                                <option value="{{$doctypes->code}}">{{$doctypes->doc_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="docsubj">Document Subject: <span style="color: red;">*</span></label>
                            <select class="form-control" id="docsubj" name="docsubj" style="color:black;" required>
                                <option>----</option>
                                @foreach($docsubj as $docsubj)
                                <option value="{{$docsubj->doc_subject}}">{{$docsubj->doc_subject}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="urgency">Urgency: <span style="color: red;">*</span></label>
                            <select class="form-control" id="urgency" name="urgency" style="color:black;" required>
                                <option>----</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="remarks">Remarks:</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" style="resize:none;" style="color:black;"></textarea>
                        </div>
                        <!--FILE UPLOAD-->
                        <div class="form-group">
                            <div class="form-group control-group increment">
                                <label class="form-control-label" for="filename">Choose Files to Upload <span style="color: red;">*</span></label>
                                <input type="file" name="filename[]" id="file" class="form-control" multiple required>
                            </div>
                            <p>Selected files:</p>

                            <div id="fileList"></div>
                        </div>
                        <div class="form-group" style="float: right;">
                            <input type="hidden" id="status" name="status" readonly>
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
    })

    $('#add').on('click', function(){
        $('#status').val(1);
    })

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

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
    });

});

</script>

@endsection