<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\IncomingWaybillController;
use App\Http\Controllers\OutgoingWaybillController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SafeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffPaymentController;
use App\Http\Controllers\StaffPaymentTypeController;
use App\Http\Controllers\StaffRoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\SupplierRegularPaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
  ->group(function () {
    Route::prefix('expense')
      ->group(function () {
        Route::post('table', [
          ExpenseController::class,
          'table'
        ])
          ->name('expense.table');
        Route::post('get', [
          ExpenseController::class,
          'get'
        ])
          ->name('expense.get');
        Route::post('store', [
          ExpenseController::class,
          'store'
        ])
          ->name('expense.store');
        Route::post('update', [
          ExpenseController::class,
          'update'
        ])
          ->name('expense.update');
        Route::post('delete', [
          ExpenseController::class,
          'delete'
        ])
          ->name('expense.delete');
      });
    Route::prefix('product')
      ->group(function () {
        Route::post('table', [
          ProductController::class,
          'table'
        ])
          ->name('product.table');
        Route::post('select', [
          ProductController::class,
          'select'
        ])
          ->name('product.select');
        Route::post('get', [
          ProductController::class,
          'get'
        ])
          ->name('product.get');
        Route::post('store', [
          ProductController::class,
          'store'
        ])
          ->name('product.store');
        Route::post('update', [
          ProductController::class,
          'update'
        ])
          ->name('product.update');
        Route::post('delete', [
          ProductController::class,
          'delete'
        ])
          ->name('product.delete');
      });

    Route::prefix('product-report')
      ->group(function () {
        Route::post('yearly-price-report', [
          ProductReportController::class,
          'yearlyPriceReport'
        ])
          ->name('product-report.yearly-price-report');
        Route::post('yearly-sale-report', [
          ProductReportController::class,
          'yearlySaleReport'
        ])
          ->name('product-report.yearly-sale-report');
      });


    Route::prefix('product_log')
      ->group(function () {
        Route::post('table/{product_id?}', [
          ProductLogController::class,
          'table'
        ])
          ->name('product_log.table');
      });

    Route::prefix('incoming_waybill')
      ->group(function () {
        Route::post('get', [
          IncomingWaybillController::class,
          'get'
        ])
          ->name('incoming-waybill.get');
        Route::post('table', [
          IncomingWaybillController::class,
          'table'
        ])
          ->name('incoming-waybill.table');
        Route::post('store', [
          IncomingWaybillController::class,
          'store'
        ])
          ->name('incoming-waybill.store');
        Route::post('update', [
          IncomingWaybillController::class,
          'update'
        ])
          ->name('incoming-waybill.update');
        Route::post('delete', [
          IncomingWaybillController::class,
          'delete'
        ])
          ->name('incoming-waybill.delete');
      });

    Route::prefix('outgoing_waybill')
      ->group(function () {
        Route::post('get', [
          OutgoingWaybillController::class,
          'get'
        ])
          ->name('outgoing-waybill.get');
        Route::post('table', [
          OutgoingWaybillController::class,
          'table'
        ])
          ->name('outgoing-waybill.table');
        Route::post('store', [
          OutgoingWaybillController::class,
          'store'
        ])
          ->name('outgoing-waybill.store');
        Route::post('update', [
          OutgoingWaybillController::class,
          'update'
        ])
          ->name('outgoing-waybill.update');
        Route::post('delete', [
          OutgoingWaybillController::class,
          'delete'
        ])
          ->name('outgoing-waybill.delete');
      });

    Route::prefix('expense_type')
      ->group(function () {
        Route::post('get', [
          ExpenseTypeController::class,
          'get'
        ])
          ->name('expense_type.get');
        Route::post('all', [
          ExpenseTypeController::class,
          'all'
        ])
          ->name('expense_type.all');
        Route::post('select', [
          ExpenseTypeController::class,
          'select'
        ])
          ->name('expense_type.select');
        Route::post('store', [
          ExpenseTypeController::class,
          'store'
        ])
          ->name('expense_type.store');
        Route::post('update', [
          ExpenseTypeController::class,
          'update'
        ])
          ->name('expense_type.update');
        Route::post('delete', [
          ExpenseTypeController::class,
          'delete'
        ])
          ->name('expense_type.delete');
      });

    Route::prefix('product_type')
      ->group(function () {
        Route::post('get', [
          ProductTypeController::class,
          'get'
        ])
          ->name('product_type.get');
        Route::post('all', [
          ProductTypeController::class,
          'all'
        ])
          ->name('product_type.all');
        Route::post('select', [
          ProductTypeController::class,
          'select'
        ])
          ->name('product_type.select');
        Route::post('store', [
          ProductTypeController::class,
          'store'
        ])
          ->name('product_type.store');
        Route::post('update', [
          ProductTypeController::class,
          'update'
        ])
          ->name('product_type.update');
        Route::post('delete', [
          ProductTypeController::class,
          'delete'
        ])
          ->name('product_type.delete');
      });

    Route::prefix('customer_role')
      ->group(function () {
        Route::post('get', [
          CustomerRoleController::class,
          'get'
        ])
          ->name('customer_role.get');
        Route::post('all', [
          CustomerRoleController::class,
          'all'
        ])
          ->name('customer_role.all');
        Route::post('select', [
          CustomerRoleController::class,
          'select'
        ])
          ->name('customer_role.select');
        Route::post('store', [
          CustomerRoleController::class,
          'store'
        ])
          ->name('customer_role.store');
        Route::post('update', [
          CustomerRoleController::class,
          'update'
        ])
          ->name('customer_role.update');
        Route::post('delete', [
          CustomerRoleController::class,
          'delete'
        ])
          ->name('customer_role.delete');
      });

    Route::prefix('staff_role')
      ->group(function () {
        Route::post('get', [
          StaffRoleController::class,
          'get'
        ])
          ->name('staff_role.get');
        Route::post('all', [
          StaffRoleController::class,
          'all'
        ])
          ->name('staff_role.all');
        Route::post('select', [
          StaffRoleController::class,
          'select'
        ])
          ->name('staff_role.select');
        Route::post('store', [
          StaffRoleController::class,
          'store'
        ])
          ->name('staff_role.store');
        Route::post('update', [
          StaffRoleController::class,
          'update'
        ])
          ->name('staff_role.update');
        Route::post('delete', [
          StaffRoleController::class,
          'delete'
        ])
          ->name('staff_role.delete');
      });

    Route::prefix('safe')
      ->group(function () {
        Route::post('select', [
          SafeController::class,
          'select'
        ])
          ->name('safe.select');
        Route::post('table', [
          SafeController::class,
          'table'
        ])
          ->name('safe.table');
        Route::post('get', [
          SafeController::class,
          'get'
        ])
          ->name('safe.get');
        Route::post('store', [
          SafeController::class,
          'store'
        ])
          ->name('safe.store');
        Route::post('update', [
          SafeController::class,
          'update'
        ])
          ->name('safe.update');
        Route::post('delete', [
          SafeController::class,
          'delete'
        ])
          ->name('safe.delete');
      });

    Route::prefix('customer')
      ->group(function () {
        Route::post('get', [
          CustomerController::class,
          'get'
        ])
          ->name('customer.get');
        Route::post('table', [
          CustomerController::class,
          'table'
        ])
          ->name('customer.table');
        Route::post('select', [
          CustomerController::class,
          'select'
        ])
          ->name('customer.select');
        Route::post('store', [
          CustomerController::class,
          'store'
        ])
          ->name('customer.store');
        Route::post('update', [
          CustomerController::class,
          'update'
        ])
          ->name('customer.update');
        Route::post('delete', [
          CustomerController::class,
          'delete'
        ])
          ->name('customer.delete');
      });

    Route::prefix('supplier')
      ->group(function () {
        Route::post('get', [
          SupplierController::class,
          'get'
        ])
          ->name('supplier.get');
        Route::post('select', [
          SupplierController::class,
          'select'
        ])
          ->name('supplier.select');
        Route::post('table', [
          SupplierController::class,
          'table'
        ])
          ->name('supplier.table');
        Route::post('store', [
          SupplierController::class,
          'store'
        ])
          ->name('supplier.store');
        Route::post('update', [
          SupplierController::class,
          'update'
        ])
          ->name('supplier.update');
        Route::post('delete', [
          SupplierController::class,
          'delete'
        ])
          ->name('supplier.delete');
      });
    Route::prefix('supplier-payment')
      ->group(function () {
        Route::post('get/{id?}', [
          SupplierPaymentController::class,
          'get'
        ])
          ->name('supplier-payment.get');
        Route::post('table/{supplier_id?}', [
          SupplierPaymentController::class,
          'table'
        ])
          ->name('supplier-payment.table');
        Route::post('store/{id?}', [
          SupplierPaymentController::class,
          'store'
        ])
          ->name('supplier-payment.store');
        Route::post('update/{payment_id?}', [
          SupplierPaymentController::class,
          'update'
        ])
          ->name('supplier-payment.update');
        Route::post('delete/{payment_id?}', [
          SupplierPaymentController::class,
          'delete'
        ])
          ->name('supplier-payment.delete');
      });
    Route::prefix('supplier-regular-payment')
      ->group(function () {
        Route::post('get', [
          SupplierRegularPaymentController::class,
          'get'
        ])
          ->name('supplier-regular-payment.get');
        Route::post('table/{supplier_id?}', [
          SupplierRegularPaymentController::class,
          'table'
        ])
          ->name('supplier-regular-payment.table');
        Route::post('store/{supplier_id?}', [
          SupplierRegularPaymentController::class,
          'store'
        ])
          ->name('supplier-regular-payment.store');
        Route::post('update/{regular_payment_id?}', [
          SupplierRegularPaymentController::class,
          'update'
        ])
          ->name('supplier-regular-payment.update');
        Route::post('delete', [
          SupplierRegularPaymentController::class,
          'delete'
        ])
          ->name('supplier-regular-payment.delete');
      });

    Route::prefix('staff')
      ->group(function () {
        Route::post('get', [
          StaffController::class,
          'get'
        ])
          ->name('staff.get');
        Route::post('table', [
          StaffController::class,
          'table'
        ])
          ->name('staff.table');
        Route::post('store', [
          StaffController::class,
          'store'
        ])
          ->name('staff.store');
        Route::post('update', [
          StaffController::class,
          'update'
        ])
          ->name('staff.update');
        Route::post('delete', [
          StaffController::class,
          'delete'
        ])
          ->name('staff.delete');
      });
    Route::prefix('staff-payment')
      ->group(function () {
        Route::post('get/{id?}', [
          StaffPaymentController::class,
          'get'
        ])
          ->name('staff-payment.get');
        Route::post('table/{staff_id?}', [
          StaffPaymentController::class,
          'table'
        ])
          ->name('staff-payment.table');
        Route::post('store/{id?}', [
          StaffPaymentController::class,
          'store'
        ])
          ->name('staff-payment.store');
        Route::post('update/{id?}', [
          StaffPaymentController::class,
          'update'
        ])
          ->name('staff-payment.update');
        Route::post('delete/{id?}', [
          StaffPaymentController::class,
          'delete'
        ])
          ->name('staff-payment.delete');
      });
    Route::prefix('currency')
      ->group(function () {
        Route::post('select', [
          CurrencyController::class,
          'select'
        ])
          ->name('currency.select');
      });

    Route::prefix('staff-payment-type')
      ->group(function () {
        Route::post('get', [
          StaffPaymentTypeController::class,
          'get'
        ])
          ->name('staff-payment-type.get');
        Route::post('all', [
          StaffPaymentTypeController::class,
          'all'
        ])
          ->name('staff-payment-type.all');
        Route::post('select', [
          StaffPaymentTypeController::class,
          'select'
        ])
          ->name('staff-payment-type.select');
        Route::post('store', [
          StaffPaymentTypeController::class,
          'store'
        ])
          ->name('staff-payment-type.store');
        Route::post('update', [
          StaffPaymentTypeController::class,
          'update'
        ])
          ->name('staff-payment-type.update');
        Route::post('delete', [
          StaffPaymentTypeController::class,
          'delete'
        ])
          ->name('staff-payment-type.delete');
      });

    Route::prefix('dashboard-report')
      ->group(function () {
        Route::post('yearly-price-report', [
          DashboardController::class,
          'yearlyPriceReport'
        ])
          ->name('dashboard-report.yearly-price-report');
        Route::post('yearly-expense-report', [
          DashboardController::class,
          'yearlyExpenseReport'
        ])
          ->name('dashboard-report.yearly-expense-report');
        Route::post('yearly-safe-report', [
          DashboardController::class,
          'yearlySafeReport'
        ])
          ->name('dashboard-report.yearly-safe-report');
        Route::post('yearly-product-report', [
          DashboardController::class,
          'yearlyProductReport'
        ])
          ->name('dashboard-report.yearly-product-report');
      });
  });

Route::prefix('auth')
  ->group(function () {
    Route::post('authenticate', [
      AuthController::class,
      'authenticate'
    ])
      ->name('auth.authenticate');
    Route::post('logout', [
      AuthController::class,
      'logout'
    ])
      ->name('auth.logout');
  });
