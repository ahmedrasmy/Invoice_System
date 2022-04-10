<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();
// Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', 'App\Http\Controllers\InvoiceController');
Route::post('update_invoice/{id}','App\Http\Controllers\InvoiceController@update')->name('invoices.update');
Route::get('invoices_paid','App\Http\Controllers\InvoiceController@invoicePaid')->name('invoices.paid');
Route::get('invoices_partial','App\Http\Controllers\InvoiceController@invoicePartial')->name('invoices.partial');
Route::get('invoices_unpaid','App\Http\Controllers\InvoiceController@invoiceUnpaid')->name('invoices.unpaid');
Route::get('print_invoice/{id}','App\Http\Controllers\InvoiceController@printInvoice')->name('print_invoice');
Route::get('export_invoices', [InvoiceController::class, 'export']);
Route::post('delete_invoice','App\Http\Controllers\InvoiceController@destory')->name('invoices.destory');
Route::get('status/show/{id}','App\Http\Controllers\InvoiceController@show')->name('status.show');
Route::post('status/update/{id}','App\Http\Controllers\InvoiceController@statusUpdate')->name('status.update');
Route::resource('sections', 'App\Http\Controllers\SectionController');

Route::resource('products', 'App\Http\Controllers\ProductController');

Route::resource('archive','App\Http\Controllers\ArchiveInvoiceController');

Route::get('section/{id}','App\Http\Controllers\InvoiceController@getProducts');

Route::get('details/{id}','App\Http\Controllers\InvoiceController@fullDetails')->name('invoices.details');

Route::get('download/{invoice_number}/{file_name}', 'App\Http\Controllers\InvoiceAttachmentController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'App\Http\Controllers\InvoiceAttachmentController@open_file');

Route::post('delete_file', 'App\Http\Controllers\InvoiceAttachmentController@destroy')->name('delete_file');

Route::resource('InvoiceAttachments', 'App\Http\Controllers\InvoiceAttachmentController');


Route::get('/{page}', 'App\Http\Controllers\AdminController@index');
