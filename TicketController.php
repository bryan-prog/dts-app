<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueueingController extends Controller
{
    public function QueueingNumber()
    {
        return view('SJQS_QueueingNumber');
    }
    public function Queueing_TV()
    {
        return view('UI_TV.SJQS_Queueing_TV');
    }
    public function SJQS_TicketMachine()
    {
        return view('ticketmachine.SJQS_TicketMachine');
    }
}
