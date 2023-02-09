<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabOrderTemplate extends Model
{
  protected $fillable = [
    'character_id',
    'description_for_leader',	
    'lrt_minutes_before',
    'lrt_type',	
    'lrt_sort',
  ];

    public function results() 
    {
      return $this->hasMany(LabResultTemplate::class);
    }
    public function character()
    {
      return $this->hasOne(character::class, 'id', 'character_id');
    }
    public function name_of_type()
    {
      //nazwy wystepują w szablonie laboratorynorms.modal_template_edit
      if ($this->lrt_type == 1)
        return 'historyczny';
      else
        return 'bieżący';
    }
    public function calculate_time()
    {
      return $this->lrt_minutes_before;
    }

}
