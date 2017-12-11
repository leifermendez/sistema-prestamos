<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class trackerController extends Controller
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
        return view('supervisor_tracker.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id_agent;
        return view('supervisor_tracker.create');
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
    public function show(Request $request,$id)
    {
        $date = $request->date_start;

        if(!isset($date)){return 'Fecha Vacia';};

        $data_summary = db_summary::whereDate('summary.created_at','=',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('credit.id_agent',$id)
            ->join('credit','summary.id_credit','=','credit.id')
            ->join('users','credit.id_user','=','users.id')
            ->select(
                'users.name',
                'users.last_name',
                'credit.payment_number',
                'credit.amount_neto',
                'credit.id as id_credit',
                'summary.number_index',
                'summary.amount',
                'summary.created_at',
                DB::raw('SUM(summary.amount) as total_payment')
            )
            ->groupBy('summary.id')
            ->get();



        $data_credit = db_credit::whereDate('credit.created_at','=',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('credit.id_agent',$id)
            ->join('users','credit.id_user','=','users.id')
            ->select(
                'credit.id as credit_id',
                'users.id',
                'users.name',
                'users.last_name',
                'users.province',
                'credit.created_at',
                'credit.utility',
                'credit.payment_number',
                'credit.amount_neto')
            ->get();

        $data_bill = db_bills::whereDate('created_at',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('id_agent',$id)
            ->get();

        $data = array(
            'summary' => $data_summary,
            'credit' => $data_credit,
            'bills' => $data_bill,
            'total_summary' => $data_summary->sum('amount'),
            'total_credit' => $data_credit->sum('amount_neto')
        );

        return view('supervisor_tracker.summary',$data);
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
