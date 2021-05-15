<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_audit;
use App\db_bills;
use App\db_close_day;
use App\db_credit;
use App\db_list_bills;
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
        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor', Auth::id())
            ->join('users', 'agent_has_supervisor.id_user_agent', '=', 'users.id')
            ->get();

        foreach ($data as $datum) {
            $datum->show = true;
            $datum->wallet_name = db_wallet::where('id', $datum->id_wallet)->first()->name;
            $summary = db_summary::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_agent', $datum->id_user_agernt)
                ->exists();

            if ($summary) {
                $datum->show = true;
            }

            $credit = db_credit::whereDate('created_at', '=', Carbon::now()->toDateString())
                ->where('id_agent', $datum->id_user_agernt)
                ->exists();

            if ($credit) {
                $datum->show = true;
            }

            $close_day = db_close_day::where('id_agent', $datum->id_user_agent)
                ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->exists();
            if ($close_day) {
                $datum->show = false;
            }

        }

        $data = array(
            'clients' => $data,
            'today' => Carbon::now()->toDateString(),

        );

        return view('supervisor_agent.indexclose', $data);

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = db_bills::whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('id_agent', $id)->first();

        if(isset($wallet->id_wallet)) {
            $bills = db_bills::whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('id_wallet', $wallet->id_wallet)
            ->sum('amount');
        } else {$bills = 0;}

        $base_amount = db_supervisor_has_agent::where('id_user_agent', $id)->first()->base;
        $today_amount = db_summary::whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('id_agent', $id)
            ->sum('amount');
        $today_sell = db_credit::whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('id_agent', $id)
            ->sum('amount_neto');
        
        $total = floatval($base_amount + $today_amount) - floatval($today_sell + $bills);
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

        return view('supervisor_agent.close', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $total = $request->total_today;
        $base_total = $request->base_amount_total;

        if (!isset($total)) {
            return 'Total vacio';
        };
        if (!isset($base_total)) {
            return 'Base vacio';
        };

        $agent_data = db_supervisor_has_agent::where('id_user_agent', $id)
            ->where('id_supervisor', Auth::id())
            ->first();

        db_supervisor_has_agent::where('id_user_agent', $id)
            ->where('id_supervisor', Auth::id())
            ->update(['base' => $total]);

        $values = array(
            'id_agent' => $id,
            'id_wallet' => $agent_data->id_wallet,
            'id_supervisor' => Auth::id(),
            'created_at' => Carbon::now(),
            'total' => $total,
            'base_before' => $base_total,
            //'from_number' =>
        );
        db_close_day::insert($values);


        $user_audit = User::where('users.id', $id)->select(
            'name',
            'last_name'
        )->first();
        $wallet_audit = db_wallet::find($agent_data->id_wallet);

        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode( array(
                'id_agent' => $id,
                'agent' => $user_audit->name.' '.$user_audit->last_name,
                'id_wallet' => $agent_data->id_wallet,
                'wallet' => $wallet_audit->name,
                'id_supervisor' => Auth::id(),
                'created_at' => Carbon::now(),
                'total' => $total,
                'base_before' => $base_total,
            )),
            'event' => 'update',
            'device' => $request->device,
            'type' => 'Cierre de dia'
        );
        db_audit::insert($audit);

        return redirect('supervisor/close');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function close_automatic()
    {
        
    }
}
