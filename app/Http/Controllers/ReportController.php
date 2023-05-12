<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index()
    {
//        $details = Invoice::all();
        return view('reports.index');
    }

    public function Search_invoices(Request $request)
    {
        $rdio = $request->rdio;

        if ($rdio == 1)
        {
            // في حالة البحث بنوع الفاتورة
            if ($request->type && $request->start_at ==''  && $request->end_at=='')
            {
                // في حالة عدم تحديد تاريخ
                $type = $request->type;
                $invoices = Invoice::select('*')->where('Status', $type)->get();
                return view('reports.index', compact('type'))->withDetails($invoices);
            }
            else
            {
                // في حالة تحديد تاريخ استحقاق
                $start = date($request->start_at);
                $end = date($request->end_at);
                $type = $request->type;

                $invoices = Invoice::whereBetween('invoice_Date', [$start, $end])->where('Status', $type)->get();
                return view('reports.index', compact('type', 'start', 'end'))->withDetails($invoices);
            }

        }
        else
        {
            // في البحث برقم الفاتورة
            $invoice = Invoice::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.index')->withDetails($invoice);
        }

    }
}
