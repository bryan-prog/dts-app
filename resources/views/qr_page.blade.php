<style>
    @media only screen and (max-width: 560px){
        .form-control{
            width: 25rem !important;
        }
        div#office_table_length{
            display: none !important;
        }
        div#office_table_filter{
            float:left;
        }
    }
    @media only screen and (max-width: 414px){
        .form-control{
            width: 18rem !important;
        }
    }
    @media only screen and (max-width: 516px){
        .form-control {
            width: 15rem !important;
        }
    }
</style>
@extends ('layouts.masterlayout')

@section ('content')

<div class="header pb-6" style="background-color: #16213E">
    <div class="container-fluid">
      <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">QR Generator</h6>
              </div>
            </div>
      </div>
    </div>
</div>
<div class="container-fluid mt--6">
  <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Generate QR code per Office.</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="office">Select office.</label>
                                <select class="form-control" id="office" name="office" style="color:black; width:35rem;" autocomplete="office_dept" required autofocus>
                                    <option>----</option>
                                    @foreach($offices as $office)
                                        <option value="{{$office->dept_code}}">{{$office->dept_description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="generate_qr" id="generate_qr_form" target="_blank">
                        @csrf
                        <input type="hidden" id="doc_id" name="doc_id" readonly>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-flush" id="office_table">
                                        <thead>
                                            <tr>
                                                <th>Tracking No.</th>
                                                <th>Document Title</th>
                                                <th>Document Type</th>
                                                <th>Document Subject</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" id="selOffice" class="btn btn-default">
                                        Generate QR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--MODAL VIEW-->
<div class="modal fade" id="modal-generate-qr" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-view-doc-title">Select receiving office for document</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <div class="modal-body">
                <ul id="list_of_qr">
                    
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div> 
        </div>
    </div>
</div> 

<script type="text/javascript">
$(document).ready(function(){
    $('#office').on('change', function(){
        var officeSel = $(this).val();
        $('#office_table').DataTable().destroy();
        $('#office_table').dataTable( {
            ajax: '{{ url('qr_office_list') }}/'+officeSel,
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
                
            ],
            pagingType: "full_numbers",
        });
    });

    var office_table = $('#office_table').DataTable();
    var data;
    $('#office_table tbody').on('click', 'tr', function(){
        $(this).addClass('selected').siblings().removeClass("selected");
        data = office_table.row(this).data();
        var check = $('.selected').attr('id');
        $('#doc_id').val(check);
    });

    $('#generate_qr_form').on('submit', function(e){
        var get_id = $('#doc_id').val();
        if(get_id>0)
        {    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            e.preventDefault();
            // $('#loadingModal').modal('show');
            var form = $('#generate_qr_form')[0];
            var formData = new FormData(form);
            var type = "POST";
            var my_url = "{{ url('/generate_qr')}}/"+get_id;
            var info = '<strong>Success!</strong>';

            console.log(formData);
            
            $.ajax({

                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT This
                success: function (data) {
                    console.log(data);
                    // $('#loadingModal').modal('toggle');
                    // $("#printNowModal").modal('show');
                    $('#list_of_qr').empty();

                    $('#dts_record_id').val(get_id);
                    $.get("{{url('/generate_for')}}/" + get_id, function(data){
                        console.log(data);
                        $.each(data, function(i, item){
                            $('#list_of_qr').append("<li><a href='{{url('/')}}/files/"+item.originating_office+"/QR Codes/"+item.qr_code+".png' target='__blank'>"+item.receiving_office+"</a></li>");
                        });

                    });

                    $('#modal-generate-qr').modal({
                        backdrop: 'static',
                        keyboard: true
                    }); 
                },
                error: function (data) {
                    console.log('Error:', data);
                    // $('#loadingModal').hide();
                    // $('#errorModal').modal('toggle');
                }
            });
        }
    });

});
</script>

@endsection