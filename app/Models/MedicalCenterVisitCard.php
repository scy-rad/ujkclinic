<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalCenterVisitCard extends Model
{
  protected $fillable = [
    'mcvc_begin',
    'mcvc_end',
    'mcvc_medical_history',
    'mcvc_medical_examination',
    'mcvc_medical_orders',
    'mcvc_comments'];

  public function SceneActor()
  {
    return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
  }
  public function medical_forms() 
  {
    return $this->hasMany(MedicalForm::class);
  }
}
