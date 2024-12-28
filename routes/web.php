<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesAttatchmentController;
use App\Http\Controllers\Invoices_ArshifeController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Mail\emailsend;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
//Auth::routes(['register'=> false]); دي بقا لو انا عاوز الغي حتة الريجستر دي يعني مثلا دي شركة ومينفعش مستخدمين يعملو ريجستر وكدا



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('section', SectionController::class);

Route::resource('product',ProductController::class);

Route::resource('invoices', InvoiceController::class);
 Route::delete('invoices.destroy', [InvoiceController::class,'destroy'])->name('invoices.destroy');

Route::get('/section/{id}', [InvoiceController::class, 'getproducts']);

Route::get('/invoicesdetalis/{id}', [InvoicesDetailsController::class, 'edit'])->name('invoicesdetalis');
// الي جاي دا عشان عاوز اعرض الفايل  هديلة رقم الفاتورة الي فيها الفايل واسم الفايل
Route::get('/View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::get('/download_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::post('InvoiceAttachments', [InvoicesAttatchmentController::class, 'store']);

Route::get('edit_invoice/{id}', [InvoiceController::class, 'edit']);
Route::get('export', [InvoiceController::class, 'export']);
Route::get('status_invoice/{id}', [InvoiceController::class, 'show']);
Route::post('status_update/{id}', [InvoiceController::class, 'status_update'])->name('status_update');

Route::get('paid_invoices', [InvoiceController::class,'paid_invoices'])->name('paid_invoices');
Route::get('Partially_paid_invoices', [InvoiceController::class,'Partially_paid_invoices'])->name('Partially_paid_invoices');
Route::get('unpaid_invoices', [InvoiceController::class,'unpaid_invoices'])->name('unpaid_invoices');
Route::get('Print_invoice/{id}', [InvoiceController::class,'Print_invoice'])->name('Print_invoice');

Route::resource('arshive',Invoices_ArshifeController::class);


Route::group(['middleware' => ['auth']], function() {
    
    Route::resource('roles',RoleController::class);
    
    Route::resource('users',UserController::class);
    
});

Route::get('invoices_report', [Invoices_ReportController::class,'index'])->name('invoices_report');
Route::post('Search_invoices', [Invoices_ReportController::class,'Search_invoices'])->name('Search_invoices');

Route::get('customer_reports', [Customers_ReportController::class,'index'])->name('customer_reports');
Route::post('Search_customers', [Customers_ReportController::class,'Search_customers'])->name('Search_customers');

Route::get('markAsReadALL', [InvoiceController::class,'markAsReadALL'])->name('markAsReadALL');
Route::get('showIvoi_and_MarkRead/{id}', [InvoiceController::class,'showIvoi_and_MarkRead'])->name('showIvoi_and_MarkRead');






Route::get('/{page}', [AdminController::class,'index']);//تحت اي حاجة // 
