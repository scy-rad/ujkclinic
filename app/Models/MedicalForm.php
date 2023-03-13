<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalForm extends Model
{
    protected $fillable = [
      'medical_center_visit_card_id',
      'medical_form_type_id',
      'mf_date_1',
      'mf_date_2',
      'mf_date_3',
      'mf_integer_1',
      'mf_integer_2',            
      'mf_integer_3',
      'mf_float_1',
      'mf_float_2',
      'mf_float_3',
      'mf_string_1',
      'mf_string_2',
      'mf_string_3',
      'mf_text_1',
      'mf_text_2',
      'mf_text_3'
    ];

    public function form_type()
    {
      return $this->hasOne(MedicalFormType::class, 'id', 'medical_form_type_id');
    }
    
    public function visit_card()
    {
      return $this->hasOne(MedicalCenterVisitCard::class, 'id', 'medical_center_visit_card_id');
    }
}
