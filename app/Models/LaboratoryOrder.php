<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryOrder extends Model
{
    use HasFactory;

    public function laboratory_order_group()
    {
      return $this->hasOne(LaboratoryOrderGroup::class, 'id', 'laboratory_order_group_id');
    }
    public function laboratory_tests() 
  {
    return $this->hasMany(LaboratoryTest::class);
  }
  
}
