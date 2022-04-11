<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index()
    {
        $sections= Section::all();
        return view('reports.customers_report',compact('sections'));
    }

    public function searchCustomer(Request $request)
    {
        //في حالة عدم تحديد تاريخ
        if($request->section_id && $request->start_at == '' && $request->end_at == '' )
        {
            if($request->section_id == 'all')
            {
                $invoices=Invoice::get();
                $sections = Section::all();
                return view('reports.customers_report',compact('sections','invoices'));
            }
            $invoices=Invoice::select('*')->where('section_id',$request->section_id)->where('product',$request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report',compact('sections','invoices'));
        }
        // في حالة تحديد تاريخ

        else
         {
            $start_at=date($request->start_at);
            $end_at = date($request->end_at);
            if($request->section_id == 'all')
            {
                $invoices=Invoice::select('*')->whereBetween('invoice_date',[$start_at,$end_at])->get();
                $sections = Section::all();
                return view('reports.customers_report',compact('sections','invoices'));
            }
             $invoices = Invoice::select('*')->whereBetween('invoice_date',[$start_at,$end_at])->where('section_id',$request->section_id)->where('product',$request->product)->get();
             $sections = Section::all();
            return view('reports.customers_report',compact('sections','start_at','end_at','invoices'));

         }
    }
     
}
