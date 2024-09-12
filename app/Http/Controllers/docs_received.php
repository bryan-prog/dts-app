<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\Documents;
use App\Models\Dts_Records;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ActionLogs;
use App\Models\OfficeDept;

class docs_received extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function received_page()
    {
        $Offices = OfficeDept::all()->sortBy('dept_description');
        return view('received.received')->with(array('Offices'=>$Offices));
    }

    public function received_list()
    {   
        $received = Dts_Records::where('status', '5')->where('receiving_office', Auth::user()->office_dept)->get();

        return DataTables::of($received)
            ->setRowId('dts_id')
            ->make(true);  
    }

    public function mayors_for_review()
    {   
        $received = Dts_Records::where([['status', '5'],['receiving_office', 'MO'],['mayors_approval', null]])->get();

        return DataTables::of($received)
            ->setRowId('dts_id')
            ->make(true);  
    }

    public function mayors_approved_list()
    {
        $list = Dts_Records::where([['receiving_office', 'MO'], ['mayors_approval', 'Approved']])->get();

        return DataTables::of($list)
            ->setRowId('dts_id')
            ->make(true);
    }

    public function qr_scanner()
    {
        return view('received.qr_scanner');
    }

    // public function mayors_payroll_receive()
    // {
    //     $check_table = Dts_Records::where([['receiving_office', 'MO']])->get();

    //     if ()
    // }
}
