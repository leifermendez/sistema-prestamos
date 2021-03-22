<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_bills;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class subTransitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('submenu.transitions.create');
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
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        if(!isset($date_start)){return 'Fecha Inicio Vacia';};
        if(!isset($date_end)){return 'Fecha Final Vacia';};

        $data_credit = db_supervisor_has_agent::where('id_wallet',$id)
            ->join('credit','agent_has_supervisor.id_user_agent','=','credit.id_agent')
            ->join('users','credit.id_user','=','users.id')
            ->whereDate('credit.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('credit.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->select(
                'users.name',
                'users.last_name',
                'users.province',
                'credit.utility',
                'credit.amount_neto',
                'credit.created_at',
                'credit.id as credit_id',
                'credit.payment_number'
            )
            ->get();

        foreach ($data_credit as $d){
            $d->valor = (($d->amount_neto)+($d->amount_neto*$d->utility)-db_summary::where('id_credit',$d->credit_id)->sum('amount'));
        }

        $data_summary = db_supervisor_has_agent::where('id_wallet',$id)
            ->join('summary','agent_has_supervisor.id_user_agent','=','summary.id_agent')
            ->join('credit','summary.id_credit','=','credit.id')
            ->join('users','credit.id_user','=','users.id')
            ->whereDate('summary.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('summary.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->select(
                'credit.id as credit_id',
                'users.id',
                'users.name',
                'users.last_name',
                'users.province',
                'summary.number_index',
                'summary.amount',
                'credit.amount_neto',
                'credit.utility',
                'summary.created_at',
                'credit.id as credit_id'
                )
            ->get();

        foreach ($data_summary as $data){
            $data->total_summary = db_summary::where('id_credit',$data->credit_id)->sum('amount');
        }

        $data_bill = db_bills::whereDate('created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->join('list_bill','bills.type','=','list_bill.id')
            ->whereDate('created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->where('id_wallet',$id)
            ->select(
                'bills.*',
                'list_bill.name as type_bill'
            )
            ->get();


        $data = array(
            'summary' => $data_summary,
            'credit' => $data_credit,
            'bills' => $data_bill,
            'total_summary' => $data_summary->sum('amount'),
            'total_credit' => $data_credit->sum('amount_neto'),
            'total_bills' => $data_bill->sum('amount'),
            'id_wallet' => $id
        );

        return view('submenu.transitions.index',$data);
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
