<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
      'scenario_id',
      'actor_age_from',
      'actor_age_to',
      'actor_age_interval',
      'actor_sex',
      'actor_role_plan_id',
      'actor_role_name',
      'actor_type_id',
      'history_for_actor',
      'actor_simulation',
      'actor_status'
    ];

    
  public function actor_role_plan()
  {
    return $this->hasOne(ActorRolePlan::class, 'id', 'actor_role_plan_id');
  }
  public function actor_type()
  {
    return $this->hasOne(ActorType::class, 'id', 'actor_type_id');
  }
  public function scenario()
  {
    return $this->hasOne(Scenario::class, 'id', 'scenario_id');
  }



  public function age_interval_name()
  {
    switch ($this->actor_age_interval)
      {
        case 1 : $ret_txt = 'lat'; break;
        case 2 : $ret_txt = 'miesięcy'; break;
        case 3 : $ret_txt = 'tygodni'; break;
        case 4 : $ret_txt = 'dni'; break;
        case 5 : $ret_txt = 'godzin'; break;
        case 6 : $ret_txt = 'minut'; break;
      }
    return $ret_txt;
  }
  public static function age_interval_select()
  {
    $obj = (object) array(
      (object) array ('id' => '1', 'name' => 'lat'),
      (object) array ('id' => '2', 'name' => 'miesięcy'),
      (object) array ('id' => '3', 'name' => 'tygodni'),
      (object) array ('id' => '4', 'name' => 'dni'),
      (object) array ('id' => '5', 'name' => 'godzin'),
      (object) array ('id' => '6', 'name' => 'minut')
    );
        return $obj;
  }
  
  public function sex_name()
  {
    switch ($this->actor_sex)
      {
        case 1 : $ret_txt = 'nieistotne'; break;
        case 2 : $ret_txt = 'mężczyzna'; break;
        case 3 : $ret_txt = 'kobieta'; break;
      }
    return $ret_txt;
  }
  public static function lex_select()
  {
    $obj = (object) array(
      (object) array ('id' => '1', 'name' => 'nieistotne'),
      (object) array ('id' => '2', 'name' => 'mężczyzna'),
      (object) array ('id' => '3', 'name' => 'kobieta')
    );
        return $obj;
  }

  
}
