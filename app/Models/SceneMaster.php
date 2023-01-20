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
    'scene_lab_take_seconds_from',
    'scene_lab_take_seconds_to',
    'scene_lab_delivery_seconds_from',
    'scene_lab_delivery_seconds_to',
    'scene_lab_automatic_time',
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
  public function laboratory_orders() 
  {
    return $this->hasManyThrough(SceneActorLabOrder::class,SceneActor::class);
  }
  public function personels() 
  {
    return $this->hasMany(ScenePersonel::class);
  }
  public function status_name()
  {
    switch ($this->scene_status)
      {
        case 1 : $ret_txt = 'robocza'; break;
        case 2 : $ret_txt = 'aktywna'; break;
        case 3 : $ret_txt = 'zatrzymana'; break;
        case 4 : $ret_txt = 'zakończona'; break;
      }
    return $ret_txt;
  }
  public function scene_current_time()
  {
    if (is_null($this->scene_relative_date))
      return $this->scene_date;
    else
      return date("Y-m-d H:i:s",strtotime(date('Y-m-d H:i:s')) + strtotime($this->scene_date) - strtotime($this->scene_relative_date));
  }
}
