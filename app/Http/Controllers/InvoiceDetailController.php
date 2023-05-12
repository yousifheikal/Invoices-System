<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachment;
use App\Models\invoice_detail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{

    function __construct()
    {
        // More Security if you visit a page in website not have permission (User does not have the right permissions.)
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $invoices = Invoice::where('id', $id)->first();
        $details = invoice_detail::where('id_Invoice', $id)->get();
        $attachments = invoice_attachment::where('invoice_id', $id)->get();
        return view('invoices.invoices_details', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Data coming request u will delete now
        $invoices = invoice_attachment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function open_file($invoice_number, $file_name)
    {
        //  First Solution
        $dir="Attachments";
        $file = public_path($dir.'/'.$invoice_number.'/'.$file_name);
        return response()->file($file);

        // Second Solution
//        $file = Storage::disk('public_uploads')->get($invoice_number.'/'.$file_name);
    }

    public function download_file($invoice_number, $file_name)
    {

        $file = Storage::disk('public_uploads')->download($invoice_number.'/'.$file_name);
        return $file;
    }
}
