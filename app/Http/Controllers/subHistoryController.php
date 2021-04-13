<?php

namespace App\Http\Controllers;

use App\db_credit;
use App\db_agent_has_user;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $user_has_agent = db_agent_has_user::where('id_agent', Auth::id())
        ->join('users', 'id_client', '=', 'users.id')
        ->get();
        
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

            foreach ($user_has_agent as $user) {
                if (db_credit::where('id_user', $user->id)->exists()) {
                    $user->closed = db_credit::where('status', 'close')->where('id_user', $user->id)->count();
                    $user->inprogress = db_credit::where('status', 'inprogress')->where('id_user', $user->id)->count();
                    $user->credit_count = db_credit::where('id_user', $user->id)->count();
                    $user->amount_net = db_credit::where('id_user', $user->id)
                        ->where('status', 'inprogress')->get()->toArray();
                    if(sizeOf($user->amount_net)) {
                        $tmp_credit = 0;
                        $user->gap_credit = 0;
                        $user->summary_net = 0;
                        foreach ($user->amount_net as $key => $value) {
                            $user->summary_net += db_summary::where('id_credit', $value['id'])
                            ->sum('amount');
                            $tmp_credit += $value['amount_neto'] ?? 0;
                            $user->gap_credit += $value['amount_neto'] * $value['utility'];
                        }
                        $user->sum_amount_gap = $tmp_credit + $user->gap_credit;
                        $tmp_rest = $tmp_credit - $user->summary_net;
                        $user->summary_net = $tmp_rest;
                    } else {
                        $user->summary_net = 0;
                    }
                }
            }
    
            $total_pending = floatval($user_has_agent->sum('summary_net') + $user_has_agent->sum('gap_credit')) ;
            $user_has_agent = array(
                'clients' => $user_has_agent,
                'total_pending' => $total_pending
            );
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

        $id = $request->id;
        $data = array(
            'clients' => $data,
            'total' => $total_summary,
            'total_rest' => $total_rest,
            'total_credit' => $total_credit_amount,
            'user' => User::find($id),
            'payment_number' => DB::table('payment_number')->orderBy('name', 'asc')->get(),
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
