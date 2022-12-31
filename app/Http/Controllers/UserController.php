<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserHasRole;
use App\Models\UserPhone;

use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
  public function users(String $type)   // 8 checked
  {

    if ($type == 'everybody') {
      if (!Auth::user()->hasRoleCode('hroperators'))
        return view('error', ['head' => 'błąd wywołania funkcji users kontrolera User', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
      $users = User::orderBy('lastname', 'ASC');
      if (!(Auth::user()->hasRoleCode('administrators')))
        $users = $users->where('user_status', '=', 1);
      // $users = $users->paginate(6);
    } else {
      $role_id = Role::select('id')->where('role_code', $type)->first()->id;
      $roles_users = UserHasRole::select('user_id')->where('role_id', '=', $role_id)->get();
      $users = User::whereIn('id', $roles_users);
      if (!(Auth::user()->hasRoleCode('administrators')))
        $users = $users->where('user_status', '=', 1);
      $users = $users->orderBy('lastname', 'ASC');
      // $users = $users->->paginate(6);
    }
    $users = $users->get();
    return view('users/users', compact('users'));
  } // end of public function users

  public function mainprofile()   // 8 checked
  {
    $ret['user'] = Auth::user();
    $ret['isAdmin'] = (Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators'));
    if ((!$ret['isAdmin']) && ($ret['user']->user_status == 0))
      return back()->withErrors(['Brak uprawnień do przeglądania tego profilu...']);

    if (Auth::user()->id == $ret['user']->id)
      $ret['isOwn'] = True;
    else
      $ret['isOwn'] = False;

    return view('users/userprofile', $ret);
  } // end of public function mainprofile

  public function userprofile(Int $id_user)   // 8 checked
  {
    $ret['user'] = User::where('id', $id_user);
    $ret['isAdmin'] = (Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators'));
    if ((!$ret['isAdmin']) && ($ret['user']->first()->user_status == 0))
      return back()->withErrors(['Brak uprawnień do przeglądania tego profilu...']);

    if (!(Auth::user()->hasRoleCode('administrators')))
      $ret['user'] = $ret['user']->where('user_status', '=', 1);

    if (!((Auth::user()->hasRoleCode('hroperators')) ||
      (Auth::user()->hasRoleCode('technicians'))   || 
      (Auth::user()->hasRoleCode('coordinators'))
      )) 
    {
      $role_id = Role::select('id')
        ->where('role_code', 'technicians')
        ->orWhere('role_code', 'instructors')
        ->orWhere('role_code', 'coordinators')
        ->pluck('id')
        ->toArray();
      $roles_users = UserHasRole::select('user_id')->whereIn('role_id', $role_id)->pluck('user_id')->toArray();
      $ret['user'] = $ret['user']->whereIn('id', $roles_users);
    }

    if ($ret['user']->count() == 0)
      return back()->withErrors(['Profil, który chesz oglądać jest dla Ciebie niedostępny...']);

    if (Auth::user()->id == $ret['user']->first()->id)
      $ret['isOwn'] = True;
    else
      $ret['isOwn'] = False;

    $ret['user'] = $ret['user']->first();

    return view('users/userprofile', $ret);
  } // end of public function userprofile

  public function change(Request $request)    // 8 checked
  {
    switch ($request->action)
    {
    case 'update_avatar':
          if (!(Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators') || (User::find($request->user_id)->id == Auth::user()->id)))
            return view('error', ['head' => 'błąd wywołania funkcji update_avatar kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = Auth::user();
          if (($user->hasRoleCode('administrators')) || ($user->hasRoleCode('coordinators')) || ($user->hasRoleCode('simoperators')))
            $user = User::where('id', $request->user_id)->first();
          if ($user->update_avatar($request))
            return back()->with('success', 'Zmiana zdjęcia zakończona powodzeniem.');
          else
            return back()->withErrors(['update_avatar', 'Niestety - zmiana zdjęcia nie powiodła się']);
      break;
    
    case 'change_home_view':
          if (!(Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators') || (User::find($request->user_id)->id == Auth::user()->id)))
            return view('error', ['head' => 'błąd wywołania funkcji change_home_view kontrolera userprofile', 'title' => 'brak uprawnień ', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = User::where('id', $request->user_id)->first();
          if ($user->update_view($request))
            return back()->with('success', 'Zmiana widoku powiodła się.');
          else
            return back()->withErrors('Zmiana widoku niestety nie powiodła się...');
      break;
    
    case 'remove_role':
          if (!Auth::user()->hasRoleCode('hroperators') && !Auth::user()->hasRoleCode('administrators'))
            return view('error', ['head' => 'błąd wywołania funkcji remove_role kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = User::where('id', $request->user_id)->first();
          if ($user->remove_role($request->role_id, 1))
            return back()->with('success', 'Usuwanie roli powiodło się.');
          else
            return back()->withErrors(['Usuwanie roli nie powiodło się']);
      break;
      
    case 'change_password':
          if (!Auth::user()->hasRoleCode('hroperators') && !Auth::user()->hasRoleCode('administrators'))
            return view('error', ['head' => 'błąd wywołania funkcji change_password kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr lub Administratorem']);
          $user = User::where('id', $request->user_id)->first();
          if ($request->password == $request->passwordre)
            if (strlen($request->password) >= 8) {
              $user->password = bcrypt($request->password);
              if ($user->save())
                return back()->with('success', 'Zmiana hasła powiodła się.');
              else
                return back()->withErrors('Zmiana hasła niestety nie powiodła się...');
            } else
              return back()->withErrors('Hasło jest zbyt krókie (minimum 8 znaków)...');
          else
            return back()->withErrors('Hasła różnią się od siebie...');
      break;

    case 'change_status':
          if (!Auth::user()->hasRoleCode('hroperators') && !Auth::user()->hasRoleCode('administrators'))
            return view('error', ['head' => 'błąd wywołania funkcji change_status kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = User::where('id', $request->user_id)->first();
          if ($user->update_status($request->user_status))
            return back()->with('success', 'Zmiana statusu powiodła się.');
          else
            return back()->withErrors('Zmiana statusu niestety nie powiodła się...');
      break;

    case 'add_role' :
          if (!Auth::user()->hasRoleCode('hroperators') && !Auth::user()->hasRoleCode('administrators'))
            return view('error', ['head' => 'błąd wywołania funkcji add_role kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr lub Administratorem']);

          $user = User::where('id', $request->user_id)->first();
          $user->add_role($request->role_id);
          return back()->with('success', 'Dodanie roli powiodło się.');
          break;

    case 'change_phone':
          if (!(Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators') || (User::find($request->user_id)->id == Auth::user()->id)))
            return view('error', ['head' => 'błąd wywołania funkcji change_phone kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          function onof($what)
          {
            if (($what == "on") || ($what == "1")) return 1;
            else return 0;
          }
          if ($request->id_phone == 0)
          {
            $user = User::where('id', $request->user_id)->first();
            $ret = $user->add_phone($request->phone_number, $request->user_phone_type_id, [onof($request->phone_for_coordinators), onof($request->phone_for_technicians), onof($request->phone_for_trainers), onof($request->phone_for_guests), onof($request->phone_for_anonymouse)]);
            $comment = 'Dodawanie';
          } 
          else 
          {
            $UserPhone = UserPhone::where('id', $request->id_phone)->first();
            if ($request->phone_number == '') {
              $ret = $UserPhone->remove_phone();
              $comment = 'Usuwanie';
            } 
            else
            {
              $ret = $UserPhone->update_phone($request->user_phone_type_id, $request->phone_number, [onof($request->phone_for_coordinators), onof($request->phone_for_technicians), onof($request->phone_for_trainers), onof($request->phone_for_guests), onof($request->phone_for_anonymouse)]);
              $comment = 'Edytowanie';
            }
          }
          if ($ret)
            return back()->with('success', $comment . ' numeru telefonu zakończone sukcesem.');
          else
            return back()->withErrors($comment . ' numeru telefonu zakończone niepowodzeniem...');
      break;

    case 'change_email':
          if (!(Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators') || (User::find($request->user_id)->id == Auth::user()->id)))
            return view('error', ['head' => 'błąd wywołania funkcji change_email kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = User::where('id', $request->user_id)->first();
          if ($user->update_mail($request->email))
            return back()->with('success', 'Edycja maila powiodła się.');
          else
            return back()->withErrors('zmiana Maila niestety nie powiodła się...');
      break;

    case 'change_about':
          if (!(Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators') || (User::find($request->user_id)->id == Auth::user()->id)))
            return view('error', ['head' => 'błąd wywołania funkcji change_about kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = User::where('id', $request->user_id)->first();
          if ($user->update_about($request->about))
            return back()->with('success', 'Zmiana informacji powiodła się.');
          else
            return back()->withErrors('Zmiana informacji niestety nie powiodła się...');
      break;

    case 'update_personal':
          if (!Auth::user()->hasRoleCode('hroperators') && !Auth::user()->hasRoleCode('administrators'))
            return view('error', ['head' => 'błąd wywołania funkcji update_personal kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
          $user = User::where('id', $request->user_id)->first();
          if ($user->update_personal($request))
            return back()->with('success', 'Zmiana danych osobowych powiodła się.');
          else
            return back()->withErrors('Zmiana danych osobowych niestety nie powiodła się...');
      break;

    case 'update_additional':
        if (!(Auth::user()->hasRoleCode('hroperators') || Auth::user()->hasRoleCode('administrators') || (User::find($request->user_id)->id == Auth::user()->id)))
          return view('error', ['head' => 'błąd wywołania funkcji update_additional kontrolera userprofile', 'title' => 'brak uprawnień', 'description' => 'aby wykonać to działanie musisz być Operatorem Kadr']);
        $user = User::where('id', $request->user_id)->first();
        if ($user->update_additional($request))
          return back()->with('success', 'Zmiana dodatkowych danych powiodła się.');
        else
          return back()->withErrors('Zmiana dodatkowych danych niestety nie powiodła się...');
      break;

    default:
    dd($request);
      $ret=print_r($request);
    }

  } // end of public function add_role

  public function showChangePasswordForm()
  {
    return view('auth.changepassword');
  } // end of public function showChangePasswordForm

  public function changePassword(Request $request)
  {
    if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
      // The passwords matches
      return redirect()->back()->with("error", "Twoje hasło nie spełnia minimalnych wymagań. Spróbuj ponownie...");
    }

    if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
      //Current password and new password are same
      return redirect()->back()->with("error", "Nowe hasło nie może być takie same jak poprzednio. Postaraj się lepiej...");
    }

    $validatedData = $request->validate([
      'current-password' => 'required',
      'new-password' => 'required|string|min:6|confirmed',
    ]);

    //Change Password
    $user = Auth::user();
    $user->password = bcrypt($request->get('new-password'));
    $user->save();

    return redirect()->back()->with("success", "No i udało się zmienić hasło !");
  } // end of public function changePassword

  public function ajax_update_notify(Request $request)    // 8 checked
  {
    $status = DB::table('users')
      ->where('id', $request->user_id)
      ->update(['simmed_notify' => $request->simmed_notify]);

    return json_encode(array('statusCode' => $request->user_id, 'SQLcode' => $status));
  } // end of public function ajax_update_notify
}
