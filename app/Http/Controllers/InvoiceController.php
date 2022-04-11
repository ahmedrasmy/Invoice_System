<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use App\Traits\InvoiceTrait;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\InvoiceAttachment;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\StoreInvoiceStatusRequest;

class InvoiceController extends Controller
{
    use InvoiceTrait;

    function __construct()
    {
         $this->middleware('permission:قائمة الفواتير', ['only' => ['index','fullDetails']]);
         $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoicePaid']]);
         $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['invoicePartial']]);
         $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoiceUnpaid']]);
         $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store','getProducts']]);
         $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
         $this->middleware('permission:تغير حالة الدفع', ['only' => ['statusUpdate']]);
         $this->middleware('permission:طباعةالفاتورة', ['only' => ['printInvoice']]);
         $this->middleware('permission:تصدير EXCEL', ['only' => ['export']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=Invoice::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections=Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        InvoiceDetail::create([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section_id' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $invoice_number = $request->invoice_number;
            // Move Img to folder uplpads books 
            $name = $this->saveImage ($request->file('pic') ,'Attachments/' . $invoice_number);
           
            InvoiceAttachment::create([
                'file_name' => $name,
                'invoice_number' => $invoice_number,
                'invoice_id' => $invoice_id,
                'created_by'    =>  Auth::user()->name,
            ]);
            
        }

        // send message to user
        $user = User::first();
        Notification::send($user,new AddInvoice($invoice_id));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices =Invoice::findOrFail($id);
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();

        return view('invoices.edit_invoice',compact('invoice','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInvoiceRequest $request, $id)
    {
        $invoice =Invoice::findOrFail($id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);
        $invoiceDetail=InvoiceDetail::where('id_invoice',$id)->first();
        $invoiceDetail->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section_id' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id =$request->invoice_id;
        $invoice =Invoice::where('id',$id)->first();
        $invoiceAttachment =InvoiceAttachment::where('invoice_id',$id)->first();
        $id_page=$request->id_page;

        if(!$id_page == 2)
        {
            if(!empty($invoiceAttachment->invoice_number))
                {
                    $file = new Filesystem;
                    $file->deleteDirectory(public_path('Attachments/'.$invoiceAttachment->invoice_number));
                
                }
            $invoice->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        }
        else 
        {
            $invoice->delete();
            session()->flash('archive_invoice');
            return redirect('/archive');
        }
        
    }
    public function getProducts($id){
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);

    }
    public function fullDetails($id){
        $invoice=Invoice::where('id',$id)->first();
        $invoiceDetails = InvoiceDetail::where('id_invoice',$id)->get();
        $invoiceAttachment = InvoiceAttachment::where('invoice_id',$id)->get();
        return view('invoices.detail_invoice',compact('invoice','invoiceDetails','invoiceAttachment'));
    }

    public function statusUpdate(StoreInvoiceStatusRequest $request,$id){
      
       $invoice=Invoice::findOrFail($id);

       if($request->status === 'مدفوعة'){
            $invoice->update([
                'value_status'=> 1,
                'status' => $request->status,
                'payment_date' =>$request->payment_date,
            ]);
            InvoiceDetail::create([
                'id_invoice'=>$id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section_id' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
       }
       else {
        $invoice->update([
            'value_status' => 3,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
        ]);
        InvoiceDetail::create([
            'id_invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section_id' => $request->section,
            'status' => $request->status,
            'value_status' => 3,
            'note' => $request->note,
            'payment_date' => $request->payment_date,
            'user' => (Auth::user()->name),
        ]);
    }
    session()->flash('Status_Update');
    return redirect('/invoices');
       
    }

    public function invoicePaid(){
        $invoices=Invoice::where('value_status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }
    public function invoiceUnpaid(){
        $invoices=Invoice::where('value_status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }
    public function invoicePartial(){
        $invoices=Invoice::where('value_status',3)->get();
        return view('invoices.invoices_partial',compact('invoices'));
    }
    public function printInvoice($id){
        $invoice=Invoice::findOrFail($id);
        return view('invoices.print_invoice',compact('invoice'));
    }
    public function export() 
    {
        
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
}
