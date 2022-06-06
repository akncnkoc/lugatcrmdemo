<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductReportController extends Controller
{
  public function index(Request $request, $product_id){
    return view('pages.product.report.index');
  }
}
