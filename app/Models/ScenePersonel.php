<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenePersonel extends Model
{
  protected $fillable = [
    'scene_master_id',
    'user_id',
    'scene_personel_name',
    'scene_personel_type_id',
    'scene_status'
  ];

  public function scene()
  {
    return $this->hasOne(Scene::class, 'id', 'scene_master_id');
  }
  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function type() 
  {
    return $this->hasOne(ScenePersonelType::class, 'id', 'user_id');
  }

}
