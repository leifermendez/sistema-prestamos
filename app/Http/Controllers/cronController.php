<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
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

class cronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_agents = db_supervisor_has_agent::all();

        foreach ($data_agents as $d) {

            $base_amount = db_supervisor_has_agent::where('id_user_agent', $d->id_user_agent)->first()->base;
            $id_wallet = db_bills::whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('id_agent', $d->id_user_agent)->first()->id_wallet;

            $today_amount = db_summary::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_agent', $d->id_user_agent)
                ->sum('amount');
            $today_sell = db_credit::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_agent', $d->id_user_agent)
                ->sum('amount_neto');
            $bills = db_bills::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_wallet', $id_wallet)
                ->sum('amount');
            $total = floatval($base_amount + $today_amount) - floatval($today_sell + $bills);

            db_supervisor_has_agent::where('id_user_agent', $d->id_user_agent)
                ->where('id_supervisor', Auth::id())
                ->update(['base' => $total]);

            $values = array(
                'id_agent' => $d->id_user_agent,
                'id_wallet' => $id_wallet,
                'id_supervisor' => Auth::id(),
                'created_at' => Carbon::now(),
                'total' => $total,
                'base_before' => $base_amount,
            );

            db_close_day::insert($values);

        }
        return response()->json([
            'status' => 'success',
            'msj' => 'cierres realizado con exito'
        ]);
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
        //
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
