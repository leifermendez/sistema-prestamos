<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_close_day;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\db_wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class closeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor',Auth::id())
            ->join('users','agent_has_supervisor.id_user_agent','=','users.id')
            ->get();

        foreach ($data as $datum){
            $datum->show = true;
            $datum->wallet_name = db_wallet::where('id',$datum->id_wallet)->first()->name;
            $summary=db_summary::whereDate('created_at','=',Carbon::now()->toDateString())
                ->where('id_agent',$datum->id_user_agernt)
                ->exists();

            if($summary){
                $datum->show = true;
            }

            $credit=db_credit::whereDate('created_at','=',Carbon::now()->toDateString())
                ->where('id_agent',$datum->id_user_agernt)
                ->exists();

            if($credit){
                $datum->show = true;
            }

            $close_day=db_close_day::where('id_agent',$datum->id_user_agent)
                ->whereDate('created_at','=',Carbon::now()->toDateString())
                ->exists();
            if($close_day){
                $datum->show = false;
            }

        }


        $data = array(
            'clients' => $data,
            'today' => Carbon::now()->toDateString(),

        );

        return view('supervisor_agent.indexclose',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

            $base_amount = db_supervisor_has_agent::where('id_user_agent',$id)->first()->base;
            $today_amount = db_summary::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_agent',$id)
                ->sum('amount');
            $today_sell = db_credit::whereDate('created_at','=',Carbon::now()->toDateString())
                ->where('id_agent',$id)
                ->sum('amount_neto');
            $bills = db_bills::whereDate('created_at','=',Carbon::now()->toDateString())
                ->sum('amount');
            $total = floatval($base_amount+$today_amount)-floatval($today_sell+$bills);
            $average = 1000;

            $data = array(
                'base' => $base_amount,
                'today_amount' => $today_amount,
                'today_sell' => $today_sell,
                'bills' => $bills,
                'total' => $total,
                'average' => $average,
                'user' => User::find($id)
            );


        return view('supervisor_agent.close',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $total = $request->total_today;
        $base_total = $request->base_amount_total;

        if(!isset($total)){return 'Total vacio';};
        if(!isset($base_total)){return 'Base vacio';};

        db_supervisor_has_agent::where('id_user_agent',$id)
            ->where('id_supervisor',Auth::id())
            ->update(['base'=>$total]);

        $values = array(
            'id_agent' => $id,
            'id_supervisor' => Auth::id(),
            'created_at' => Carbon::now(),
            'total' => $total,
            'base_before' => $base_total,
            //'from_number' =>
        );
        db_close_day::insert($values);

        return redirect('supervisor/close');
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

    public function close_automatic(){
        $data_agents = db_supervisor_has_agent::all();

        foreach ($data_agents as $d){

            $base_amount = db_supervisor_has_agent::where('id_user_agent',$d->id_user_agent)->first()->base;
            $today_amount = db_summary::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_agent',$d->id_user_agent)
                ->sum('amount');
            $today_sell = db_credit::whereDate('created_at','=',Carbon::now()->toDateString())
                ->where('id_agent',$d->id_user_agent)
                ->sum('amount_neto');
            $bills = db_bills::whereDate('created_at','=',Carbon::now()->toDateString())
                ->sum('amount');
            $total = floatval($base_amount+$today_amount)-floatval($today_sell+$bills);


            db_supervisor_has_agent::where('id_user_agent',$d->id_user_agent)
                ->where('id_supervisor',Auth::id())
                ->update(['base'=>$total]);

            $values = array(
                'id_agent' => $d->id_user_agent,
                'id_supervisor' => Auth::id(),
                'created_at' => Carbon::now(),
                'total' => $total,
                'base_before' => $base_amount,

            );

            if(!db_close_day::whereDate('created_at','=',Carbon::now()->toDateString())->exists()){
                db_close_day::insert($values);
            }

        }
        return response()->json([
            'status' => 'success',
            'msj' => 'Cierre realizado'
        ]);
    }
}
