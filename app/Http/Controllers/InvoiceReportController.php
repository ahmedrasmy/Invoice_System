<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view('reports.invoices_report');
    }

    public function searchInvoice(Request $request)
    {
       
        $rdio=$request->rdio;
        // في حالة البحث بنوع الفاتورة
        if($rdio == 1)
        {
            // في حالة لم يحدد تاريخ 
            if($request->type && $request->start_at == '' && $request->end_at == '')
            {
                if($request->type == 'all')
                {
                    $invoices = Invoice::all();
                    $type=$request->type;
                    return view('reports.invoices_report',compact('type','invoices'));
                }
                $invoices = Invoice::select('*')->where('status',$request->type)->get();
                $type=$request->type;
                return view('reports.invoices_report',compact('type','invoices'));
            }
            // في حالة تحديد التاريخ
            else
            {
                $start_at=date($request->start_at);
                $end_at=date($request->end_at);
                if($request->type == 'all')
                {
                    $invoices = Invoice::select('*')->whereBetween('invoice_date',[ $start_at,$end_at])->get();
                    $type=$request->type;
                    return view('reports.invoices_report',compact('type','start_at','end_at','invoices'));
                }
                $invoices = Invoice::select('*')->whereBetween('invoice_date',[ $start_at,$end_at])->where('status',$request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report',compact('type','start_at','end_at','invoices'));

            }   

        }
        // في حالة البحث برقم الفاتورة
        else
        {
            $invoice_number=$request->invoice_number;
            $invoices = Invoice::select('*')->where('invoice_number',$invoice_number)->get();
            return view('reports.invoices_report',compact('invoices'));
        }
    }
}
