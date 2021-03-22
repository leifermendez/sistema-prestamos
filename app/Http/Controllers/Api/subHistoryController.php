<?php

namespace App\Http\Controllers;

use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class subHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!isset($request->id_wallet)){
            return 'No existe ID Wallet';
        }
        
        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor',Auth::id())
            ->where('agent_has_supervisor.id_wallet',$request->id_wallet)
            ->join('credit','agent_has_supervisor.id_user_agent','=','credit.id_agent')
            ->join('users','credit.id_user','=','users.id')
            ->select('users.name',
                'users.last_name',
                'credit.amount_neto',
                'credit.payment_number',
                'credit.utility',
                'credit.id as credit_id')
            ->groupBy('users.id')
            ->get();


        foreach ($data as $datum){
            $datum->setAttribute('amount_neto',($datum->amount_neto)+($datum->amount_neto*$datum->utility));
            $datum->summary_total = $datum->amount_neto-(db_summary::where('id_credit',$datum->credit_id)
                ->sum('amount'));

            $datum->number_index = db_summary::where('id_credit',$datum->credit_id)
                    ->count();
        }

        $data_wallet = db_supervisor_has_agent::where('id_supervisor',Auth::id())
        ->where('agent_has_supervisor.id_wallet',$request->id_wallet)
        ->first();
        $total_summary = db_summary::where('id_agent',$data_wallet->id_user_agent)->sum('amount');
        $total_credit = db_credit::where('id_agent',$data_wallet->id_user_agent)->get();
        $total_credit_amount = 0;
        foreach ($total_credit as $cred){
            $total_credit_amount+=($cred->amount_neto)+($cred->amount_neto*$cred->utility);
        }
        $total_rest = ($total_credit_amount-$total_summary);


        $data = array(
            'clients' => $data,
            'total' => $total_summary,
            'total_rest' => $total_rest,
            'total_credit' => $total_credit_amount,
            'id_wallet' => $data_wallet->id
        );

        return view('submenu.history.index',$data);
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
        $id_credit = $id;

        if(!isset($id_credit)){
            return 'ID Credito Vacio';
        }else{
            if(!db_credit::where('id',$id_credit)->exists()){
                return 'ID No existe';
            }
        }
        $id_agent = db_supervisor_has_agent::where('id_supervisor',Auth::id())->first()->id_user_agent;
        $sql[]=['id_agent','=',$id_agent];
        if(isset($id_credit)){
            $sql[]=['id_credit','=',$id_credit];
        }
        $data_credit = db_credit::find($id_credit);
        $tmp = db_summary::where($sql)->get();
        $amount = floatval(db_credit::find($id_credit)->amount_neto)+floatval(db_credit::find($id_credit)->amount_neto*db_credit::find($id_credit)->utility);
        foreach ($tmp as $t){

            $amount-= $t->amount;
            $t->rest = $amount;
        }
        $data_credit->utility_amount = floatval($data_credit->utility*$data_credit->amount_neto);
        $data_credit->utility = floatval($data_credit->utility*100);
        $data_credit->payment_amount = (floatval($data_credit->amount_neto+$data_credit->utility_amount)/floatval($data_credit->payment_number));

        $data_credit->total = floatval($data_credit->utility_amount+$data_credit->amount_neto);
        $data = array(
            'clients' => $tmp,
            'credits' => db_credit::where('id_user',$data_credit->id_user)->orderBy('id','desc')->get(),
            'user' =>  User::find(db_credit::find($id_credit)->id_user),
            'credit_data' => $data_credit,
        );
        return view('submenu.history.show',$data);
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
