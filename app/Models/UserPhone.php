<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserPhone extends Model   // 8 checked
{
  public function type()
  {
    return $this->hasOne(UserPhoneType::class, 'id', 'user_phone_type_id'); //->get()->first();
  }

  public function update_phone($phone_type, $phone_number, $phone_for)    // 8 checked
  {
    $this->user_phone_type_id = $phone_type;
    $this->phone_number = $phone_number;
    $this->phone_for_coordinators = $phone_for[0];
    $this->phone_for_technicians = $phone_for[1];
    $this->phone_for_trainers = $phone_for[2];
    $this->phone_for_guests = $phone_for[3];
    $this->phone_for_anonymouse = $phone_for[4];
    return $this->save();
  }

  public function remove_phone()    // 8 checked
  {
    return $this->delete();
  }

  public function phone_for_me($return_type)    // 8 checked
  {
    if ((Auth::user()->hasRoleCode('technicians') && ($this->phone_for_technicians == 1))
      || (Auth::user()->hasRoleCode('coordinators') && ($this->phone_for_coordinators == 1))
      || (Auth::user()->hasRoleCode('instructors') && ($this->phone_for_trainers == 1))
      || ($this->phone_for_guest == 1)
      || ($this->phone_for_anonymouse == 1)
       )
      switch ($return_type)
      {
        case 'html':
          return '<i class="bi ' . $this->type->user_phone_type_glyphicon . '"></i>: <a href="tel:' . $this->phone_number . '">' . $this->phone_number . '</a>';
          break;
        case 'html5':
          return '<div class="p-2"><a href="tel:' . $this->phone_number . '" class="no_decoration"><i class="bi ' . $this->type->user_phone_type_glyphicon . ' phone_ico"></i>: ' . $this->phone_number . '</a></div>';
          break;
        case 'plain':
          return $this->phone_number;
          break;
      }
  }



}
