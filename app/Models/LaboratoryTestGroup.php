<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryTestGroup extends Model
{
  use HasFactory;
  protected $fillable = [
    'ltg_name',
    'ltg_name_en',
    'ltg_sort'
  ];

  public function laboratory_tests() 
  {
    return $this->hasMany(LaboratoryTest::class);
  }
}
