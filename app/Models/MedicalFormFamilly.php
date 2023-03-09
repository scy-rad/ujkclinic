<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalFormFamilly extends Model
{
  public function form_types() 
  {
    return $this->hasMany(MedicalFormType::class);
  }
}
