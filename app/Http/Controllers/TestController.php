<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\SceneActor;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
    {


      $actor = Actor::where('id',1)->first();
      // dump($actor);
      $SceneActor = new SceneActor();

      $SceneActor->scene_master_id = 1; //$actor->scene_master_id;
      $SceneActor->sa_age=rand($actor->actor_age_from,$actor->actor_age_to);

          $secondDate = new DateTime(date('Y-m-d 00:00:00'));
          $firstDate = new DateTime(date('Y-m-d H:i:s',strtotime($secondDate->format('Y-m-d H:i:s').' - '.$SceneActor->sa_age.' days')));

          $ret['losowanie']=json_decode(SceneActor::random_actor($firstDate->format('Y-m-d'),1),true);

          // $ret['diff'] = $firstDate->diff($secondDate);
          $ret['years'] = $firstDate->diff($secondDate)->y;
          $ret['months'] = $firstDate->diff($secondDate)->m;
          $ret['days'] = $firstDate->diff($secondDate)->d;
          
      // $SceneActor->sa_age_txt
          if ($ret['years']>2)
            $SceneActor->sa_age_txt= $ret['years'].' l.';
          elseif ($ret['years']>0)
            $SceneActor->sa_age_txt= $ret['years'].' l '.$ret['months'].' m.';
          elseif ($ret['months']>5)
            $SceneActor->sa_age_txt= $ret['months'].' m.';
          elseif ($ret['months']>0)
            $SceneActor->sa_age_txt= $ret['months'].' m. '.$ret['days'].' d.';
          else
            {
            $ret['losowanie']['PESEL']='00000000000';
            $SceneActor->sa_age_txt= $ret['days'].' d.';
            if ($ret['days']==0)
              $firstDate = new DateTime(date('Y-m-d H:i:s',strtotime($firstDate->format('Y-m-d H:i:s').' + '.rand(0,(60*8-1)).' minutes')));
            else
              $firstDate = new DateTime(date('Y-m-d H:i:s',strtotime($firstDate->format('Y-m-d H:i:s').' + '.rand(0,(60*24-1)).' minutes')));
            $ret['days'] = $firstDate->diff($secondDate)->d;
            }

      
      $SceneActor->actor_id = $actor->id;
      $SceneActor->sa_incoming_date = $actor->actor_incoming_date;
      $SceneActor->sa_incoming_recalculate = $actor->actor_incoming_recalculate;      
      $SceneActor->sa_main_book = str_pad(rand(date('z')*30,date('z')*35), 5, 0, STR_PAD_LEFT).'/medUJK/'.date('y');
      $SceneActor->sa_name = $ret['losowanie']['name'];
      $SceneActor->sa_birth_date = $firstDate->format('Y-m-d H:i:s');
      // sa_age
      // sa_age_txt
      $SceneActor->sa_PESEL = $ret['losowanie']['PESEL'];
      $SceneActor->sa_actor_sex = $ret['losowanie']['actor_sex'];
      $SceneActor->sa_actor_nn = $actor->actor_nn;
      $SceneActor->sa_actor_role_name = $actor->actor_role_name;
      $SceneActor->sa_history_for_actor = $actor->history_for_actor;
      $SceneActor->sa_actor_simulation = $actor->actor_simulation;

      $SceneActor->save();
      $ret['SceneActor'] = $SceneActor;

      return view('tests.test',['wynik' => $ret]);

    }
    public function index2()
    {
        return view('tests.test2');
    }

    public function ajx_room_storages(Request $request)
    {        
        // $roomstorages = RoomStorage::where('room_id',$request->room_id)
        //                       ->orderBy('room_storage_sort')
        //                       ->get();
        // return response()->json([
        //     'roomstorages' => $roomstorages
        // ]);
    }

    
    public function ajx_shelf_count(Request $request)
    {
        // $shelf_count = RoomStorage::where('id',$request->room_storage_id)
        //                       ->first()->room_storage_shelf_count;
        // return response()->json([
        //     'shelf_count' => $shelf_count
        // ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

 //   echo '<h1>Store</h1>';
     //   dd($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Docs $doc)
    {
        //return view('docs.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docs $doc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
