<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SceneMaster extends Model
{
  protected $fillable = [
    'scenario_id',
    'scene_owner_id',
    'scene_code',
    'scene_name',
    'scene_date',
    'scene_relative_date',
    'scene_relative_id',
    'scene_step_minutes',
    'scene_scenario_description',
    'scene_scenario_for_students',
    'scene_status'
  ];

  public function scenario()
  {
    return $this->hasOne(Scenario::class, 'id', 'scenario_id');
  }
  public function owner()
  {
    return $this->hasOne(User::class, 'id', 'scene_owner_id');
  }
  public function actors() 
  {
    return $this->hasMany(SceneActor::class);
  }
  public function personels() 
  {
    return $this->hasMany(ScenePersonel::class);
  }
}
