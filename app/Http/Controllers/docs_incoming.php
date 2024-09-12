<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Auth;
use App\Models\Dts_Records;
use App\Models\Documents;
use App\Models\OfficeDept;
use App\Models\AttachedFiles;
use Yajra\DataTables\Facades\DataTables;
use Woenel\TxtBox\TxtBox;
use App\Models\User;
use App\Models\ActionLogs;
use App\Models\RecordsView;

class docs_incoming extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function incoming_page()
    {
        $Offices = OfficeDept::all()->sortBy('dept_description');
        return view('incoming.incoming')->with(array('Offices'=>$Offices ));
    }

    public function incoming_list()
    {   
        $incoming = Dts_Records::where('status', '4')->where('receiving_office', Auth::user()->office_dept)->get();

        return DataTables::of($incoming)
            ->setRowId('dts_id')
            ->make(true);  
    }

    public function submit_sms()
    {
        $data = ['number'=>'09064151135', 'message'=>'Sample message 1 from DTS!'];
        $data2 = ['number'=>'09985491893', 'message'=>'Sample message 2 from DTS!'];

        $client = new Client;

        try
        {
            $res = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                'form_params' => $data, 
                'headers' => [
                    'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                ]
            ]);

            $res2 = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                'form_params' => $data2, 
                'headers' => [
                    'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                ]
            ]);
        }
        catch(ClientException $e)
        {
            return json_decode($e->getResponse()->getBody(), 1);
        }
    }

    public function doc_view($id)
    {
        $doc = RecordsView::where('dts_id', $id)->first();
        return Response::json($doc);
    }

    public function attached_files($id)
    {
        $attached = AttachedFiles::where('dts_id', $id)->get();
        return Response::json($attached);
    }

    
    public function createReceive(Request $request)

    { 
        $dts = new Dts_Records;
        $dts->dts_id = Input::get('received_dtsid');
        $dts->tracking_number = Input::get('received_tracking_number');
        $dts->received_date = Input::get('received_date');
        $dts->receiving_office = Input::get('received_by_office');
        $dts->received_remarks = Input::get('received_remarks');

        $dts->save();

        $log = new ActionLogs;
        $log->tracking_number = $dts->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Received";
        $log->date_of_action = Carbon::now();

        $log->save();
    }

    public function forward_offices($id)
    {
        $doc = Dts_Records::where([['dts_id', $id],['receiving_office', "!=", Auth::user()->office_dept]])->pluck('receiving_office')->toArray();

        return Response::json($doc);
    }

    public function receive_document(Request $request)
    {
        $document = Dts_Records::where([['tracking_number', $request->received_tracking_number],['receiving_office', Auth::user()->office_dept]])->first();
        $originatingDocument = Documents::where('tracking_number', $request->received_tracking_number)->first();

        $date = $request->received_date;
        $document->received_date = $request->received_date;
        $document->received_remarks = $request->received_remarks;
        $document->received_by = $request->receiving_person;
        $document->received_by_username = Auth::user()->username;
        $document->actual_urgency = $request->actual_urgency;
        $document->forward_to_office = $request->forward_to_office;
        $document->status = 5;

        $document->save();

        $checker = Dts_Records::where([['tracking_number', $request->received_tracking_number], ['receiver_type', 'Main']])->pluck('status')->toArray();

        $i = 0;
        $max = sizeof($checker);
        
        if(in_array("4", $checker, TRUE))
        {
            $originatingDocument->status = 3;
        }
        else
        {
            $originatingDocument->status = 6;
        }

        $originatingDocument->latest_transaction = Auth::user()->office_dept;

        $originatingDocument->save();                                                                                   
        // dd($originatingDocument->status);

        $log = new ActionLogs;
        $log->tracking_number = $document->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Received";
        $log->date_of_action = Carbon::now();

        $log->save();

        $client = new Client;

        $receipient = User::where('username', $document->released_by)->first();
        $receiver = User::where('username', $document->received_by_username)->first();

        if($document->doc_type == "OD")
        {
            $doc_type = "an Office Document";
        }
        else if($document->doc_type == "RL")
        {
            $doc_type = "a Request Letter";
        }
        else if($document->doc_type == "T")
        {
            $doc_type = "a Transmittal";
        }
        else if($document->doc_type == "U")
        {
            $doc_type = "an Unclassified";
        }
        else if($document->doc_type == "P")
        {
            $doc_type = "a Payroll";
        }
        else{}

        //FUNCTION WILL TEXT THE CITY MAYOR IF THE DOCUMENT IS TAGGED AS HIGHLY URGENT
        if($document->actual_urgency === 'High')
        {
            $mayors_contact = User::where([['designation', 'City Mayor'],['active', 1]])->first();

            $mayors_data = ['number'=>$mayors_contact->contact, 'message'=>'A highly urgent letter with the tracking number '.$request->received_tracking_number. ' has been received at ' . Carbon::now()
            . ' by '. $document->received_by . '. For your review and approval.'];

            $mayors_data2 = ['number'=>$receiver->contact, 'message'=>'Successfully received '.$doc_type.' of '.$document->urgency.' urgency with tracking number '.$request->received_tracking_number. ' at ' . Carbon::now()
            . ' by '. $document->received_by];

            try
            {
                $res = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                    'form_params' => $mayors_data, 
                    'headers' => [
                        'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                    ]
                ]);

                if($document->actual_urgency == 'Medium' || $document->actual_urgency == 'High')
                {
                    $res2 = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                        'form_params' => $mayors_data2, 
                        'headers' => [
                            'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                        ]
                    ]);
                }
            }
            catch(ClientException $e)
            {
                return back()->with('danger', 'Whoops, something went wrong.');
            }
        }

        $data = ['number'=>$receipient->contact, 'message'=>'Successfully received document with tracking number '.$request->received_tracking_number. ' at ' . Carbon::now()
            . ' by '. $document->received_by];

        $data2 = ['number'=>$receiver->contact, 'message'=>'Successfully received '.$doc_type.' of '.$document->urgency.' urgency with tracking number '.$request->received_tracking_number. ' at ' . Carbon::now()
            . ' by '. $document->received_by];

        try
        {
            $res = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                'form_params' => $data, 
                'headers' => [
                    'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                ]
            ]);

            if($document->urgency == 'Medium' || $document->urgency == 'High')
            {
                $res2 = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                    'form_params' => $data2, 
                    'headers' => [
                        'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                    ]
                ]);
            }
        }
        catch(ClientException $e)
        {
            return back()->with('danger', 'Whoops, something went wrong.');
        }

        return back()->with('success', 'Successfully received document');
        
    }

    public function return_document(Request $request)
    {
        $document = Dts_Records::where([['tracking_number', $request->returned_tracking_number],['receiving_office', Auth::user()->office_dept]])->first();
        $originatingDocument = Documents::where('tracking_number', $request->returned_tracking_number)->first();

        $document->returned_date = $request->returned_date;
        $document->returned_remarks = $request->returned_remarks;
        $document->status = 7;

        $document->save();

        // $checker = Dts_Records::where('tracking_number', $request->returned_tracking_number)->pluck('status')->toArray();
        $checker = Dts_Records::where([['tracking_number', $request->received_tracking_number], ['receiver_type', 'Main']])->pluck('status')->toArray();

        $i = 0;
        $max = sizeof($checker);
        
        if(in_array("7", $checker, TRUE))
        {
            $originatingDocument->status = 3;
        }
        else
        {
            $originatingDocument->status = 6;
        }


        $originatingDocument->save();

        $log = new ActionLogs;
        $log->tracking_number = $document->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Returned";
        $log->date_of_action = Carbon::now();

        $log->save();

        $receipient = User::where('username', $document->released_by)->first();

        $client = new Client;

        $data = ['number'=>$receipient->contact, 'message'=>'The document with the tracking number '.$document->tracking_number. ' is being returned.'];
        try
        {
            $res = $client->request('POST', 'https://ws-v2.txtbox.com/messaging/v1/sms/push', [
                'form_params' => $data, 
                'headers' => [
                    'X-TXTBOX-Auth' => 'c70b05e11f368adf37216ec84c64c3b4'
                ]
            ]);
        }
        catch(ClientException $e)
        {
            return back()->with('danger', 'Whoops, something went wrong.');
        }

        return back()->with('success', 'Successfully returned document');
    }
    public function mayors_payroll_receive($id)
    {
        $record = Dts_Records::where('dts_id', $id)->where('doc_type','P')->where('receiving_office','!=','MO')->pluck('received_date')->toArray();;

        $max = sizeof($record);
        
        if(in_array(NULL, $record, TRUE))
        {
            $result=1;
        }
        else
        {
            $result=0;
        }
        
        return Response::json($result);
    }

}
