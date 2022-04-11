<?php

namespace App\Http\Controllers;

use File;
use App\Traits\InvoiceTrait;
use Illuminate\Http\Request;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    use InvoiceTrait;

    function __construct()
    {
         
         $this->middleware('permission: اضافة مرفق', ['only' => ['store']]);
         $this->middleware('permission:حذف مرفق', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [

            'pic' => 'mimes:pdf,jpeg,png,jpg',
    
            ], [
                'pic.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]);
            $invoice_number = $request->invoice_number;
            $invoice_id     = $request->invoice_id;
            // Move Img to folder attavhments 
            $name = $this->saveImage ($request->file('pic') ,'Attachments/' . $invoice_number);
           
            InvoiceAttachment::create([
                'file_name' => $name,
                'invoice_number' => $invoice_number,
                'invoice_id' => $invoice_id,
                'created_by'    =>  Auth::user()->name,
            ]);
            session()->flash('Add', 'تم اضافة المرفق  بنجاح');
            return back();
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = InvoiceAttachment::findOrFail($request->id_file);
        $invoices->delete();
        unlink(public_path('Attachments/'.$request->invoice_number.'/'.$request->file_name));
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

     public function get_file($invoice_number,$file_name)

    {
    
        return response()->download( public_path('Attachments/'.$invoice_number.'/'.$file_name));
    }



    public function open_file($invoice_number,$file_name)

    {
        
        return response()->file(public_path('Attachments/'.$invoice_number.'/'.$file_name));
    }

}
