<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Carbon\Carbon;
use App\Models\Documents;
use App\Models\Dts_Records;
use App\Models\User;
use App\Models\DocumentTypes;
use App\Models\AttachedFiles;
use App\Models\DocumentSubject;
use File;
use App\Models\ActionLogs;

class my_documents extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function documents_page()
    {
        $doctypes = DocumentTypes::all();
        $docsubj = DocumentSubject::all();
        return view('my_documents.my_docs', ['doctypes'=>$doctypes, 'docsubj'=>$docsubj]);
    }

    public function add_document_page()
    {
        $doctypes = DocumentTypes::all();
        $docsubj = DocumentSubject::all();
        return view('my_documents.Add_Document')->with(array('doctypes'=>$doctypes, 'docsubj'=>$docsubj));
    }

    public function document_info($id)
    {
        $doc_info = Documents::find($id);

        return Response::json($doc_info);
    }

    public function uploaded_files($id)
    {
        $uploaded_files = AttachedFiles::where('dts_id', $id)->get();

        return Response::json($uploaded_files);
    }

    public function my_documents_list()
    {
        $documents = Documents::where('originating_office', '=', Auth::user()->office_dept)->where('status', '!=', 8)->get();

        return DataTables::of($documents)
            ->setRowId('id')
            ->editColumn('status', function($documents){
                if($documents->status == 1)
                {
                    return 'Available';
                }
                else if($documents->status == 2)
                {
                    return 'Draft';
                }
                else if($documents->status == 3)
                {
                    return 'Released';
                }
                else if($documents->status == 4)
                {
                    return 'Incoming';
                }
                else if($documents->status == 5)
                {
                    return 'Received';
                }
                else if($documents->status == 6)
                {
                    return 'Terminal';
                }
                else
                {
                    return 'Returned';
                }
            })
            ->make(true);
    }

    public function returned_documents()
    {
        return view('my_documents.returned_docs');
    }

    public function returned_documents_list()
    {
        $documents = Dts_Records::where('receiving_office', '=', Auth::user()->office_dept)->where('status', 7)->get();

        return DataTables::of($documents)
            ->setRowId('id')
            ->editColumn('status', function($documents){
                return 'Returned';
            })
            ->editColumn('returned_date', function($documents){
                return Carbon::parse($documents->returned_date)->format('M d, Y');

            })
            ->make(true);
    }

    public function add_document_save(Request $request)
    {
        //SAVE TO DTS TABLE
        $save = new Documents;
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

        $save->doc_title = $request->doctitle;
        $save->doc_type = $request->doctype;
        $save->doc_subject = $request->docsubj;
        $save->urgency = $request->urgency;
        $save->remarks = $request->remarks;
        $save->originating_office = Auth::user()->office_dept;
        $save->current_office = Auth::user()->office_dept;
        $save->last_updated_by = Auth::user()->name . $mname . ' ' . Auth::user()->last_name . $suffix;
        $save->status = $request->status;
        $save->latest_transaction = Auth::user()->office_dept;
        $save->save();        

        $number = Documents::where([['originating_office', $save->originating_office],['doc_type', $save->doc_type], ['status', '!=', 8]])->whereYear('created_at', Carbon::now()->year)->count();
        $format = Auth::user()->office_dept.'-'.$save->doc_type.'-'.Carbon::now()->year.'-';

        if ($number<10)
        {
          $save->tracking_number = $format.'00'.$number;
        }
        else if ($number>=10 && $number<100) 
        {
          $save->tracking_number = $format.'0'.$number;
        }
        else
        {
          $save->tracking_number = $format.$number;
        }

        $save->save();

        //Create Folder if it doesnt exist in path file
        if(!File::exists(public_path()."/files/".Auth::user()->office_dept)) 
        {
            File::makeDirectory(public_path()."/files/".Auth::user()->office_dept);
        }

        //SAVE ATTACHED FILES
        
        if($request->has('filename'))
        {

            if(is_array($request->file('filename')))
            {
                foreach($request->file('filename') as $file)
                {


                    $attached_file = new AttachedFiles;

                    $filename = $file->getClientOriginalName();
                    $file->move(public_path().'/files/'.Auth::user()->office_dept, $filename);  // your folder path
                    $attached_file->dts_id = $save->id;
                    $attached_file->from_office = $save->originating_office;
                    $attached_file->filename = $filename;

                    $attached_file->save();
                }
            }
            
        }


        $log = new ActionLogs;
        $log->tracking_number = $save->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Create Document";
        $log->date_of_action = Carbon::now();

        $log->save();

        return redirect()->action([my_documents::class, 'documents_page'])->with('success', 'Successfully Added Document!');

        // dd($save);

    }

    public function edit_document($id)
    {
        $docs = Documents::where('id', $id)->first();
        $files = AttachedFiles::where('dts_id', $id)->get();
        $doctypes = DocumentTypes::all();
        $docsubj = DocumentSubject::all();
        return view('my_documents.Edit_Document')->with(array('docs'=>$docs, 'files'=>$files, 'doctypes'=>$doctypes, 'docsubj'=>$docsubj));
    }

    public function save_edit_doc(Request $request)
    {
        $document = Documents::where('id', $request->doc_id)
                    ->update([
                        'doc_title' => $request->doctitle,
                        'doc_subject' => $request->docsubj,
                        'remarks' => $request->remarks,
                        'status' => $request->status,
                    ]);

        $document_get = Documents::where('id', $request->doc_id)->first();

        if($request->has('filename'))
        {
            if(is_array($request->file('filename')))
            {
                foreach($request->file('filename') as $file)
                {
                    $attached_file = new AttachedFiles;

                    $filename = $file->getClientOriginalName();
                    $file->move(public_path().'/files/'.Auth::user()->office_dept, $filename);  // your folder path
                    $attached_file->dts_id = $request->doc_id;
                    $attached_file->filename = $filename;
                    $attached_file->from_office = $document_get->originating_office;

                    $attached_file->save();
                }
            }
            
        }

        $log = new ActionLogs;
        $log->tracking_number = $document_get->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Edited Document";
        $log->date_of_action = Carbon::now();

        $log->save();

        return redirect()->action([my_documents::class, 'documents_page'])->with('success', 'Successfully Saved Document!');
    }

    public function my_docs_view($id)
    {
        $my_doc = Documents::find($id);

        return Response::json($my_doc);
    }

    public function returned_docs_view($id)
    {
        $returned_doc = Dts_Records::where([['id', $id],['receiving_office', Auth::user()->office_dept]])->first();

        return Response::json($returned_doc);
    }

    public function delete_doc(Request $request)
    {
        $doc = Documents::where('id', $request->delID)->first();
        $doc->status = 8;

        $doc->save();

        $log = new ActionLogs;
        $log->tracking_number = $doc->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Deleted Document";
        $log->date_of_action = Carbon::now();

        $log->save();

        return back()->with('danger', 'Successfully deleted document from list.');
    }

    public function remove_file(Request $request)
    {
        $file = AttachedFiles::find($request->file_id);

        $file->delete();

        $doc = Documents::where('id', $file->dts_id)->first();

        $log = new ActionLogs;
        $log->tracking_number = $doc->tracking_number;
        $log->username = Auth::user()->username;
        $log->action = "Deleted removed attached file of document ".$doc->tracking_number;
        $log->date_of_action = Carbon::now();

        $log->save();

        return back()->with('success', 'Successfully removed attached file!');
    }

    public function track_doc($num)
    {
        $track = Dts_Records::select('receiving_office', 'received_date', 'returned_date','status')->where('tracking_number', $num)->get();

        return Response::json($track);
    }

}
