<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\OfficeDept;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\User;
use App\Models\Documents;
use App\Models\Dts_Records;
use Illuminate\Support\Facades\Input;
use App\Models\ActionLogs;
use Woenel\TxtBox\TxtBox;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $released = Documents::where('originating_office', Auth::user()->office_dept)->where('status','=',3)->count();
        $pending= Documents::where('originating_office', Auth::user()->office_dept)->where('status','=',1)->count();
        $incoming= DTS_Records::where('status','=',4)->where('receiving_office', Auth::user()->office_dept)->count();
        $received= DTS_Records::where('status','=',5)->where('receiving_office', Auth::user()->office_dept)->count();
        $terminal= Documents::where('originating_office', Auth::user()->office_dept)->where('status','=',6)->count();
        $draft= Documents::where('originating_office', Auth::user()->office_dept)->where('status','=',2)->count();
        return view('home', compact('released', 'pending','incoming','received','draft','terminal'));
    }

    public function users()
    {
        $departments = OfficeDept::all()->sortBy('dept_description');
        return view('users.users')->with(array('departments'=>$departments));
    }

    public function list_of_users()
    {
        $users = User::all();

        return DataTables::of($users)
            ->setRowId('id')
            ->make(true);
    }

    public function track_doc(Request $request) 
    {
        $track_No = Input::get ( 'track_No' );
        $doc = Documents::where ( 'tracking_number', 'LIKE', '%' . $track_No . '%' )->get ();

        if (count ( $doc ) > 0)
            return view ( 'home' )->withDetails ( $doc )->withQuery ( $track_No );
        else
            return view ( 'home' )->withMessage ( 'No Details found. Try to search again!' );
    }

    public function floor($id)
    {
        $depts = OfficeDept::where('dept_floor', $id)->get();

        return Response::json($depts);
    }

    public function test()
    {
        $user = User::all();
        $another_user = User::all();
        return view('test')->with(array('user'=>$user, 'another_user'=>$another_user));
    }

    public function mayors_index()
    {
        $highly_urgent_letters = Dts_Records::where([['receiving_office', 'MO'],['actual_urgency', 'High']])->count();
        $medium_urgent_letters = Dts_Records::where([['receiving_office', 'MO'],['actual_urgency', 'Medium']])->count();
        $low_urgent_letters = Dts_Records::where([['receiving_office', 'MO'],['actual_urgency', 'Low']])->count();
        return view('mayor_only.mayors_index', compact('highly_urgent_letters','medium_urgent_letters','low_urgent_letters'));
    }

    public function mayors_approval(Request $request)
    {
        
        $document = Dts_Records::where('dts_id', $request->letter_id)->first();
        $document->mayors_approval = $request->approval_level;
        $document->mayors_remarks = $request->mayors_remarks;

        $document->save();

        //SEND CONFIRMATION MESSAGE TO LETTER'S ORIGINAL OWNER AND RECEIVER OF LETTER

        $txtbox = new TxtBox;

        $original_sender = User::where('username', $document->released_by)->first();
        $receiver = User::where('username', $document->received_by_username)->first();

        if($document->mayors_approval === "Approved")
        {
            $result = $txtbox->to($original_sender->contact)->message('The document with the tracking number '.$document->tracking_number. ' has been approved at ' . Carbon::now()
            . ' by the mayor.')->send();

            $result2 = $txtbox->to($receiver->contact)->message('The document with the tracking number '.$document->tracking_number. ' has been approved at ' . Carbon::now()
                . ' by the mayor.')->send();

            $type = 'success';
            $message = "Document has been approved.";

            $action_log = "Approved Document";
        } 
        else if($document->mayors_approval === "For Review")
        {
            $result = $txtbox->to($original_sender->contact)->message('The document with the tracking number '.$document->tracking_number. ' has been tagged as For Review at ' . Carbon::now()
            . ' by the mayor.')->send();

            $result2 = $txtbox->to($receiver->contact)->message('The document with the tracking number '.$document->tracking_number. ' has been tagged as For Review at ' . Carbon::now()
                . ' by the mayor.')->send();

            $type = 'warning';
            $message = "Document has been tagged as For Review.";

            $action_log = "Tagged Document as For Review";
        }
        else if($document->mayors_approval === "Disapproved/Rejected")
        {
            $result = $txtbox->to($original_sender->contact)->message('The document with the tracking number '.$document->tracking_number. ' has been disapproved at ' . Carbon::now()
            . ' by the mayor.')->send();

            $result2 = $txtbox->to($receiver->contact)->message('The document with the tracking number '.$document->tracking_number. ' has been disapproved at ' . Carbon::now()
                . ' by the mayor.')->send();

            $type = 'danger';
            $message = "Document has been disapproved.";

            $action_log = "Disapproved Document";
        }
        else{$action_log="";}      

        $log = new ActionLogs;
        $log->tracking_number = $document->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = $action_log;
        $log->date_of_action = Carbon::now();

        $log->save(); 

        return back()->with($type, $message);
    }

    public function list_approved()
    {
        return view('mayor_only.list_approved');
    }

    public function edit_profile()
    {
        return view('users.user_profile');
    }

    public function edit_save(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $user->name = $request->name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->suffix = $request->suffix;
        $user->contact = $request->contact;

        $user->save();

        return back()->with('success', "Successfully changed user details!");
    }

    public function change_pass_save(Request $request)
    {
        User::where('id', $request->user_id)
            ->update([
                'password'=> Hash::make($request->change_pass),
            ]);

        return back()->with('success', 'Successfully updated password!');
    }

    public function testing_route()
    {
        $office = OfficeDept::all()->sortBy('dept_description');

        return view('testing_page', compact('office'));
    }
}
