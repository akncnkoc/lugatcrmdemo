<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
  public function currency($changePrimaryCurrency = true) {
    $JSONString = array(
      "success"   => false,
      "tarih"     => "",
      "bulten_no" => "",
      "results"   => array()
    );
    $url = 'https://www.tcmb.gov.tr/kurlar/today.xml';

    try {
      $sxe = true;
      $xml = simplexml_load_string($this->curlGetFileContents($url));
    } catch (Exception $e) {
      $sxe = false;
    }
    if (false === $sxe) {
      $JSONString['results'][] = array(
        'message' => 'Tarih Hatalı'
      );
    } else {
      $count = 1;
      $Tarih_Date = (string)$xml->attributes()->Tarih;
      $Bulten_No = (string)$xml->attributes()->Bulten_No;
      $JSONString['tarih'] = $Tarih_Date;
      $JSONString['bulten_no'] = $Bulten_No;
      foreach ($xml->children() as $children) {
        $Unit = (string)$children->Unit;
        $CurrencyCode = (string)$children->attributes()->CurrencyCode;
        $CurrencyName = (string)$children->Isim;
        $ForexBuying = (string)$children->ForexBuying;
        $ForexSelling = (string)$children->ForexSelling;
        $BanknoteBuying = (string)$children->BanknoteBuying;
        $BanknoteSelling = (string)$children->BanknoteSelling;
        $JSONString['results'][] = array(
          'Unit'            => $Unit,
          'Code'            => $CurrencyCode,
          'CurrencyName'    => $CurrencyName,
          'ForexBuying'     => $ForexBuying,
          'ForexSelling'    => $ForexSelling,
          'BanknoteBuying'  => $BanknoteBuying,
          'BanknoteSelling' => $BanknoteSelling
        );
        ++$count;
      }
      $JSONString['results'][] = array(
        'Unit'            => '1',
        'Code'            => 'TRY',
        'CurrencyName'    => 'TÜRK LİRASI',
        'ForexBuying'     => '1',
        'ForexSelling'    => '1',
        'BanknoteBuying'  => '1',
        'BanknoteSelling' => '1'
      );
      $JSONString['success'] = true;
    }
    $json = json_encode($JSONString, JSON_THROW_ON_ERROR);
    $array = json_decode($json, TRUE, 512, JSON_THROW_ON_ERROR);
    foreach ($array["results"] as $item) {
      if (!Currency::where('code', $item["Code"])
        ->exists()) {
        if (!empty($item["ForexBuying"]) && !empty($item["ForexSelling"]) && !empty($item["BanknoteBuying"]) && !empty($item["BanknoteSelling"])) {
          Currency::create([
            'name'             => $item["CurrencyName"],
            'unit'             => $item["Unit"],
            'code'             => $item["Code"],
            'forex_buy'     => $item["ForexBuying"],
            'forex_sell'    => $item["ForexSelling"],
            'banknote_buy'  => $item["BanknoteBuying"],
            'banknote_sell' => $item["BanknoteSelling"],
            'primary'          => $item['Code'] == 'TRY' && $changePrimaryCurrency
          ]);
        }

      } else {
        $currency_type = Currency::where('code', $item["Code"])
          ->get()[0];
        if (!empty($item["ForexBuying"]) && !empty($item["ForexSelling"]) && !empty($item["BanknoteBuying"]) && !empty($item["BanknoteSelling"])) {
          $currency_type->update([
            'name'             => $item["CurrencyName"],
            'unit'             => $item["Unit"],
            'code'             => $item["Code"],
            'forex_buy'     => $item["ForexBuying"],
            'forex_sell'    => $item["ForexSelling"],
            'banknote_buy'  => $item["BanknoteBuying"],
            'banknote_sell' => $item["BanknoteSelling"],
          ]);
          if ($changePrimaryCurrency) {
            $currency_type->update([
              'primary' => $item['Code'] == 'TRY'
            ]);
          }
        }
      }
    }
    return response()->json($array,
      200,
      [
        'Content-Type' => 'application/json;charset=UTF-8',
        'Charset'      => 'utf-8'
      ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
    );
  }

  public function curlGetFileContents($URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);
    if ($contents) {
      return $contents;
    } else {
      return false;
    }
  }

  public function currencyAll(Request $request): array {
    return ['results' => Currency::get()];
  }

  public function currencySave(Request $request) {
    try {
      foreach ($request->all() as $currencyCode => $rate) {
        Currency::where('code', $currencyCode)
          ->first()
          ->update(['banknote_selling' => AppHelper::currencyToDecimal($rate)]);
      }
      return response()->json(['success' => true]);
    } catch (Exception $e) {
      return response()->json([
        'error'           => true,
        'message_title'   => 'Bir sorun oluştu.',
        'message_content' => $e->getMessage()
      ], 422);
    }
  }

  public function currencyPrimary(Request $request) {
    try {
      Currency::all()->each->update(['primary' => false]);
      Currency::where('code', $request->get('currency_code'))
        ->first()
        ->update(['primary' => true]);
      return response()->json(['success' => true]);
    } catch (Exception $e) {
      return response()->json([
        'error'           => true,
        'message_title'   => 'Bir sorun oluştu.',
        'message_content' => $e->getMessage()
      ], 422);
    }
  }

  public function getPrimaryCurrency() {
    return Currency::where('primary', true)
      ->firstOrFail();
  }

  public function only(Request $request) {
    $bodyContent = json_decode($request->getContent());
    return Safe::find($bodyContent->safe_id)->currency;
  }

  public function select(Request $request){
    return AppHelper::_select2($request, Currency::class);
  }
}
