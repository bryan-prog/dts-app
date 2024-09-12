@extends('layouts.masterlayout')
@section('content')
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<form method="POST" action="../receive_submit" id="qr_submit">
	@csrf
	<center>
		<div class="loader"></div>
	</center>
	<input type="hidden" id="qr_code" name="qr_code" value="{{$document->qr_code}}"> 
  <input type="hidden" name="office_dept" value="{{Auth::user()->office_dept}}">
  
  <div class="modal fade" id="modal-receive" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
          <div class="modal-content">
              
              <div class="modal-body">
                  <div class="col-xs-6 form-group">
                      <label for="actual_urgency">Actual Urgency</label>
                      <select class="form-control" id="actual_urgency" name="actual_urgency" style="color:black;" required>
                          <option>----</option>
                          <option value="High">High</option>
                          <option value="Medium">Medium</option>
                          <option value="Low">Low</option>
                      </select>
                  </div>
                  <div class="col-xs-6 form-group">
                      <center>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </center>
                  </div>
              </div> 
          </div>
      </div>
  </div>
</form>


<script type="application/javascript">
$(function() {
   
    if("{{Auth::user()->office_dept}}" !== "MO")
    {
      $('#qr_submit').submit(); 
    }   
    else
    {
      $('.loader').hide();
      $('#modal-receive').modal('show');
    }

    $('form').on('submit', function(){
      $(this).find('button').prop('disabled', true);
    });
    
});
</script>

@endsection