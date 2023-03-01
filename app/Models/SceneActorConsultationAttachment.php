<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SceneActorConsultationAttachment extends Model
{
  public function consultation()
  {
    return $this->hasOne(SceneActorConsultation::class, 'id', 'sac_id');
  }
}
