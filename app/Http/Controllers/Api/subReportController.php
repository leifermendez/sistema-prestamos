<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_close_day;
use App\db_credit;
use App\db_summary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class subReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $id_wallet = $request->id_wallet;

        if(!isset($date_start)){return 'Fecha Inicio';};
        if(!isset($date_end)){return 'Fecha Final';};
        if(!isset($id_wallet)){return 'ID wallet';};

        $data = db_close_day::whereDate('close_day.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('close_day.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->where('id_supervisor',Auth::id())
            ->join('users','close_day.id_agent','=','users.id')
            ->join('credit','users.id','=','credit.id_agent')
            ->select(
                'close_day.created_at',//fecha de cierre
                'close_day.base_before',//base
                'close_day.total as total_day',//cierre
                'close_day.id',
                'close_day.id_agent',
                DB::raw('SUM(credit.amount_neto) as credit_total'),//creditos

                DB::raw('SUM(credit.utility) as credit_utility')//%diario
            )
            ->groupBy('close_day.id')
            ->get();

        foreach ($data as $datum){
            $datum->summary_total = round(db_summary::whereDate('created_at','=',Carbon::parse($datum->created_at)->toDateString())
                ->where('id_agent',$datum->id_agent)
                ->sum('amount'),2);
            $datum->bills_total = db_bills::whereDate('created_at','=',Carbon::parse($datum->created_at)->toDateString())
                ->where('id_agent',$datum->id_agent)
                ->sum('amount');
            $datum->credit_total = db_credit::whereDate('created_at','=',Carbon::parse($datum->created_at)->toDateString())
                ->where('id_agent',$datum->id_agent)
                ->sum('amount_neto');
            $datum->supervisor_bills = db_bills::whereDate('created_at','=',Carbon::parse($datum->created_at)->toDateString())
                ->where('id_wallet',$id_wallet)->whereNull('id_agent')
                ->sum('amount');
            $datum->base_wallet = ($datum->base_before+$datum->summary_total)-($datum->credit_total+$datum->bills_total+$datum->supervisor_bills);
        }

        $data = array(
            'credit' => $data,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'id_wallet' => $id_wallet
        );
//(base+recaudo)-(creditos+gastos)
        return view('submenu.report.index',$data);
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
        return view('submenu.report.create',array('id_wallet'=>$id));
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
