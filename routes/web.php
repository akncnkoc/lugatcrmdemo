<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomingWaybillController;
use App\Http\Controllers\OutgoingWaybillController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\SafeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffPaymentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPaymentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/incoming_waybill', [IncomingWaybillController::class, 'index'])->name('incoming-waybill.index');
Route::get('/product/outgoing_waybill', [OutgoingWaybillController::class, 'index'])->name('outgoing-waybill.index');
Route::get('/product/{product_id?}/log', [ProductLogController::class, 'index'])->name('product.log.index');
Route::get('/product/{product_id?}/report', [ProductReportController::class, 'index'])->name('product.report.index');
Route::get('/safe', [SafeController::class, 'index'])->name('safe.index');
Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/{supplier_id?}/payment', [SupplierPaymentController::class, 'index'])->name('supplier.payment.index');
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/{id?}/payment', [StaffPaymentController::class, 'index'])->name('staff.payment.index');
Route::get('/roleandtype', fn() => view('pages.roleandtype.index'))->name('roleandtype.index');
