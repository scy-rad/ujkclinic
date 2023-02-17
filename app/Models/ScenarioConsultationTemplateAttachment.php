<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenarioConsultationTemplateAttachment extends Model
{
  protected $fillable = [
    'sct_id',
    'scta_file',
    'scta_name'
  ];
}
