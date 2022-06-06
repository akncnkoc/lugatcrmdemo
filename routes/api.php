<?php

use Illuminate\Support\Facades\Route;

Route::prefix('expense')->group(function () {
  Route::post('table', [\App\Http\Controllers\ExpenseController::class, 'table'])->name('expense.table');
  Route::post('get', [\App\Http\Controllers\ExpenseController::class, 'get'])->name('expense.get');
  Route::post('store', [\App\Http\Controllers\ExpenseController::class, 'store'])->name('expense.store');
  Route::post('update', [\App\Http\Controllers\ExpenseController::class, 'update'])->name('expense.update');
  Route::post('delete', [\App\Http\Controllers\ExpenseController::class, 'delete'])->name('expense.delete');
});
Route::prefix('product')->group(function () {
  Route::post('table', [\App\Http\Controllers\ProductController::class, 'table'])->name('product.table');
  Route::post('select', [\App\Http\Controllers\ProductController::class, 'select'])->name('product.select');
  Route::post('get', [\App\Http\Controllers\ProductController::class, 'get'])->name('product.get');
  Route::post('store', [\App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
  Route::post('update', [\App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
  Route::post('delete', [\App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');
});

Route::prefix('product_log')->group(function () {
  Route::post('table/{product_id?}', [\App\Http\Controllers\ProductLogController::class, 'table'])->name('product_log.table');
});

Route::prefix('incoming_waybill')->group(function () {
  Route::post('get', [\App\Http\Controllers\IncomingWaybillController::class, 'get'])->name('incoming-waybill.get');
  Route::post('table', [\App\Http\Controllers\IncomingWaybillController::class, 'table'])->name('incoming-waybill.table');
  Route::post('store', [\App\Http\Controllers\IncomingWaybillController::class, 'store'])->name('incoming-waybill.store');
  Route::post('update', [\App\Http\Controllers\IncomingWaybillController::class, 'update'])->name('incoming-waybill.update');
  Route::post('delete', [\App\Http\Controllers\IncomingWaybillController::class, 'delete'])->name('incoming-waybill.delete');
});

Route::prefix('outgoing_waybill')->group(function () {
  Route::post('get', [\App\Http\Controllers\OutgoingWaybillController::class, 'get'])->name('outgoing-waybill.get');
  Route::post('table', [\App\Http\Controllers\OutgoingWaybillController::class, 'table'])->name('outgoing-waybill.table');
  Route::post('store', [\App\Http\Controllers\OutgoingWaybillController::class, 'store'])->name('outgoing-waybill.store');
  Route::post('update', [\App\Http\Controllers\OutgoingWaybillController::class, 'update'])->name('outgoing-waybill.update');
  Route::post('delete', [\App\Http\Controllers\OutgoingWaybillController::class, 'delete'])->name('outgoing-waybill.delete');
});

Route::prefix('expense_type')->group(function () {
  Route::post('get', [\App\Http\Controllers\ExpenseTypeController::class, 'get'])->name('expense_type.get');
  Route::post('all', [\App\Http\Controllers\ExpenseTypeController::class, 'all'])->name('expense_type.all');
  Route::post('select', [\App\Http\Controllers\ExpenseTypeController::class, 'select'])->name('expense_type.select');
  Route::post('store', [\App\Http\Controllers\ExpenseTypeController::class, 'store'])->name('expense_type.store');
  Route::post('update', [\App\Http\Controllers\ExpenseTypeController::class, 'update'])->name('expense_type.update');
  Route::post('delete', [\App\Http\Controllers\ExpenseTypeController::class, 'delete'])->name('expense_type.delete');
});

Route::prefix('product_type')->group(function () {
  Route::post('get', [\App\Http\Controllers\ProductTypeController::class, 'get'])->name('product_type.get');
  Route::post('all', [\App\Http\Controllers\ProductTypeController::class, 'all'])->name('product_type.all');
  Route::post('select', [\App\Http\Controllers\ProductTypeController::class, 'select'])->name('product_type.select');
  Route::post('store', [\App\Http\Controllers\ProductTypeController::class, 'store'])->name('product_type.store');
  Route::post('update', [\App\Http\Controllers\ProductTypeController::class, 'update'])->name('product_type.update');
  Route::post('delete', [\App\Http\Controllers\ProductTypeController::class, 'delete'])->name('product_type.delete');
});

Route::prefix('customer_role')->group(function () {
  Route::post('get', [\App\Http\Controllers\CustomerRoleController::class, 'get'])->name('customer_role.get');
  Route::post('all', [\App\Http\Controllers\CustomerRoleController::class, 'all'])->name('customer_role.all');
  Route::post('select', [\App\Http\Controllers\CustomerRoleController::class, 'select'])->name('customer_role.select');
  Route::post('store', [\App\Http\Controllers\CustomerRoleController::class, 'store'])->name('customer_role.store');
  Route::post('update', [\App\Http\Controllers\CustomerRoleController::class, 'update'])->name('customer_role.update');
  Route::post('delete', [\App\Http\Controllers\CustomerRoleController::class, 'delete'])->name('customer_role.delete');
});

Route::prefix('staff_role')->group(function () {
  Route::post('get', [\App\Http\Controllers\StaffRoleController::class, 'get'])->name('staff_role.get');
  Route::post('all', [\App\Http\Controllers\StaffRoleController::class, 'all'])->name('staff_role.all');
  Route::post('select', [\App\Http\Controllers\StaffRoleController::class, 'select'])->name('staff_role.select');
  Route::post('store', [\App\Http\Controllers\StaffRoleController::class, 'store'])->name('staff_role.store');
  Route::post('update', [\App\Http\Controllers\StaffRoleController::class, 'update'])->name('staff_role.update');
  Route::post('delete', [\App\Http\Controllers\StaffRoleController::class, 'delete'])->name('staff_role.delete');
});

Route::prefix('safe')->group(function () {
  Route::post('select', [\App\Http\Controllers\SafeController::class, 'select'])->name('safe.select');
  Route::post('table', [\App\Http\Controllers\SafeController::class, 'table'])->name('safe.table');
  Route::post('get', [\App\Http\Controllers\SafeController::class, 'get'])->name('safe.get');
  Route::post('store', [\App\Http\Controllers\SafeController::class, 'store'])->name('safe.store');
  Route::post('update', [\App\Http\Controllers\SafeController::class, 'update'])->name('safe.update');
  Route::post('delete', [\App\Http\Controllers\SafeController::class, 'delete'])->name('safe.delete');
});

Route::prefix('customer')->group(function () {
  Route::post('get', [\App\Http\Controllers\CustomerController::class, 'get'])->name('customer.get');
  Route::post('table', [\App\Http\Controllers\CustomerController::class, 'table'])->name('customer.table');
  Route::post('select', [\App\Http\Controllers\CustomerController::class, 'select'])->name('customer.select');
  Route::post('store', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
  Route::post('update', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
  Route::post('delete', [\App\Http\Controllers\CustomerController::class, 'delete'])->name('customer.delete');
});

Route::prefix('supplier')->group(function () {
  Route::post('get', [\App\Http\Controllers\SupplierController::class, 'get'])->name('supplier.get');
  Route::post('select', [\App\Http\Controllers\SupplierController::class, 'select'])->name('supplier.select');
  Route::post('table', [\App\Http\Controllers\SupplierController::class, 'table'])->name('supplier.table');
  Route::post('store', [\App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
  Route::post('update', [\App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
  Route::post('delete', [\App\Http\Controllers\SupplierController::class, 'delete'])->name('supplier.delete');
});
Route::prefix('supplier-payment')->group(function () {
  Route::post('get/{id?}', [\App\Http\Controllers\SupplierPaymentController::class, 'get'])->name('supplier-payment.get');
  Route::post('table/{supplier_id?}', [\App\Http\Controllers\SupplierPaymentController::class, 'table'])->name('supplier-payment.table');
  Route::post('store/{id?}', [\App\Http\Controllers\SupplierPaymentController::class, 'store'])->name('supplier-payment.store');
  Route::post('update/{payment_id?}', [\App\Http\Controllers\SupplierPaymentController::class, 'update'])->name('supplier-payment.update');
  Route::post('delete/{payment_id?}', [\App\Http\Controllers\SupplierPaymentController::class, 'delete'])->name('supplier-payment.delete');
});

Route::prefix('staff')->group(function () {
  Route::post('get', [\App\Http\Controllers\StaffController::class, 'get'])->name('staff.get');
  Route::post('table', [\App\Http\Controllers\StaffController::class, 'table'])->name('staff.table');
  Route::post('store', [\App\Http\Controllers\StaffController::class, 'store'])->name('staff.store');
  Route::post('update', [\App\Http\Controllers\StaffController::class, 'update'])->name('staff.update');
  Route::post('delete', [\App\Http\Controllers\StaffController::class, 'delete'])->name('staff.delete');
});
Route::prefix('staff-payment')->group(function () {
  Route::post('get/{id?}', [\App\Http\Controllers\StaffPaymentController::class, 'get'])->name('staff-payment.get');
  Route::post('table/{staff_id?}', [\App\Http\Controllers\StaffPaymentController::class, 'table'])->name('staff-payment.table');
  Route::post('store/{id?}', [\App\Http\Controllers\StaffPaymentController::class, 'store'])->name('staff-payment.store');
  Route::post('update/{id?}', [\App\Http\Controllers\StaffPaymentController::class, 'update'])->name('staff-payment.update');
  Route::post('delete/{id?}', [\App\Http\Controllers\StaffPaymentController::class, 'delete'])->name('staff-payment.delete');
});
Route::prefix('currency')->group(function () {
  Route::post('select', [\App\Http\Controllers\CurrencyController::class, 'select'])->name('currency.select');
});

Route::prefix('staff-payment-type')->group(function () {
  Route::post('get', [\App\Http\Controllers\StaffPaymentTypeController::class, 'get'])->name('staff-payment-type.get');
  Route::post('all', [\App\Http\Controllers\StaffPaymentTypeController::class, 'all'])->name('staff-payment-type.all');
  Route::post('select', [\App\Http\Controllers\StaffPaymentTypeController::class, 'select'])->name('staff-payment-type.select');
  Route::post('store', [\App\Http\Controllers\StaffPaymentTypeController::class, 'store'])->name('staff-payment-type.store');
  Route::post('update', [\App\Http\Controllers\StaffPaymentTypeController::class, 'update'])->name('staff-payment-type.update');
  Route::post('delete', [\App\Http\Controllers\StaffPaymentTypeController::class, 'delete'])->name('staff-payment-type.delete');
});
