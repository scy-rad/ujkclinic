<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SceneType extends Model
{
    use HasFactory;

    public function scenarios() {
      return $this->hasMany(Scenario::class);
  }
  public function scene_actors() {
    return $this->hasMany(SceneActor::class);
}

}
