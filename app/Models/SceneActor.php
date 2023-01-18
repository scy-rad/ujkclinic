<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ActorFirstname;
use App\Models\ActorLastname;
use DateTime;

class SceneActor extends Model
{
  protected $fillable = [
    'scene_master_id',
    'actor_id',
    'sa_incoming_date',
    'sa_incoming_recalculate',
    'sa_main_book',
    'sa_name',
    'sa_birth_date',
    'sa_age',
    'sa_age_txt',
    'sa_PESEL',
    'sa_actor_sex',
    'sa_actor_nn',
    'sa_actor_role_name',
    'sa_history_for_actor',
    'sa_actor_simulation'
  ];
  
  public function scene()
  {
    return $this->hasOne(SceneMaster::class, 'id', 'scene_master_id');
  }
  public function actor_template()
  {
    return $this->hasOne(Actor::class, 'id', 'actor_id');
  }
  public function scene_actor_lab_order_templates() 
  {
    return $this->hasMany(SceneActorLabOrderTemplate::class);
  }


  public function sex_name()
  {
    switch ($this->sa_actor_sex)
      {
        case 2 : $ret_txt = 'mężczyzna'; break;
        case 3 : $ret_txt = 'kobieta'; break;
      }
    return $ret_txt;
  }
  public static function lex_select()
  {
    $obj = (object) array(
      (object) array ('id' => '2', 'name' => 'mężczyzna'),
      (object) array ('id' => '3', 'name' => 'kobieta')
    );
        return $obj;
  }

  public static function random_actor($birthDate,$actor_sex)
  {
    if((strtotime(date('Y-m-d H:i:s'))-strtotime($birthDate))/(60*60*24)<14)  //dni
      $is_child=true;
    else
      $is_child=false;

  $sex=rand(0,4)*2;
  if ($actor_sex==1)        // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
    $actor_sex=rand(2,3);
  if ($actor_sex==2)
    {
    $sex++;
    if ($is_child)
      $ret['name']=ActorFirstname::inRandomOrder()->first()->firstname_man.' "syn" '.ActorFirstname::inRandomOrder()->first()->firstname_woman;
    else
      $ret['name']=ActorFirstname::inRandomOrder()->first()->firstname_man.' '.ActorLastname::inRandomOrder()->first()->lastname_man;
    }
  else
    {
      if ($is_child)
      $ret['name']=ActorFirstname::inRandomOrder()->first()->firstname_woman.' "córka" '.ActorFirstname::inRandomOrder()->first()->firstname_woman;
    else
      $ret['name']=ActorFirstname::inRandomOrder()->first()->firstname_woman.' '.ActorLastname::inRandomOrder()->first()->lastname_woman;
    }

  $birthTime=strtotime($birthDate);

  $digits_number = date('ymd',$birthTime).str_pad(rand(0,999), 3, 0, STR_PAD_LEFT).$sex;
  if (date('Y',$birthTime)>=2000)
    $digits_number[2]=$digits_number[2]+2;

  $arrBalance = [9, 7, 3, 1, 9, 7, 3, 1, 9, 7];

  $number = (string)$digits_number;
  $strlen = strlen($number);
  $digit_sum = 0;

  for ($i=0; $i<$strlen; $i++) {
    $digit_sum += ($arrBalance[$i] * (int)$number[$i]);
  }

  // // Checksum
  $checksum = $digit_sum % 10;

  // // PESEL
  if ($is_child)
    $ret['PESEL'] = '00000000000';
  else
    $ret['PESEL'] = $digits_number.$checksum;
  $ret['actor_sex'] = $actor_sex;
  $ret['actor_birth'] = $birthDate;
  


  return json_encode($ret);
  // return response()->json($ret);
  // return $ret;

}


public static function create_actor($scene_id,$actor_id,$actor_birth_date,$actor_PESEL,$actor_name,$actor_sex,$actor_incoming_date,$actor_incoming_recalculate,$actor_nn,$actor_role_name,$actor_history_for_actor,$actor_simulation)
  {
    $SceneActor = new SceneActor();

    $SceneActor->scene_master_id = $scene_id;

    $secondDate = new DateTime(date('Y-m-d 00:00:00'));
    $firstDate = new DateTime(date('Y-m-d H:i:s',strtotime($actor_birth_date)));

    $ret['losowanie']=json_decode(SceneActor::random_actor($firstDate->format('Y-m-d'),$actor_sex),true);

    // $ret['diff'] = $firstDate->diff($secondDate);
    $ret['years'] = $firstDate->diff($secondDate)->y;
    $ret['months'] = $firstDate->diff($secondDate)->m;
    $ret['days'] = $firstDate->diff($secondDate)->d;
        
    if ($ret['years']>2)
      $SceneActor->sa_age_txt= $ret['years'].' l.';
    elseif ($ret['years']>0)
      $SceneActor->sa_age_txt= $ret['years'].' l '.$ret['months'].' m.';
    elseif ($ret['months']>5)
      $SceneActor->sa_age_txt= $ret['months'].' m.';
    elseif ($ret['months']>0)
      $SceneActor->sa_age_txt= $ret['months'].' m. '.$ret['days'].' d.';
    else
      $SceneActor->sa_age_txt= $ret['days'].' d.';

    $SceneActor->actor_id = $actor_id;
    $SceneActor->sa_incoming_date = $actor_incoming_date;
    $SceneActor->sa_incoming_recalculate = $actor_incoming_recalculate;
    do
    {
      $SceneActor->sa_main_book = str_pad(rand(date('z')*30,date('z')*35), 5, 0, STR_PAD_LEFT).'/medUJK/'.date('y');
    }
    while (SceneActor::where('sa_main_book',$SceneActor->sa_main_book)->count() > 0);

    if ($actor_name=="")
      $SceneActor->sa_name = $ret['losowanie']['name'];
    else
      $SceneActor->sa_name = $actor_name;
    $SceneActor->sa_birth_date = $firstDate->format('Y-m-d H:i:s');
    $SceneActor->sa_age = (strtotime(date('Y-m-d H:i:s')) - strtotime($actor_birth_date))/(60*60*24);
    // sa_age_txt
    if ($actor_PESEL=="")
      $SceneActor->sa_PESEL = $ret['losowanie']['PESEL'];
    else
      $SceneActor->sa_PESEL = $actor_PESEL;
    $SceneActor->sa_actor_sex = $ret['losowanie']['actor_sex'];
    $SceneActor->sa_actor_nn = $actor_nn;
    $SceneActor->sa_actor_role_name = $actor_role_name;
    $SceneActor->sa_history_for_actor = $actor_history_for_actor;
    $SceneActor->sa_actor_simulation = $actor_simulation;

    $SceneActor->save();
  } // end of public static function


}