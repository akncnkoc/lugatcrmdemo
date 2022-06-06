<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\SafeRequest;
use App\Models\Safe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;

class SafeController extends Controller
{

  public function index(Request $request)
  {
    return view('pages.safe.index');
  }

  public function select(Request $request)
  {
    return AppHelper::_select2($request, Safe::class);
  }

  public function get(Request $request)
  {
    if ($request->ajax()) {
      try {
        return response()->json(Safe::with('currency')->find($request->get('id')));
      } catch (\Exception $e) {
        return response()->json(false, 500);
      }
    }
  }

  public function store(SafeRequest $request)
  {
    try {
      \DB::beginTransaction();
      $request->merge(['total' => !empty($request->get('total')) ? AppHelper::currencyToDecimal($request->get('total')) : 0]);
      $safe = Safe::create($request->only(['name', 'total', 'currency_id']));

      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function update(Request $request)
  {
    try {
      \DB::beginTransaction();
      $safe = Safe::where('id', $request->get('id'))->firstOrFail();
      $safe->update($request->only(['name']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      \DB::beginTransaction();
      $safe = Safe::where('id', $request->get('id'))->firstOrFail();
      $safe->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }

  public function table(Request $request)
  {
    $safes = Safe::with([
      'currency'
    ]);
    return EloquentDataTable::create($safes)
      ->addIndexColumn()
      ->filter(function ($query) use ($request) {
        if (!empty($request->get('name'))) {
          $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
        }
        if (!empty($request->get('currencies'))) {
          $query->whereHas('currency', function (Builder $row) use ($request) {
            $row->whereIn('id', $request->get('currencies'));
          });
        }
        if (!empty($request->get('min_total')) && AppHelper::currencyToDecimal($request->get('min_total'))) {
          $query->where('total', '>=', AppHelper::currencyToDecimal($request->get('min_total')));
        }
        if (!empty($request->get('max_total')) && AppHelper::currencyToDecimal($request->get('max_total'))) {
          $query->where('total', '<=', AppHelper::currencyToDecimal($request->get('max_total')));
        }
      })
      ->make();
  }
}
