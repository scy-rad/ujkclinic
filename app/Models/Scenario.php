<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    use HasFactory;

    protected $fillable = [
      'scenario_author_id',
      'center_id',
      'scenario_type_id',
      'scenario_name',
      'scenario_code',
      'scenario_main_problem',
      'scenario_description',
      'scenario_for_students',
      'scenario_for_leader',
      'scenario_status'
    ];

  public function author()
  {
    return $this->hasOne(User::class, 'id', 'scenario_author_id');
  }
  public function center()
  {
    return $this->hasOne(Center::class, 'id', 'center_id');
  }
  public function type()
  {
    return $this->hasOne(ScenarioType::class, 'id', 'scenario_type_id');
  }
  public function actors() {
      return $this->hasMany(Actor::class);
  }

}
