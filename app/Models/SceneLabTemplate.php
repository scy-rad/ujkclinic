<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SceneLabTemplate extends Model
{
  protected $fillable = [
    'scene_actor_id',
    'lab_template_id',
    'slt_date',
    'slt_lrt_minutes_before'
  ];


  public function actor()
    {
      return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
    }
  public function lab_template()
    {
      return $this->hasOne(LabTemplate::class, 'id', 'lab_template_id');
    }
  public function scene_lab_results() 
    {
      return $this->hasMany(SceneLabResult::class);
    }

}
