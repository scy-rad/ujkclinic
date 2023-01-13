<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SceneActorLabResult extends Model
{
    use HasFactory;

    public function lab_order()
    {
      return $this->hasOne(SceneActorLabOrder::class, 'id', 'scene_actor_lab_order_id');
    }
    public function laboratory_test()
    {
      return $this->hasOne(LaboratoryTest::class, 'id', 'laboratory_test_id');
    }

}
