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
<script src="{{asset('assets/js/index.umd.js')}}"></script>
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
                <form method="POST" action="#" id="generate_qr_form">
                @csrf
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3>Assign QR to office</h3>
                            </div>
                            <div class="col" style="display: flex; justify-content: flex-end;">
                                <!-- <button type="submit" id="selOffice" class="btn btn-default">
                                    Generate QR
                                </button> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="office">Select office.</label>
                                    <select class="form-control" id="office" name="office" style="color:black; width:35rem;" autocomplete="office" required autofocus>
                                        <option>----</option>
                                        @foreach($offices as $office)
                                            <option value="{{$office->dept_code}}">{{$office->dept_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="doc_id" name="doc_id" readonly>
                        <input type="hidden" id="sel_ofc" name="sel_ofc" readonly>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <h4>List of Assigned QR Codes</h4>
                                        </div>
                                        <div class="col" style="display: flex; justify-content: flex-end;">
                                            <button type="button" class="btn btn-primary btn-sm" id="tag_qr_button">Assign new QR Codes</button>
                                            <button type="button" class="btn btn-secondary btn-sm" id="print_qr_button">Print Series</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-flush" id="qr_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Office</th>
                                                    <th>For Month/Year</th>
                                                    <th>Series</th>
                                                    <th>Initial Count</th>
                                                    <th>Remaining</th>
                                                    <th>Used</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--MODAL TAG TO QR-->
<div class="modal fade" id="modal-tag-qr" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-tag-doc-title">Assign new QR series</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <form method="POST" action="assign_new_qr_series">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Office</td>
                                        <td>For Month/Year (Please select 1st day of the month)</td>
                                        <td>Amount to be assigned</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="selected_office" name="selected_office" class="form-control" readonly></td>
                                        <td><input type="date" id="for_month_year" name="for_month_year" class="form-control" value="<?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-01', time()); echo $date; ?>" required></td>
                                        <td><input type="number" min="5" max="96" id="amount" name="amount" class="form-control" required></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="assign_qr_id" name="assign_qr_id">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Apply</button>
                </div>    
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $('#office').on('change', function(){
        var officeSel = $(this).val();
        
        $('#qr_table').DataTable().destroy();
        $('#qr_table').dataTable( {
            ajax: '{{ url('list_of_qr') }}/'+officeSel,
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
                { data: 'office', name: 'office' },
                { data: 'month_year', name: 'month_year' },
                { data: 'series', name: 'series' },
                { data: 'initial_count', name: 'initial_count' },
                { data: 'remaining', name: 'remaining' },
                { data: 'used', name: 'used' },
                
            ],
            pagingType: "full_numbers",
        });
    });

    $('#tag_qr_button').on('click', function(){
        var office = $('#office').val();
        
        if(office.length <= 0 || office == null || office == '----')
        {
            alert('Please select an office first!');
        }
        else
        {
            $('#selected_office').val(office);
            $('#modal-tag-qr').modal('show');
        }
    });

    $("#modal-tag-qr").on("hidden.bs.modal", function(){
        $(this).find('form').trigger('reset');
    });

    var series;
    var office;

    $('#qr_table tbody').on('click', 'tr', function(){
        series = $(this).closest("tr").find('td:eq(2)').text();
        office = $(this).closest("tr").find('td:eq(0)').text();
        console.log($(this).closest("tr").find('td:eq(2)').text());
    });

    $('#print_qr_button').on('click', function(){
        console.log(series);
        if(series.length <= 0 || series == null)
        {
            alert('Please select a series first!');
        }
        else
        {
            window.open("{{url('/print_qr_series')}}/"+series+'/'+office, '_blank');
        }

    });

    $('#amount').on('keyup', function(){
        if($(this).val() > 50)
        {
            $(this).val(50);
        }
    });

    $('form').on('submit', function(){
        $(this).find('button').prop('disabled', true);
    });
});
</script>

@endsection