<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\db_wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class statisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('users','id_user_agent','=','users.id')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                'users.*',
                'wallet.name as wallet_name'
            )
            ->get();
        $data = array(
            'clients' => $data,
            'today' => Carbon::now()->toDateString(),

        );
        return view('supervisor_statistics.agents',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('supervisor_statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $data = db_supervisor_has_agent::where('id_user_agent',$id)->first();
        $data = db_wallet::where('id',$data->id_wallet)->first();
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $summary = db_summary::where('id_agent',$id)
            ->whereDate('created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->sum('amount');

        $credit = db_credit::where('id_agent',$id)
            ->whereDate('created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->sum('amount_neto');

        $bills = db_bills::where('id_agent',$id)
            ->whereDate('created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->sum('amount');

        $days = Carbon::createFromFormat('d/m/Y',$date_start)->subDay();
        $days= $days->diffInDays(Carbon::createFromFormat('d/m/Y',$date_end));

        $data = array(
            'summary' => $summary,
            'credit' => $credit,
            'bills' => $bills,
            'days' => $days,
            'wallet' => $data,
            'range' => 'Desde '.$date_start.' hasta '.$date_end
        );

        return view('supervisor_statistics.show',$data);
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
