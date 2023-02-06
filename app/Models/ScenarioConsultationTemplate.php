<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScenarioConsultationTemplate extends Model
{
  protected $fillable = [
    'actor_id',
    'sctt_id',
    'sct_type_details',
    'sct_reason',
    'sct_minutes_before',
    'sct_seconds_description',
    'sct_verbal_attach',
    'sct_description'
  ];

    use HasFactory;
  
  public function consultation_type()
  {
    return $this->hasOne(ScenarioConsultationTemplateType::class, 'id', 'sctt_id');
  }
  public function consultation_attachments()
  {
    return $this->hasMany(ScenarioConsultationTemplateAttachment::class);
  }
}
