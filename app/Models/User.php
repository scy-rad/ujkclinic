<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\MyResetPassword;
use Session;

class User extends Authenticatable   // 8 checked - except update_avatar function
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        // to add costom reset password mail template:
        // https://stackoverflow.com/questions/39327954/laravel-5-3-redefine-reset-email-blade-template
        $this->notify(new MyResetPassword($token));
    }

    public function roles() {
        return $this->belongsToMany(UserRole::class, 'user_has_roles', 'user_id', 'role_id');
    }
    public function phones() {
        return $this->hasMany(UserPhone::class);//->get();
    }
    public function scenarios() {
      return $this->hasMany(Scenario::class);
    }
    public function personel_scenes() {
      return $this->hasMany(ScenePersonel::class);
    }

    public function title() {
        return $this->belongsTo(UserTitle::class, 'user_title_id');//->first();
    }

    public function full_name() {
        return $this->belongsTo(UserTitle::class, 'user_title_id')->first()->user_title_short.' '.$this->lastname.' '.$this->firstname;
    }

    public static function role_users($role_code, $user_status) {
        $role_id=UserRole::select('id')->where('role_code', $role_code)->first()->id;
        $roles_users=UserHasRole::select('user_id')->where('role_id','=',$role_id)->get();
        $users = User::whereIn('id',$roles_users)
                    ->where('user_status',$user_status);
                    // ->orderBy('lastname')
                    // ->orderBy('firstname')
                    // ->orderBy('id');
        return $users;
        }

    public static function json_role_users($role_code, $user_status) {
        $role_id=UserRole::select('id')->where('role_code', $role_code)->first()->id;
        $roles_users=UserHasRole::select('user_id')->where('role_id','=',$role_id)->get();
        $users = User::whereIn('id',$roles_users)
                    ->where('user_status',$user_status)->orderBy('lastname')
                    ->orderBy('firstname')
                    ->orderBy('id');

        $data=[];
        foreach ($users->get() as $rowuser)
            {
                $data[] = [
                    'id' => $rowuser->id,
                    'text' => $rowuser->full_name()
                ];
            }
        return json_encode($data);
    }

    public static function find_user($fullname)
    {
        //funkcja wukorzystywana przez kontroler ManSimmed

        $firstname='';
        $lastname='';
        $title='';

        $pozostalo_do_analizy=$fullname;

        if (strpos($pozostalo_do_analizy, ' ', 0)>0)
        {
            $firstname              =   substr($pozostalo_do_analizy,strRpos($pozostalo_do_analizy, ' ', 0)+1,100);
            $pozostalo_do_analizy   =   substr($pozostalo_do_analizy,0,strRpos($pozostalo_do_analizy, ' ', 0));
            $lastname               =   $pozostalo_do_analizy;
        }
        if (strpos($pozostalo_do_analizy, ' ', 0)>0)
        {
            $lastname               =   substr($pozostalo_do_analizy,strRpos($pozostalo_do_analizy, ' ', 0)+1,100);
            $pozostalo_do_analizy   =   substr($pozostalo_do_analizy,0,strRpos($pozostalo_do_analizy, ' ', 0));
            $title                  =   $pozostalo_do_analizy;
        }

        if (($lastname)!='')//jeśli nazwa składa się conajmniej z dwóch członów - to szukaj tej osoby w bazie danych
        {
            if (UserTitle::where('user_title_short',$title)->first()!==NULL)
            {
                $user = User::where('user_title_id',UserTitle::where('user_title_short',$title)->first()->id)
                        ->where('lastname',$lastname)
                        ->where('firstname',$firstname);
                if ($user->first()!==NULL)
                    return $user->first()->id;

                $user = User::where('user_title_id',UserTitle::where('user_title_short',$title)->first()->id)
                        ->where('lastname',$firstname)
                        ->where('firstname',$lastname);
                if ($user->first()!==NULL)
                    return $user->first()->id;
            }

            $user = User::where('lastname',$lastname)
                    ->where('firstname',$firstname);
            if ($user->first()!==NULL)
            {
                if (UserTitle::where('user_title_short',$title)->first()!==NULL)
                    echo 'inny tytuł naukowy: '.$title.' '.$firstname.' '.$lastname.'<br>';
                return $user->first()->id;
            }

            $user = User::where('lastname',$firstname)
                    ->where('firstname',$lastname);
            if ($user->first()!==NULL)
            {
                if (UserTitle::where('user_title_short',$title)->first()!==NULL)
                    echo 'inny tytuł naukowy + zamiana imienia i nazwiska: '.$title.' '.$firstname.' '.$lastname.'<br>';
                return $user->first()->id;
            }
        }
       return 0; //jeśli nazwa składa się tylko z jednego członu - zwróć 0
    }


    public function add_role($role_id) {
        $rhu = New UserHasRole();
        $rhu->user_id = $this->id;
        $rhu->role_id = $role_id;
        return $rhu->save();
    }

    public function add_phone($phone_number, $phone_type, $phone_for) {
        $rhu = New UserPhone();
        $rhu->user_id = $this->id;
        $rhu->phone_number = $phone_number;
        $rhu->user_phone_type_id = $phone_type;
        $rhu->phone_for_coordinators = $phone_for[0];
        $rhu->phone_for_technicians = $phone_for[1];
        $rhu->phone_for_trainers = $phone_for[2];
        $rhu->phone_for_guests = $phone_for[3];
        $rhu->phone_for_anonymouse = $phone_for[4];
        return $rhu->save();
    }

    public function update_mail($email) {
        $this->email=$email;
        return $this->save();
    }

    public function update_title($title_id) {
        $this->user_title_id=$title_id;
        return $this->save();
    }

    public function update_status($user_status) {
        $this->user_status=$user_status;
        return $this->save();
    }

    public function update_about($user_about) {
        $this->about=$user_about;
        return $this->save();
    }
    
    public function update_view($request) {
        $this->home_own_days=$request->home_own_days;
        $this->home_second_module=$request->home_second_module;
        $this->home_todo_module=$request->home_todo_module;
        return $this->save();
    }

    public function update_personal($user_data) {
        $this->user_title_id=$user_data->user_title_id;
        $this->name=$user_data->name;
        $this->firstname=$user_data->firstname;
        $this->lastname=$user_data->lastname;
        return $this->save();
    }
    
    public function update_additional($user_data) {
      
      $this->time_begin=$user_data->time_begin;
      
      return $this->save();
  }

    public static function nobody() {
        return User::where('lastname', '=', '_Nikt')
        ->get()->first();
    }


    public function update_avatar($request)
    {
        $request->validate([
            'fotka' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $avatarName = $this->id.'_avatar'.time().'.'.request()->fotka->getClientOriginalExtension();
        
        // $avatarName = 'user_'.sprintf('%05d', $this->id).'.'.request()->fotka->getClientOriginalExtension();
        
        $original_dimensions = getimagesize($request->fotka);
        
        $width = $original_dimensions[0];
        $height = $original_dimensions[1];
        $width_offset = 0;
        $height_offset = 0;
        

        if (($width*8/6)>$height)
        {
            // dump('za szerokie');
            $new_width = $height*6/8;
            $new_height = $height;
            $width_offset = ($width - $new_width)/2;
        }
        elseif (($width*8/6)<$height)
        {
            // dump('za wąskie');
            $new_width = $width;
            $new_height = $width*8/6;
            $height_offset = ($height - $new_height)/2;
        }

        $new_width = 600;
        $new_height = 800;

        Session::flash('error', 'DUŻY problem - funkcje PHP nie dostępne w PHP 8.1 (lub konfiguracja) - model User.php');

        
        // $txt='przekształcam obrazek '.$width.'x'.$height.'px na obrazek '.$new_width.'x'.$new_height.'px.';


        // $small = imagecreatetruecolor($new_width, $new_height);
        // $source = imagecreatefromjpeg($request->fotka);
        // imagecopyresampled($small, $source, 0, 0, $width_offset, $height_offset, $new_width, $new_height, ($width-$width_offset*2), ($height-$height_offset*2));

        // imagejpeg($small,'storage/avatars/'.$avatarName);


        // if (file_exists(base_path().$this->user_fotka))
        //     unlink(base_path().$this->user_fotka);
        // else
        //     dump('sprawdź usuwanie pliku - model user, linia 270...: '.base_path().$this->user_fotka);
        // $this->user_fotka = '/storage/avatars/'.$avatarName;

        // return $this->save();
    }


    public function remove_role($role_id) {
        return UserHasRole::where('user_id', '=', $this->id)
        ->where('role_id','=',$role_id)
        ->delete();
    }


    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRoleCode($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRoleCode($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRoleCode($role)
    {
        if ($this->roles()->where('role_code', $role)->first()) {
            return true;
        }
        return false;
    }
}