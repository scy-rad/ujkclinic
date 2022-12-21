<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScenarioType extends Model
{
    use HasFactory;

    public function scenarios() {
      return $this->hasMany(Scenario::class);
  }

}
