<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\LaboratoryOrder;
use App\Models\LaboratoryOrderGroup;
use App\Models\SceneActor;
use App\Models\SceneActorLabOrder;
use App\Models\SceneActorLabResult;
use App\Models\SceneActorLabResultTemplate;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

      $order=SceneActorLabOrder::where('id',1)->first();
      $ret=$order->scene_actor_order_lab_results();
      return view('tests.test',['wynik' => $ret]);

    }
    public function index2()
    {
      $requestidvalue = 1;
      dump(SceneActorLabOrder::where('id',$requestidvalue)->get());

      $actor=SceneActorLabOrder::where('id',$requestidvalue)->first()->scene_actor;
      foreach (SceneActorLabResult::where('scene_actor_lab_order_id',$requestidvalue)->get() as $lo_one)
      {
        // $lo_one->
        dump($lo_one->lab_order->salo_date_order);
      //   dump($lo_one->laboratory_test->laboratory_test_norms()
      //   ->where('ltn_days_from','<=',$actor->sa_age)
      //   ->where('ltn_days_to','>=',$actor->sa_age)
      //   ->first()
      // );
      }

      $ret="sss";

        return view('tests.test2',['wynik' => $ret]);
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
