<?php

namespace App;

use App\Models\Currency;
use Illuminate\Support\Carbon;

class AppHelper
{
  public const OUTPUT = 0;
  public const INPUT = 1;
  public const CASH_REGISTER = 3;
  public const PRODUCT_IN = 1;
  public const PRODUCT_OUT = 2;
  public const PRODUCT_REBATE = 3;
  public const PRODUCT_SOLD = 4;

  public static function changeEnvironmentVariable($key, $value)
  {
    $path = base_path('.env');

    if (is_bool(env($key))) {
      $old = env($key) ? 'true' : 'false';
    } elseif (env($key) === null) {
      $old = 'null';
    } else {
      $old = env($key);
    }

    if (file_exists($path)) {
      file_put_contents($path, str_replace(
        "$key=" . $old,
        "$key=" . $value,
        file_get_contents($path)
      ));
    }
  }

  public static function getPrimaryCurrency()
  {
    return Currency::where('primary', true)
      ->firstOrFail();
  }

  public static function convertedPrice($model, $primaryCurrency, $column = "price")
  {
    $convertedRate = $model->safe->currency->banknote_sell / $primaryCurrency->banknote_sell;
    return round(self::currencyToDecimal($model->$column) * $convertedRate, 2);
  }

  public static function currencyToDecimal($value): float
  {
    $value = trim($value);
    $value = preg_replace('/(\d)(\s)(\d)/', '$1$3', $value);
    if (strpos($value, '.') !== false && strpos($value, ',') !== false) {
      if (strrpos($value, '.') < strpos($value, ',')) {
        $value = str_replace('.', '', $value);
      }
    }
    if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
      if (strrpos($value, ',') < strpos($value, '.')) {
        $value = str_replace(',', '', $value);
      }
    }
    $value = str_replace(',', '.', $value);
    $value = preg_replace('/[^\d\.]/', '', $value);
    return (float)$value;
  }

  public static function group_by($key, $data)
  {
    $result = array();

    foreach ($data as $val) {
      if (array_key_exists($key, $val)) {
        $result[$val[$key]][] = $val;
      } else {
        $result[""][] = $val;
      }
    }

    return $result;
  }

  public static function seflink($text)
  {
    $find = array("/Ğ/", "/Ü/", "/Ş/", "/İ/", "/Ö/", "/Ç/", "/ğ/", "/ü/", "/ş/", "/ı/", "/ö/", "/ç/");
    $degis = array("G", "U", "S", "I", "O", "C", "g", "u", "s", "i", "o", "c");
    $text = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/", " ", $text);
    $text = preg_replace($find, $degis, $text);
    $text = preg_replace("/ +/", " ", $text);
    $text = preg_replace("/ /", "-", $text);
    $text = preg_replace("/\s/", "", $text);
    $text = strtolower($text);
    $text = preg_replace("/^-/", "", $text);
    $text = preg_replace("/-$/", "", $text);
    return $text;
  }

  public static function convertDate($date, $format = "d.m.Y H:i:s")
  {
    if ($date) {
      return Carbon::parse($date)->format($format);
    } else {
      return Carbon::now()->format('Y-m-d H:i:s');
    }
  }

  public static function convertDateGet($date = null, $format = "d.m.Y H:i:s")
  {
    if ($date != null) {
      return Carbon::parse($date)->format($format);
    }
  }

  public static function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool
  {
    //remove white space, dots, hyphens and brackets
    $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

    //are we left with digits only?
    return self::isDigits($telephone, $minDigits, $maxDigits);
  }

  public static function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool
  {
    return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $s);
  }

  public static function formatFileSizeUnits($bytes, $getNumber = false)
  {
    if ($bytes >= 1073741824) {
      $bytes = !$getNumber ? number_format($bytes / 1073741824, 2) . ' GB' : number_format($bytes / 1073741824, 2);
    } elseif ($bytes >= 1048576) {
      $bytes = !$getNumber ? number_format($bytes / 1048576, 2) . ' MB' : number_format($bytes / 1048576, 2);
    } elseif ($bytes >= 1024) {
      $bytes = !$getNumber ? number_format($bytes / 1024, 2) . ' KB' : number_format($bytes / 1024, 2);
    } elseif ($bytes > 1) {
      $bytes = !$getNumber ? $bytes . ' bayt' : $bytes;
    } elseif ($bytes == 1) {
      $bytes = !$getNumber ? $bytes . ' bayt' : $bytes;
    } else {
      $bytes = !$getNumber ? '0 bayt' : 0;
    }
    return $bytes;
  }

  public static function setNumberToMonthName($number)
  {
    $months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
    return $months[$number - 1];
  }

  public static function truncateStr($string, $length, $dots = "...")
  {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
  }

  public static function searchedDates($type = 'total' | 'today' | 'this_week' | 'this_month' | 'six_month' | 'year'
  | 'last_year')
  {
    $searchedDates = [];
    switch ($type) {
      case 'total':
        $searchedDates[] = Carbon::today()
          ->subYears(20)
          ->toDateTimeString();
        $searchedDates[] = Carbon::today()
          ->endOfYear()
          ->toDateTimeString();
        break;
      case 'today':
        $searchedDates[] = Carbon::now()
          ->startOfDay()
          ->toDateTimeString();
        $searchedDates[] = Carbon::now()
          ->endOfDay()
          ->toDateTimeString();
        break;
      case 'this_week':
        $searchedDates[] = Carbon::now()
          ->startOf('week')
          ->toDateTimeString();
        $searchedDates[] = Carbon::now()
          ->endOf('week')
          ->toDateTimeString();
        break;
      case 'this_month':
        $searchedDates[] = Carbon::now()
          ->startOf('month')
          ->toDateTimeString();
        $searchedDates[] = Carbon::now()
          ->endOf('month')
          ->toDateTimeString();
        break;
      case 'six_month':
        $searchedDates[] = Carbon::now()
          ->startOf('month')
          ->subMonths(5)
          ->toDateTimeString();
        $searchedDates[] = Carbon::now()
          ->endOf('month')
          ->toDateTimeString();
        break;
      case 'year':
        $searchedDates[] = Carbon::now()
          ->startOfYear()
          ->toDateTimeString();
        $searchedDates[] = Carbon::now()
          ->endOfYear()
          ->toDateTimeString();
        break;
      case 'last_year':
        $searchedDates[] = Carbon::now()
          ->subYears()
          ->startOfYear()
          ->toDateTimeString();
        $searchedDates[] = Carbon::now()
          ->subYears()
          ->endOfYear()
          ->toDateTimeString();
        break;
    }
    return $searchedDates;
  }

  public static function _group_by($array, $key)
  {
    $return = array();
    foreach ($array as $val) {
      $return[$val[$key]][] = $val;
    }
    return $return;
  }

  public static function _select2($request, $class, $key = "id", $text = "name", $limit = 5)
  {
    $data = $request->search
      ? $class::where('name', 'LIKE', "%$request->search%")
      : new $class();

    $items = $data->paginate(10, [$key, $text], 'page', $request->page)->toArray();

    $response = array();
    foreach ($items['data'] as $item) {
      $response[] = array(
        "id"   => $item[$key],
        "text" => $item[$text]
      );
    }
    return response()->json(['results' => $response, 'total' => $items['total']]);
  }

  public static function possesiveSuffix($word)
  {
    $lastLetter = substr(mb_strtolower($word, "UTF-8"), -1); //get last letter
    $penultimateLetter = substr(mb_strtolower($word, "UTF-8"), -2, 1); //get penultimate letter
    $vowels = "aeıioüu";

    if (strrchr($vowels, $lastLetter)) { //last letter check
      $letterCheck = $lastLetter;
      $possessiveSuffixes = array("nın", "nin", "nun", "nün");
    } else { //if there isn't vowels in last letter then check penultimate letter
      $letterCheck = $penultimateLetter;
      $possessiveSuffixes = array("ın", "in", "un", "ün");
    }

    switch ($letterCheck) { //according to last letter add possessive suffix to word
      case "a":
      case "ı":
        $possessive = $possessiveSuffixes[0];
        break;
      case "e":
      case "i":
        $possessive = $possessiveSuffixes[1];
        break;
      case "o":
      case "u":
        $possessive = $possessiveSuffixes[2];
        break;
      case "ö":
      case "ü":
        $possessive = $possessiveSuffixes[3];
        break;
      default:
        $possessive = "nın";
        break;
    }

    return sprintf("%s'%s", $word, $possessive);
  }

  public static function getAllMonths(): mixed
  {
    $month = [];
    for ($m = 1; $m <= 12; $m++) {
      $month[] = Carbon::now()->month($m)->getTranslatedMonthName();
    }
    return $month;
  }

  public static function getApexChartLocaleConfiguration()
  {
    return [
      "months"      => [
        __('globals/dates.january'),
        __('globals/dates.february'),
        __('globals/dates.march'),
        __('globals/dates.april'),
        __('globals/dates.may'),
        __('globals/dates.june'),
        __('globals/dates.july'),
        __('globals/dates.august'),
        __('globals/dates.september'),
        __('globals/dates.october'),
        __('globals/dates.november'),
        __('globals/dates.december')
      ],
      "shortMonths" => [
        __('globals/dates.january_short'),
        __('globals/dates.february_short'),
        __('globals/dates.march_short'),
        __('globals/dates.april_short'),
        __('globals/dates.may_short'),
        __('globals/dates.june_short'),
        __('globals/dates.july_short'),
        __('globals/dates.august_short'),
        __('globals/dates.september_short'),
        __('globals/dates.october_short'),
        __('globals/dates.november_short'),
        __('globals/dates.december_short')
      ],
      "days"        => [
        __('globals/dates.sunday'),
        __('globals/dates.monday'),
        __('globals/dates.tuesday'),
        __('globals/dates.wednesday'),
        __('globals/dates.thursday'),
        __('globals/dates.friday'),
        __('globals/dates.saturday')
      ],
      "shortDays"   => [
        __('globals/dates.sunday_short'),
        __('globals/dates.monday_short'),
        __('globals/dates.tuesday_short'),
        __('globals/dates.wednesday_short'),
        __('globals/dates.thursday_short'),
        __('globals/dates.friday_short'),
        __('globals/dates.saturday_short')
      ],
      "toolbar"     => [
        "exportToSVG"   => __('globals/words.exporttosvg'),
        "exportToCSV" => __('globals/words.exporttocsv'),
        "exportToPNG"   => __('globals/words.exporttopng'),
        "menu"          => __('globals/words.menu'),
        "selection"     => __('globals/words.selection'),
        "selectionZoom" => __('globals/words.selection_zoom'),
        "zoomIn"        => __('globals/words.zoom_in'),
        "zoomOut"       => __('globals/words.zoom_out'),
        "pan"           => __('globals/words.pan'),
        "reset"         => __('globals/words.reset_zoom')
      ]
    ];
  }
}
