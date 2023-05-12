<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use Illuminate\Http\Request;

class InvoiceAttachmentController extends Controller
{
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
        // Validate data coming request
        $validate = $request->validate([
            'file_name' => 'required|mimes:pdf,jpeg,jpg,png',
        ],
            [
                // Type of error u wants show
                'file_name.required' =>'يرجي ادخال مرفق',
                'file_name.mimes' =>'صيغة المرفقة يجب ان تكون pdf - jpeg - jpg - png',
            ]);

        // Change Name of attachment
        $image = $request->file('file_name')->getClientOriginalName();

        // Data coming form will insert in DB Table InvoiceAttachmentController
        $attachment = new invoice_attachment();
        $attachment->file_name = $image;
        $attachment->invoice_number = $request->invoice_number;
        $attachment->Created_by = username();
        $attachment->invoice_id = $request->invoice_id;
        $attachment->save();

        // Move attachment in Dir Public
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'.$request->invoice_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

    }
}
