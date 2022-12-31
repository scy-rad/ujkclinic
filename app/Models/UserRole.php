<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public function users()
    {
      return $this->belongsToMany(User::class, 'user_has_roles', 'role_id', 'user_id');
    }
  
}
