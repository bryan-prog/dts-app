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

class docs_terminal extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function terminal_page()
    {
        return view('terminal.terminal');
    }

    public function terminal_list()
    {   
        $terminal = Documents::where('status', 6)->where('originating_office', Auth::user()->office_dept)->get();

        return DataTables::of($terminal)
            ->setRowId('id')
            ->editColumn('status', function($terminal){
                if($terminal->status == 6)
                {
                    return "Terminal";
                }
            })
            ->make(true);  
    }

    public function terminal_remarks_list($id)
    {
        $remarks = Dts_Records::where([['tracking_number', $id], ['status', 5]])->get();

        return Response::json($remarks);
    }

    public function terminal_returned_remarks_list($id)
    {
        $returned_remarks = Dts_Records::where([['tracking_number', $id], ['status', 7]])->get();

        return Response::json($returned_remarks);
    }
}
