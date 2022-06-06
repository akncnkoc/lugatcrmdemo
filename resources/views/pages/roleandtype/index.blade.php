@extends('layout.default')

@section('content')
  <div class="row gy-5">
    <div class="col-lg-4">
      @include('pages.expense.type.index')
    </div>
    <div class="col-lg-4">
      @include('pages.product.type.index')
    </div>
    <div class="col-lg-4">
      @include('pages.customer.role.index')
    </div>
    <div class="col-lg-4">
      @include('pages.staff.role.index')
    </div>
    <div class="col-lg-4">
      @include('pages.staff.payment.type.index')
    </div>
  </div>
@endsection

