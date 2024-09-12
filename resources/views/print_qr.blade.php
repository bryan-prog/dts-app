<link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.1.0')}}" type="text/css">
<style>
    .container{
        /* border: 1px solid black; */
        height: 90%;
    }
    p{
        font-weight:800;
        color:black;
        margin-bottom:0;
    }
    .qr_code{
        width: 100%;
        border: 1px dashed;
        padding:5px;
        text-align:center;
    }
    .serialcode{
        font-size:12px;
    }
</style>
<div class="container qr-print">
    <div class="row dflex justify-content-center" style="align-items: center;">
        <img src="{{asset('images/bagong-pilipinas.png')}}" style="width:8%;">
        <img src="{{asset('images/sjc.png')}}" style="width:8%;">
        <img src="{{asset('images/mayor.png')}}" style="width:8%; margin-right:20px;">
        <p>Document Tracking System</p>
    </div>
    <div class="row mt-3">

        @php
            for($x=1;$x<=$series->initial_count;$x++)
            {
                if($x%6==0)
                {
                    echo "\n";
                }
                
        @endphp
                <div class="col-2">
                    <div class="qr_code" style="margin-bottom:17px;">
                        <div class="row" style="border: 1px solid black; margin-right: 0; margin-left: 0; flex-direction: column;">
                            <img class="qr" style="width: 100%;" src="{{asset('/files')}}/{{$series->office}}/QR Codes/{{$series->series}}/{{$series->office}}-{{$series->series}}-{{$x}}.png" alt="">
                            <p class="serialcode">{{$series->office}}-{{$series->series}}-{{$x}}</p>
                        </div>
                    </div>
                    <br>
                </div>
        @php
            }
        @endphp
                
    </div>
</div>