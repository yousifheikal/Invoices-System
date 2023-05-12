<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\invoice_attachment;
use App\Models\invoice_detail;
use App\Models\Section;
use App\Models\User;
use App\Notifications\Newinvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\json;
use Illuminate\Support\Facades\Notification;


class InvoiceController extends Controller
{
    function __construct()
    {
        // More Security if you visit a page in website not have permission (User does not have the right permissions.)
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['show']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['printInvoice']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoicesPaid']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['invoicesPartial']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoicesUnpaid']]);
        $this->middleware('permission:ارشيف الفواتير', ['only' => ['showDelete']]);


    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoices = Invoice::all();
        $section = Section::all();
        return view('invoices.invoices', compact('invoices', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        // Using request validate

        //  Insert data coming request in table invoices
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_date,
            'Due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            //Invoices not pay
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);


        $invoice_id = Invoice::latest()->first()->id;

        //  Insert data coming request in table invoices-details
        invoice_detail::create([
            'invoice_number' => $request->invoice_number,
            'id_Invoice' => $invoice_id,
            'product' => $request->product,
            'section' => $request->section,
            //Invoices not pay
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => username(),
        ]);

        //  Insert data coming request in table invoices-attachments
        if ($request->hasFile('pic'))
        {
            $imgae = $request->file('pic')->getClientOriginalName();

            //  Insert data coming request in table invoices-attachments
            invoice_attachment::create([
                'invoice_number' => $request->invoice_number,
                'invoice_id' => $invoice_id,
                'file_name' => $imgae,
                'Created_by' => username(),
            ]);

            // Move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'.$request->invoice_number), $imageName);
        }

        $user = username();
        // Send all users in app exception user create invoice
        $users = User::where('id', '!=', id())->get();
        Notification::send($users, new Newinvoice($user, $invoice_id));
        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $invoice = Invoice::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.status_invoice', compact('invoice', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $invoice = Invoice::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request)
    {
        $id = $request->id;
        // Update data coming request in table invoices
        Invoice::where('id', $id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_date,
            'Due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            //Invoices not pay
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        //  Insert data coming request in table invoices-details
        invoice_detail::where('id_Invoice', $id)->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            //Invoices not pay
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => username(),
        ]);

        //  Insert data coming request in table invoices-attachments
        if ($request->hasFile('pic'))
        {
            $imgae = $request->file('pic')->getClientOriginalName();

            //  Insert data coming request in table invoices-attachments
            invoice_attachment::where('invoice_id', $id)->update([
                'invoice_number' => $request->invoice_number,
                'file_name' => $imgae,
                'Created_by' => username(),
            ]);

            // Move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'.$request->invoice_number), $imageName);
        }

        session()->flash('Add', 'تم تعديل الفاتورة بنجاح');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        // Data coming request u will delete now
        $id = $request->id;
        Invoice::find($id)->delete();
        session()->flash('delete','تم حذف الفاتورة بنجاح');
        return redirect()->back();
    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function showDelete()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.soft_delete', compact('invoices'));
    }

    public function restore($id)
    {
        $invoices = Invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('Add','تم استرجاع الفاتورة بنجاح');
        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $invoices = Invoice::withTrashed()->where('id', $id)->forceDelete();
//        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete','تم حذف الفاتورة نهائيا');
        return redirect()->back();
    }

    public function changeStatus(Request $request, $id)
    {
        $invoice = Invoice::findorFail($id);

        if ($request->status == "مدفوعة")
        {
            $invoice->update([
                'value_status' => 1,
                'Status' => $request->status,
                'Payment_date' => $request->Payment_date,
            ]);

            //  Insert new coulmn in invoice_detail (change status of payment)
            invoice_detail::create([
                'invoice_number' => $request->invoice_number,
                'id_Invoice' => $invoice->id,
                'product' => $request->product,
                'section' => $request->section,
                //Invoices not pay
                'Status' => $request->status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_date,
                'note' => $request->note,
                'user' => username(),
            ]);
        }
        elseif ($request->status === "مدفوعة جزائيا")
        {
            $invoice->update([
                'value_status' => 3,
                'Status' => $request->status,
                'Payment_date' => $request->Payment_date,
            ]);

            //  Insert new coulmn in invoice_detail (change status of payment)
            invoice_detail::create([
                'invoice_number' => $request->invoice_number,
                'id_Invoice' => $invoice->id,
                'product' => $request->product,
                'section' => $request->section,
                //Invoices not pay
                'Status' => $request->status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_date,
                'note' => $request->note,
                'user' => username(),
            ]);
        }
        session()->flash('Add','تم تغير حالة الفاتورة بنجاح');
        return redirect()->back();
    }

    public function invoicesPaid()
    {
        $invoices = Invoice::where('value_status' , 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function invoicesPartial()
    {
        $invoices = Invoice::where('value_status' , 3)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }


    public function invoicesUnpaid()
    {
        $invoices = Invoice::where('value_status' , 2)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function printInvoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.invoice_print', compact('invoices'));
    }

    public function markAsRead()
    {
        $user = User::find(id());
        foreach ($user->unreadNotifications as $notification)
        {
            $notification->markAsRead();
        }
        return redirect()->back();
    }
}
