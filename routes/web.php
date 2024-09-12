<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'prevent-back-history'],function(){

	Auth::routes();

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/my_documents', [App\Http\Controllers\my_documents::class, 'documents_page']);
    Route::get('/my_documents_list', [App\Http\Controllers\my_documents::class, 'my_documents_list']); //Documents released by originating office
    Route::get('/document_info/{id}', [App\Http\Controllers\my_documents::class, 'document_info']);
    Route::get('/uploaded_files/{id}', [App\Http\Controllers\my_documents::class, 'uploaded_files']);
    Route::get('/edit_document/{id}', [App\Http\Controllers\my_documents::class, 'edit_document']);
    Route::get('/my_docs_view/{id}', [App\Http\Controllers\my_documents::class, 'my_docs_view']);
    Route::get('/track_doc/{num}', [App\Http\Controllers\my_documents::class, 'track_doc']);
    Route::get('/returned_documents', [App\Http\Controllers\my_documents::class, 'returned_documents']);
    Route::get('/returned_documents_list', [App\Http\Controllers\my_documents::class, 'returned_documents_list']);
    Route::get('returned_docs_view/{id}', [App\Http\Controllers\my_documents::class, 'returned_docs_view']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/add_doc', [App\Http\Controllers\my_documents::class, 'add_document_page']);
    Route::post('/save_add_doc', [App\Http\Controllers\my_documents::class, 'add_document_save']);
    Route::post('/save_edit_doc', [App\Http\Controllers\my_documents::class, 'save_edit_doc']);
    Route::post('/delete_doc', [App\Http\Controllers\my_documents::class, 'delete_doc']);
    Route::post('/remove_file', [App\Http\Controllers\my_documents::class, 'remove_file']);
    
    Route::get('/pending', [App\Http\Controllers\docs_pending::class, 'pending_page']);
    Route::get('/pending_list', [App\Http\Controllers\docs_pending::class, 'pending_list']);
    Route::get('pending_doc_view/{id}', [App\Http\Controllers\docs_pending::class, 'pending_doc_view']);
    Route::post('/release_document', [App\Http\Controllers\docs_pending::class, 'release_document']);
    Route::post('/release_received_doc', [App\Http\Controllers\docs_pending::class, 'release_received_doc']);

    Route::get('/incoming', [App\Http\Controllers\docs_incoming::class, 'incoming_page']);
    Route::get('/incoming_list', [App\Http\Controllers\docs_incoming::class, 'incoming_list']);
    Route::get('/doc_view/{id}', [App\Http\Controllers\docs_incoming::class, 'doc_view']);
    Route::get('/attached_files/{id}', [App\Http\Controllers\docs_incoming::class, 'attached_files']);
    Route::post('/receive_document', [App\Http\Controllers\docs_incoming::class, 'receive_document']);
    Route::post('/return_document', [App\Http\Controllers\docs_incoming::class, 'return_document']);

    Route::get('/received', [App\Http\Controllers\docs_received::class, 'received_page']);
    Route::get('/received_list', [App\Http\Controllers\docs_received::class, 'received_list']);
    Route::get('/qr_scanner', [App\Http\Controllers\docs_received::class, 'qr_scanner']);

    Route::get('/terminal', [App\Http\Controllers\docs_terminal::class, 'terminal_page']);
    Route::get('/terminal_list', [App\Http\Controllers\docs_terminal::class, 'terminal_list']);
    Route::get('/terminal_remarks_list/{id}', [App\Http\Controllers\docs_terminal::class, 'terminal_remarks_list']);
    Route::get('/terminal_returned_remarks_list/{id}', [App\Http\Controllers\docs_terminal::class, 'terminal_returned_remarks_list']);

    Route::get('/users', [App\Http\Controllers\HomeController::class, 'users']);
    Route::get('/list_of_users', [App\Http\Controllers\HomeController::class, 'list_of_users']);
    Route::post('/register_user', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::post('/edit_user', [App\Http\Controllers\Auth\RegisterController::class, 'edit_user']);
    Route::post('/change_password', [App\Http\Controllers\Auth\RegisterController::class, 'change_password']);

    //Pages for Admins and Super Admins only
    Route::group(['middleware' => 'check-user'], function(){
        Route::get('/Qr', [App\Http\Controllers\QrController::class, 'QrGenerate_page']);
        Route::get('/qr_office_list/{id}', [App\Http\Controllers\QrController::class, 'qr_office_list']);
        Route::get('/generate_for/{id}', [App\Http\Controllers\QrController::class, 'generate_for']);
        Route::get('/assign_qr', [App\Http\Controllers\QrController::class, 'assign_qr_page']);
        Route::get('/list_of_qr/{office}', [App\Http\Controllers\QrController::class, 'list_of_qr']);
        Route::post('/assign_new_qr_series', [App\Http\Controllers\QrController::class, 'assign_new_qr_series']);
        Route::get('/print_qr_series/{series}/{office}', [App\Http\Controllers\QrController::class, 'print_qr_series']);
    });    

    Route::get('/remaining_qr/{office}', [App\Http\Controllers\QrController::class, 'remaining_qr']);
    Route::get('/available_qr/{office}', [App\Http\Controllers\QrController::class, 'available_qr']);
    Route::get('/receive_qr/{qr_code}', [App\Http\Controllers\QrController::class, 'receive_qr']);
    Route::post('/receive_submit', [App\Http\Controllers\QrController::class, 'receive_submit']);
    Route::get('/QrPage', [App\Http\Controllers\QrController::class, 'QrPage']);

    Route::get('/submit_sms', [App\Http\Controllers\docs_incoming::class, 'submit_sms']);

    Route::post ('/track_doc', [App\Http\Controllers\HomeController::class, 'track_doc']); 

    Route::get('/floor/{id}', [App\Http\Controllers\HomeController::class, 'floor']);

    Route::get('/test', [App\Http\Controllers\HomeController::class, 'test']);

    //Pages for the City Mayor only
    Route::group(['middleware' => 'mayor-only'], function(){
        Route::get('/mayors_page', [App\Http\Controllers\HomeController::class, 'mayors_index'])->name('mayors_page');
        Route::post('/approval', [App\Http\Controllers\HomeController::class, 'mayors_approval']);
        Route::get('/list_approved', [App\Http\Controllers\HomeController::class, 'list_approved']);
        Route::get('/mayors_approved_list', [App\Http\Controllers\docs_received::class, 'mayors_approved_list']);
        Route::get('/mayors_for_review', [App\Http\Controllers\docs_received::class, 'mayors_for_review']);
    });

    Route::get('/edit_profile', [App\Http\Controllers\HomeController::class, 'edit_profile']);
    Route::post('/edit_save', [App\Http\Controllers\HomeController::class, 'edit_save']);
    Route::post('/change_pass_save', [App\Http\Controllers\HomeController::class, 'change_pass_save']);

    Route::get('/testing_route', [App\Http\Controllers\HomeController::class, 'testing_route']);
    Route::get('/mayors_payroll_receive/{id}', [App\Http\Controllers\docs_incoming::class, 'mayors_payroll_receive']);
    Route::get('/forward_office/{id}', [App\Http\Controllers\docs_incoming::class, 'forward_offices']);

});
