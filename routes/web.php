<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Routes for InvoicesController
Route::resource('invoices', InvoiceController::class);
Route::post('changeStatus/{id}', [InvoiceController::class, 'changeStatus'])->name('change.status');
Route::get('invoicesPaid', [InvoiceController::class, 'invoicesPaid'])->name('invoices.paid');
Route::get('invoicesPartial', [InvoiceController::class, 'invoicesPartial'])->name('invoices.partial');
Route::get('invoicesUnpaid', [InvoiceController::class, 'invoicesUnpaid'])->name('invoices.unpaid');
Route::get('printInvoice/{id}', [InvoiceController::class, 'printInvoice'])->name('invoices.print');
Route::get('markRead', [InvoiceController::class, 'markAsRead'])->name('mark.read');


// Routes for InvoicesController (Soft-Delete)
Route::get('showDelete', [InvoiceController::class, 'showDelete'])->name('show.delete');
Route::get('restore/{id}', [InvoiceController::class, 'restore'])->name('restore.data');
Route::get('forceDelete/{id}', [InvoiceController::class, 'forceDelete'])->name('deleting.data');

// Route for InvoicesController (AJAX)
Route::get('/section/{id}', [InvoiceController::class, 'getProducts'])->name('section.getProducts');

// Route for SectionController
Route::resource('sections', SectionController::class);

//Routes for ProductsController
Route::resource('products', ProductController::class);

//Route for func edit in invoices-details
Route::get('invoices_details/{id}', [InvoiceDetailController::class,'edit'])->name('invoice.details');

//Route to show file in invoices-details
Route::get('View_file/{invoice_number}/{file_name}', [InvoiceDetailController::class,'open_file']);

//Route to download file in invoices-details
Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailController::class,'download_file']);

// Route for InvoiceDetailController
Route::post('invoices_details/delete_file', [InvoiceDetailController::class, 'destroy'])->name('delete_file');

// Route for InvoiceAttachmentController
Route::resource('InvoiceAttachment', InvoiceAttachmentController::class);

// Route for ReportController
Route::get('invoices_report', [ReportController::class, 'index'])->name('invoices.report');
Route::post('Search_invoices', [ReportController::class, 'Search_invoices'])->name('search.invoice');

// Route for ReportCustomerController
Route::get('customer_report', [CustomerReportController::class, 'index'])->name('customer.report');
Route::post('Search_customer', [CustomerReportController::class, 'Search_customer'])->name('Search.customer');

// Authentication
Route::get('/dashboard', function () {
//=================احصائية نسبة تنفيذ الحالات======================



    $count_all =Invoice::count();
    $count_invoices1 = Invoice::where('value_status', 1)->count();
    $count_invoices2 = Invoice::where('value_status', 2)->count();
    $count_invoices3 = Invoice::where('value_status', 3)->count();

    if($count_invoices2 == 0){
        $nspainvoices2=0;
    }
    else{
        $nspainvoices2 = $count_invoices2/ $count_all*100;
    }

    if($count_invoices1 == 0){
        $nspainvoices1=0;
    }
    else{
        $nspainvoices1 = $count_invoices1/ $count_all*100;
    }

    if($count_invoices3 == 0){
        $nspainvoices3=0;
    }
    else{
        $nspainvoices3 = $count_invoices3/ $count_all*100;
    }


    $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 100, 'height' => 50])
        ->labels(['الفواتير المدفوعة', 'الفواتير المدفوعة جزائيا','الفواتير الغير مدفوعة'])
        ->datasets([
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#81b214'],
                'borderColor' => ['#81b214'],
                'start' => 0,
                'data' => [$nspainvoices1]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#ff9642'],
                'data' => [$nspainvoices3]

            ],
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$nspainvoices2]
            ],


        ])
        ->options([]);


    $chartjs_2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 340, 'height' => 200])
        ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                'data' => [$nspainvoices2, $nspainvoices1,$nspainvoices3]
            ]
        ])
        ->options([]);
    return view('dashboard', compact('chartjs', 'chartjs_2'));
})->middleware(['auth', 'verified', 'status'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profiles', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes for All User & Roles and Permissions
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
});

require __DIR__.'/auth.php';

// Dashboard
Route::get('/{page}', [AdminController::class, 'index']);
