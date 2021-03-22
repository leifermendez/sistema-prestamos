<?php

namespace App\Http\Controllers;

use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class subRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_wallet = $request->id_wallet;

        if(!db_supervisor_has_agent::where('id_wallet',$id_wallet)->exists()){
            return 'No existe agente con esta ruta';
        }

        $data_agent = db_supervisor_has_agent::where('id_wallet',$id_wallet)->first();
        if(!isset($id_wallet)){return 'ID wallet vacio';};

        $data = db_credit::where('id_agent',$data_agent->id_user_agent)
            ->where('status','inprogress')
            ->get();
        $data_filter = array();

        foreach ($data as $d){
            if(db_summary::where('id_credit',$d->id)->exists()) {
                $tmp = db_summary::where('id_credit', $d->id)->orderBy('id', 'desc')->first();
                $end =Carbon::parse($tmp->created_at)->addDay();
                if($end->lt(Carbon::now())){
                    $d->user=User::find($d->id_user);
                    $d->amount_neto = (floatval($d->amount_neto*$d->utility)+floatval($d->amount_neto));
                    if(db_summary::where('id_credit',$d->id)->exists()){
                        $d->rest_days = db_summary::where('id_credit',$d->id)->orderBy('created_at','desc')->first();
                        $dt = Carbon::now();
                        $d->rest_days = $dt->diffInDays(Carbon::parse($d->rest_days->created_at));
                    }else{
                        $dt = Carbon::now();
                        $d->rest_days = $dt->diffInDays(Carbon::parse($d->created_at));
                    }
                    $d->quote = (floatval($d->amount_neto*$d->utility)+floatval($d->amount_neto))/floatval($d->payment_number);
                    $d->saldo = ($d->amount_neto)-(db_summary::where('id_credit',$d->id)->sum('amount'));
                    $data_filter[]=$d;
                }
            }else{
                $d->user=User::find($d->id_user);
                $d->quote = (floatval($d->amount_neto*$d->utility)+floatval($d->amount_neto))/floatval($d->payment_number);
                $d->amount_neto = (floatval($d->amount_neto*$d->utility)+floatval($d->amount_neto));
                if(db_summary::where('id_credit',$d->id)->exists()){
                    $d->rest_days = db_summary::where('id_credit',$d->id)->orderBy('created_at','desc')->first();
                    $dt = Carbon::now();
                    $d->rest_days = $dt->diffInDays(Carbon::parse($d->rest_days->created_at));
                }else{
                    $dt = Carbon::now();
                    $d->rest_days = $dt->diffInDays(Carbon::parse($d->created_at));
                }
                $d->saldo = ($d->amount_neto)-(db_summary::where('id_credit',$d->id)->sum('amount'));
                $data_filter[]=$d;
            }

        }

        $data_all = array(
            'clients' => $data_filter,
            'id_wallet' => $id_wallet
        );
        return view('submenu.route.index',$data_all);

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
