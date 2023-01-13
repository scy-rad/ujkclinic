<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SceneActorLabOrder extends Model
{
    use HasFactory;

  public function lab_results() {
    return $this->hasMany(SceneActorLabResult::class);
  }
  public function scene_actor()
    {
      return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
    }
}
