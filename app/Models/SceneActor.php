<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SceneActor extends Model
{
  protected $fillable = [
    'scene_master_id',
    'actor_id',
    'sa_incoming_date',
    'sa_incoming_recalculate',
    'sa_main_book',
    'sa_name',
    'sa_birth_date',
    'sa_PESEL',
    'sa_actor_sex',
    'sa_actor_nn',
    'sa_actor_role_name',
    'sa_history_for_actor',
    'sa_actor_simulation'
  ];
  
  public function scene()
  {
    return $this->hasOne(SceneMaster::class, 'id', 'scene_master_id');
  }
  public function actor_template()
  {
    return $this->hasOne(Actor::class, 'id', 'actor_id');
  }
  public function scene_lab_templates() 
  {
    return $this->hasMany(SceneLabTemplate::class);
  }


  public function sex_name()
  {
    switch ($this->sa_actor_sex)
      {
        case 2 : $ret_txt = 'mężczyzna'; break;
        case 3 : $ret_txt = 'kobieta'; break;
      }
    return $ret_txt;
  }
  public static function lex_select()
  {
    $obj = (object) array(
      (object) array ('id' => '2', 'name' => 'mężczyzna'),
      (object) array ('id' => '3', 'name' => 'kobieta')
    );
        return $obj;
  }

  

}
