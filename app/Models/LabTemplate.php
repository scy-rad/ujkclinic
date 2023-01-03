<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTemplate extends Model
{
  protected $fillable = [
    'actor_id',
    'description_for_leader',	
    'lrt_minutes_before',
    'lrt_type',	
    'lrt_sort',
  ];

    public function results() 
    {
      return $this->hasMany(LabTemplateResult::class);
    }
    public function actor()
    {
      return $this->hasOne(actor::class, 'id', 'actor_id');
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
