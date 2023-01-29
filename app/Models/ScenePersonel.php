<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
  
  public static function free_personel(SceneMaster $SceneMaster)
  {
    $roles_id=\App\Models\UserRole::where('role_code', 'scene_doctor')
      ->orWhere('role_code', 'scene_nurse')
      ->orWhere('role_code', 'scene_midwife')
      ->orWhere('role_code', 'scene_paramedic')
      ->pluck('id');
    $roles_users=\App\Models\UserHasRole::select('user_id')->whereIn('role_id',$roles_id)->get();
    $no_users=\App\Models\ScenePersonel::where('scene_master_id',$SceneMaster->id)->pluck('user_id');
    
    return \App\Models\User::whereIn('id',$roles_users)->whereNotIn('id',$no_users)
      ->orderBy('lastname')
      ->orderBy('firstname')
      ->select('id','lastname', 'firstname')
      ->get();
  }

  public static function update_personel(Request $request)
  {
    if ($request->action == 'add')
    {
      $newPersonel = new ScenePersonel();
      $newPersonel->scene_master_id = $request->scene_master_id;
      $newPersonel->user_id = $request->personel_to_scene_id;
      $newPersonel->scene_personel_name = $request->scene_personel_name;
      $newPersonel->scene_personel_type_id=1;
      $newPersonel->scene_personel_status=1;
      $newPersonel->save();

      $ret = ['success' => 'Personel raczej dopisany prawidłowo :) .'];

    }
    if ($request->action == 'remove')
    {
      $newPersonel = ScenePersonel::where('id',$request->scene_personel_id)->first();
      $newPersonel->delete();

      $ret = ['success' => 'Personel raczej usunięty prawidłowo :) .'];
    }
 
    return response()->json($ret);
  } // end of function update_order_form

}
