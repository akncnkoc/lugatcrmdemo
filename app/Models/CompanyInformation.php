<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompanyInformation
 *
 * @property string $title
 * @property string|null $logo
 * @property string|null $business_sector
 * @property string|null $address
 * @property string|null $post_code
 * @property string|null $country
 * @property string|null $city
 * @property string|null $county
 * @property string|null $tax_no
 * @property string|null $trade_register_number
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $tax_administration
 * @property string|null $mersis_no
 * @property string|null $fax
 * @property string|null $website
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereBusinessSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereMersisNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereTaxAdministration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereTaxNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereTradeRegisterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation whereWebsite($value)
 * @mixin \Eloquent
 */
class CompanyInformation extends Model
{

  public $timestamps = false;
  public $incrementing = false;
  protected $guarded = [];
  protected $primaryKey = null;
}
