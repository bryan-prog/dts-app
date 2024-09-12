<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use QRCode;
use App\Models\Documents;
use App\Models\OfficeDept;
use App\Models\QRCounter;
use App\Models\Dts_Records;
use File;
use Carbon\Carbon;
use Woenel\TxtBox\TxtBox;
use App\Models\User;
use App\Models\ActionLogs;

class QrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function qr_make(Request $request, $id)
    // {
    //     $dts = Documents::where('id', $request->doc_id)->first();
    //     $doc = Dts_Records::where('dts_id', $request->doc_id)->get();

    //     if($dts->qr_code == null)
    //     {
    //         $today = Carbon::today();

    //         //Count remaining QR for the office
    //         $qr = QRCounter::where('office', $request->sel_ofc)->first();
    //         if($qr->used == 0)
    //         {
    //             $qr->used = 1;
    //             $qr->remaining = $qr->initial_count - 1;
    //         }
    //         else
    //         {
    //             $qr->used += 1;
    //             $qr->remaining = $qr->initial_count - $qr->used;
    //         }
    //         $qr->save();

    //         $code = $request->sel_ofc."-".$today->format('y').$today->month."-".$qr->used;

    //         $dts->qr_code = $code;
    //         $dts->save();

    //         //Create Folder if it doesn't exist already
    //         if(!File::exists(public_path()."/files/".$dts->originating_office."/QR Codes")) 
    //         {
    //             File::makeDirectory(public_path()."/files/".$dts->originating_office."/QR Codes");
    //         }

    //         //Set QR URL to receive_qr class while setting qr_code parameter value to generated qr code
    //         $url = action([QrController::class, 'receive_qr'], ['qr_code'=>$dts->qr_code]); 

    //         $file = public_path()."/files/".$dts->originating_office."/QR Codes/".$dts->qr_code.".png";
    //         QRCode::url($url)->setSize(8)->setMargin(2)->setOutFile($file)->png();

    //         foreach ($doc as $key => $document) 
    //         {
    //             $document->qr_code = $code;
    //             $document->qr_used = 0;
    //             $document->save();
    //         }
    //     }

    //     $log = new ActionLogs;
    //     $log->tracking_number = $dts->tracking_number;
    //     $log->username = Auth::user()->username;
    //     $log->action = "Created QR Code";
    //     $log->date_of_action = Carbon::now();

    //     $log->save();

    //     // dd($qr);
    //     return Response::json($doc);
    // }

    public function available_qr($office)
    {
        $qr = QRCounter::where([['office', $office],['remaining', '>', 0]])->first();
        $today = Carbon::today();

        $data = [];

        for($x = $qr->used+1; $x <= $qr->initial_count; $x++)
        {
            $data[] = $office."-".$qr->series."-".$x;
        }

        return Response::json($data);
    }

    public function tag_qr(Request $request)
    {
        $documents = Dts_Records::where('tracking_number', $request->assign_qr_id)->get();
        $dts = Documents::where('id', $documents[0]->dts_id)->first();

        //ASSIGN QR CODE TO EACH DOC RECORD
        foreach ($documents as $key => $document) 
        {
            $document->qr_code = $request->available_qr_list;
            $document->qr_used = 0;
            $document->save();
        }

        //ASSIQN QR CODE TO DOC RECORD
        $dts->qr_code = $request->available_qr_list;
        $dts->save();

        $qr = QRCounter::where([['office', $dts->originating_office],['remaining', '>', 0]])->first();
        if($qr->used == 0)
        {
            $qr->used = 1;
            $qr->remaining = $qr->initial_count - 1;
        }
        else
        {
            $qr->used += 1;
            $qr->remaining = $qr->initial_count - $qr->used;
        }
        $qr->save();

        //Create Folder if it doesn't exist already
        if(!File::exists(public_path()."/files/".$dts->originating_office."/QR Codes")) 
        {
            File::makeDirectory(public_path()."/files/".$dts->originating_office."/QR Codes");
        }

        //Set QR URL to receive_qr class while setting qr_code parameter value to generated qr code
        $url = action([QrController::class, 'receive_qr'], ['qr_code'=>$request->available_qr_list]); 

        $file = public_path()."/files/".$dts->originating_office."/QR Codes/".$dts->qr_code.".png";
        QRCode::url($url)->setSize(8)->setMargin(2)->setOutFile($file)->png();

        $log = new ActionLogs;
        $log->tracking_number = $dts->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Assigned QR Code to document with tracking number ".$dts->tracking_number;
        $log->date_of_action = Carbon::now();

        $log->save();

        // dd($qr);
        return back()->with('success', 'Successfully assigned QR Code to document!');
    }

    public function QrGenerate_page()
    {
        $offices = OfficeDept::all()->sortBy('dept_description');
        return view('qr_generate', ['offices'=>$offices]);
    }

    public function QrPage()
    {
        $offices = OfficeDept::all()->sortBy('dept_description');
        return view('qr_page', ['offices'=>$offices]);
    }

    public function generate_for($id)
    {
        $doc = Documents::where('id', $id)->get();

        return Response::json($doc);
    }

    public function qr_office_list($id)
    {
        $doc = Documents::where('status', '3')->where('originating_office', $id)->get();

        return DataTables::of($doc)
            ->setRowId('id')
            ->make(true);
    }

    public function receive_qr($qr_code)
    {
        $document = Dts_Records::where('qr_code', $qr_code)->first();

        return view('received.qr_form', ['document'=>$document]);
    }

    public function receive_submit(Request $request)
    {
        $document = Dts_Records::where([['receiving_office', $request->office_dept], ['qr_code', $request->qr_code]])->first();

        if($document->qr_used == 0)
        {
            $document->qr_used = 1;
            $document->received_date = Carbon::today();
            $document->received_by = Auth::user()->username;
            $document->status = 5;
            $document->save();

            $txtbox = new TxtBox;

            $receipient = User::where('username', $document->released_by)->first();
        
            $result = $txtbox->to($receipient->contact)->message('Successfully received document with tracking number '.$document->tracking_number. ' at ' . Carbon::now()
            . ' by '. $document->received_by)->send();

            $log = new ActionLogs;
            $log->tracking_number = $document->tracking_number;
            $log->username = Auth::user()->username;
            $log->action = "Received Document using QR Code";
            $log->date_of_action = Carbon::now();

            $log->save();
        }
        else
        {
            $log = new ActionLogs;
            $log->tracking_number = $document->tracking_number;
            $log->username = Auth::user()->username;
            $log->action = "Attempted to receive document using QR Code";
            $log->date_of_action = Carbon::now();

            $log->save();

            return redirect('/')->with('warning', 'QR is invalid or has already been used. Please contact your admin officer.');
        }

        // dd($document);

        return redirect('/')->with('message', 'Document has been received successfully.');
    }

    public function assign_qr_page()
    {
        $offices = OfficeDept::all()->sortBy('dept_description');
        return view('assign_qr_page', ['offices'=>$offices]);
    }

    public function list_of_qr($office)
    {
        $list_of_qr = QRCounter::where('office', $office)->get();

        return DataTables::of($list_of_qr)
            ->editColumn('month_year', function($list_of_qr){
                $month_year = Carbon::parse($list_of_qr['for_month_year']);

                return $month_year->month.'-'.$month_year->year;
            })
            ->setRowId('id')
            ->make(true);
    }

    public function assign_new_qr_series(Request $request)
    {
        $new_qrs = new QRCounter;

        $assigned_date = new Carbon($request->for_month_year);

        if($assigned_date->firstOfMonth() == $request->for_month_year)
        {
            $first_day_of_month = $request->for_month_year;
        }
        else
        {
            $first_day_of_month = $assigned_date->firstOfMonth();
        }

        $new_qrs->office = $request->selected_office;
        $new_qrs->year_generated = Carbon::today()->year;
        $new_qrs->for_month_year = $first_day_of_month;
        $new_qrs->initial_count = $request->amount;
        $new_qrs->remaining = $request->amount;
        $new_qrs->used = 0;

        $new_qrs->save();

        $same_month_series = QRCounter::where([['office', $request->selected_office],['for_month_year', $first_day_of_month]])->count();
        $code = Carbon::parse($new_qrs->for_month_year);

        if($same_month_series == 0)
        {
            $series_count = 1;
        }
        else
        {
            $series_count = $same_month_series;
        }

        if($same_month_series<10)
        {
            $new_qrs->series = $code->format('y').$code->month.'0'.$series_count;
        }
        else
        {
            $new_qrs->series = $code->format('y').$code->month.$series_count;
        }
        
        $new_qrs->save();

        //Create Folder if it doesn't exist already
        if(!File::exists(public_path()."/files/".$new_qrs->office)) 
        {
            File::makeDirectory(public_path()."/files/".$new_qrs->office);
        }

        if(!File::exists(public_path()."/files/".$new_qrs->office."/QR Codes/")) 
        {
            File::makeDirectory(public_path()."/files/".$new_qrs->office."/QR Codes/");
        }

        if(!File::exists(public_path()."/files/".$new_qrs->office."/QR Codes/".$new_qrs->series)) 
        {
            File::makeDirectory(public_path()."/files/".$new_qrs->office."/QR Codes/".$new_qrs->series);
        }

        //BULK GENERATE ALL QR CODES OF THE NEW SERIES
        for($x = $new_qrs->used+1; $x <= $new_qrs->initial_count; $x++)
        {
            //THE GENERATED QR CODE
            $code = $new_qrs->office."-".$new_qrs->series."-".$x;

            //SET QR CODE URL
            $url = action([QrController::class, 'receive_qr'], ['qr_code'=>$code]); 

            //GENERATE QR CODE TO FILE PATH
            $file = public_path()."/files/".$new_qrs->office."/QR Codes/".$new_qrs->series."/".$code.".png";
            QRCode::url($url)->setSize(8)->setMargin(2)->setOutFile($file)->png();
        }

        $log = new ActionLogs;
        $log->username = Auth::user()->username;
        $log->action = "Assigned new QR Code series to " . $new_qrs->office;
        $log->date_of_action = Carbon::now();

        $log->save();

        return back()->with('success', 'Successfully assigned new QR to office!');
    }

    public function print_qr_series($series, $office)
    {
        $series = QRCounter::where([['series', $series], ['office', $office]])->first();

        return view('print_qr', ['series'=>$series, 'office'=>$office]);
    }

    public function remaining_qr($office)
    {
        $qr_count = QRCounter::where('office', Auth::user()->office_dept)->sum('remaining');

        return Response::json($qr_count);
    }
}
