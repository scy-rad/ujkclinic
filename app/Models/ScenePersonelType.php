<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenePersonelType extends Model
{
  protected $fillable = [
    'spt_namespt_name_w',
    'spt_name_enspt_short',
    'spt_short_en',
    'spt_description',
    'spt_code',
    'spt_color'
  ];

  public function personels() 
  {
    return $this->hasMany(ScenePersonel::class);
  }

}
