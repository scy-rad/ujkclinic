<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryTest extends Model
{
  use HasFactory;

  protected $fillable = [
    'laboratory_test_group_id',
    'lt_name',
    'lt_name_en',
    'lt_short',
    'lt_short_en',
    'lt_unit',
    'lt_unit_en',
    'lt_decimal_prec',
    'lt_sort',
    'lt_time',
    'lt_coast',
    'lt_time_cito',
    'lt_coast_cito'
  ];

  public function laboratory_test_norms() 
  {
    return $this->hasMany(LaboratoryTestNorm::class);
  }
  public function laboratory_test_group()
  {
    return $this->hasOne(LaboratoryTestGroup::class, 'id', 'laboratory_test_group_id');
  }
  public function laboratory_order()
  {
    return $this->hasOne(LaboratoryOrder::class, 'id', 'laboratory_order_id');
  }
}
