<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    //

    public function index()
    {
        $sections = Section::all();
        return view('reports.customer_report', compact('sections'));
    }

    public function Search_customer(Request $request)
    {

        if ($request->Section && $request->product && $request->start_at=='' && $request->end_at=='')
        {
            $sections = Section::all();
            $invoices = Invoice::select('*')->where('section_id', $request->Section)->where('product', $request->product)->get();

            return view('reports.customer_report', compact('sections'))->withDetails($invoices);
        }
        else
        {
            $start = date($request->start_at);
            $end = date($request->end_at);
            $sections = Section::all();

            $invoices = Invoice::whereBetween('invoice_Date', [$start, $end])->where('section_id', $request->Section)
                ->where('product', $request->product)->get();

            return view('reports.customer_report', compact('sections', 'start', 'end'))->withDetails($invoices);
        }

    }
}
