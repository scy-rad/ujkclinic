<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalFormType extends Model
{

    public function form_familly()
    {
      return $this->hasOne(MedicalFormFamilly::class, 'id', 'medical_form_familly_id');
    }
    public function forms() 
    {
      return $this->hasMany(MedicalForm::class);
    }
    public function character_forms() 
    {
      return $this->hasMany(MedicalFormForCharacters::class);
    }
}
