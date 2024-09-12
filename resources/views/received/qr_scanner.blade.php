@extends('layouts.masterlayout')

@section('content')
<div class="header pb-6" style="background-color: #16213E">
  	<div class="container-fluid">
    	<div class="header-body">
      		<div class="row align-items-center py-4">
        		<div class="col-lg-6 col-7">
          			<h6 class="h2 text-white d-inline-block mb-0">Test QR Scanner</h6>
                      <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{url('/incoming')}}">Incoming Documents</a></li>
                            </ol>
                      </nav>
        		</div>
      		</div>
    	</div>
  </div>
</div>
<div class="container-fluid mt--6">
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                <div id="qr-reader" style="width:500px"></div>
                <div id="qr-reader-results"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/vendor/html-barcode/html5-qrcode.min.js')}}"></script>
<script type="text/javascript">

var resultContainer = document.getElementById('qr-reader-results');
var lastResult, countResults = 0;

function onScanSuccess(decodedText, decodedResult) {
    if (decodedText !== lastResult) {
        ++countResults;
        lastResult = decodedText;
        resultContainer.innerHTML = lastResult;
        console.log('Scan result ${decodedText}', decodedResult);
    }
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);


</script>
@endsection
