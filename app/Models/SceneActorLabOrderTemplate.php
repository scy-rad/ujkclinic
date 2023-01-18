<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SceneActorLabOrderTemplate extends Model
{
  protected $fillable = [
    'scene_actor_id',
    'lab_order_template_id',
    'salot_lrt_minutes_before',
    'salo_descript'
  ];


  public function actor()
    {
      return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
    }
  public function lab_template()
    {
      return $this->hasOne(LabOrderTemplate::class, 'id', 'lab_order_template_id');
    }
  public function scene_actor_lab_result_templates() 
    {
      return $this->hasMany(SceneActorLabResultTemplate::class);
    }

}
