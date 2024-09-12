<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Auth;
use App\Models\Dts_Records;
use App\Models\Documents;
use App\Models\OfficeDept;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ActionLogs;
use App\Models\QRCounter;

class docs_pending extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pending_page()
    {
        $Offices = OfficeDept::all()->sortBy('dept_description');
        $CC_Offices = OfficeDept::all()->sortBy('dept_description');
        return view('pending.pending')->with(array('Offices'=>$Offices))->with(array('CC_Offices'=>$CC_Offices));
    }

    public function pending_list()
    {   
        $pending = Documents::where([['status', '1'],['originating_office', Auth::user()->office_dept]])->get();

        return DataTables::of($pending)
            ->setRowId('id')
            ->make(true);
    }

    public function release_document_page()
    {
        $release_to_office = OfficeDept::all()->sortBy('dept_description');
        return view('docs_pending')->with(array('release_to_office'=>$release_to_office));
    }

    public function release_document(Request $request)
    {
        if(Auth::user()->middle_name != null)
        {
            $mname = ' '.Auth::user()->middle_name;
        }
        else
        {
            $mname = '';
        }

        if(Auth::user()->suffix != null)
        {
            $suffix = ' '.Auth::user()->suffix;
        }
        else
        {
            $suffix = '';
        }

        $document = Documents::where('tracking_number', $request->released_tracking_number)->first();
        $receiving_offices = $request->released_to_office;
        $cc_receiving_offices = $request->cc_released_to_office;
        $assigned_qr = $request->available_qr_list;
        $data = [];
        $cc_data = [];

        foreach($receiving_offices as $index => $receiving_office)
        {
            $data[] = [
                'dts_id'=>$document->id,
                'tracking_number'=>$document->tracking_number,
                'doc_type'=>$document->doc_type,
                'doc_title'=>$document->doc_title,
                'doc_subject'=>$document->doc_subject,
                'doc_urgency'=>$document->urgency,
                'originating_office'=>$document->originating_office,
                'latest_transaction'=>$document->latest_transaction,
                'receiving_office'=>$receiving_office,
                'receiver_type'=>"Main",
                'released_date'=>$request->released_date,
                'released_by'=>Auth::user()->username,
                'released_remarks'=>$request->released_remarks,
                'status'=>4,
                'qr_code'=>$assigned_qr,
                'qr_used'=>0,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ];
        }

        Dts_Records::insert($data);

        if(!(is_null($cc_receiving_offices)))
        {
            foreach ($cc_receiving_offices as $key=>$value) 
            {
               $cc_data[] = [
                    'dts_id'=>$document->id,
                    'tracking_number'=>$document->tracking_number,
                    'doc_type'=>$document->doc_type,
                    'doc_title'=>$document->doc_title,
                    'doc_subject'=>$document->doc_subject,
                    'doc_urgency'=>$document->urgency,
                    'originating_office'=>$document->originating_office,
                    'latest_transaction'=>$document->latest_transaction,
                    'receiving_office'=>$value,
                    'receiver_type'=>"CC",
                    'released_date'=>$request->released_date,
                    'released_by'=>Auth::user()->username,
                    'released_remarks'=>$request->released_remarks,
                    'status'=>4,
                    'qr_code'=>$assigned_qr,
                    'qr_used'=>0,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ];
            }

            Dts_Records::insert($cc_data);
        }

        $document->status = 3;
        $document->qr_code = $request->available_qr_list;
        $document->save();

        $qr = QRCounter::where([['office', $document->originating_office],['remaining', '>', 0]])->first();
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

        $log = new ActionLogs;
        $log->tracking_number = $document->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Released Document";
        $log->date_of_action = Carbon::now();

        $log->save();

        return back()->with('message', 'Successfully released document');
        
    }

    public function release_received_doc(Request $request)
    {
        if(Auth::user()->middle_name != null)
        {
            $mname = ' '.Auth::user()->middle_name;
        }
        else
        {
            $mname = '';
        }

        if(Auth::user()->suffix != null)
        {
            $suffix = ' '.Auth::user()->suffix;
        }
        else
        {
            $suffix = '';
        }

        $document = Documents::where('tracking_number', $request->released_tracking_number)->first();
        $receiving_offices = $request->released_to_office;
        $data = [];

        foreach($receiving_offices as $index => $receiving_office)
        {
            $data[] = [
                'dts_id'=>$document->id,
                'tracking_number'=>$document->tracking_number,
                'doc_type'=>$document->doc_type,
                'doc_title'=>$document->doc_title,
                'doc_subject'=>$document->doc_subject,
                'doc_urgency'=>$document->urgency,
                'originating_office'=>Auth::user()->office_dept,
                'latest_transaction'=>$document->latest_transaction,
                'receiving_office'=>$receiving_office,
                'released_date'=>$request->released_date,
                'released_by'=>Auth::user()->username,
                'released_remarks'=>$request->released_remarks,
                'status'=>4,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ];
        }

        Dts_Records::insert($data);

        $log = new ActionLogs;
        $log->tracking_number = $document->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Released Document";
        $log->date_of_action = Carbon::now();

        $log->save();

        return back()->with('message', 'Successfully released document');
        
    }

    public function pending_doc_view($id)
    {
        $doc = Documents::where('id', $id)->first();

        return Response::json($doc);
    }
}
