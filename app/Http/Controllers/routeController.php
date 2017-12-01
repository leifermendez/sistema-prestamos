<?php

namespace App\Http\Controllers;

use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class routeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::user()->id;
            if(!db_supervisor_has_agent::where('id_user_agent',Auth::id())->exists()){
                die('No existe relacion Usuario y Agente');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = db_credit::where('id_agent',Auth::id())
            ->where('status','inprogress')
            ->get();
        $data_filter = array();
        $dt = Carbon::now();
        foreach ($data as $d){
            if(db_summary::where('id_credit',$d->id)->exists()) {
                $tmp = db_summary::where('id_credit', $d->id)->orderBy('id', 'desc')->first();
                $end =Carbon::parse($tmp->created_at)->addDay();
                if($end->lt(Carbon::now())){
                    $d->user=User::find($d->id_user);
                    $d->amount_total = ($d->amount_neto)+($d->amount_neto*$d->utility);
                    $d->days_rest = $dt->diffInDays(Carbon::parse($d->created_at));
                    $d->saldo = $d->amount_total-(db_summary::where('id_credit',$d->id)->sum('amount'));
                    $d->quote = (floatval($d->amount_neto*$d->utility)+floatval($d->amount_neto))/floatval($d->payment_number);
                    $d->lsat_pay = db_summary::where('id_credit',$d->id)->orderBy('created_at','desc')->first()->created_at;
                    $data_filter[]=$d;
                }
            }else{
                    $d->user=User::find($d->id_user);
                    $d->quote = (floatval($d->amount_neto*$d->utility)+floatval($d->amount_neto))/floatval($d->payment_number);
                    $d->days_rest = $dt->diffInDays(Carbon::parse($d->created_at));
                    $d->amount_total = ($d->amount_neto)+($d->amount_neto*$d->utility);
                    $d->saldo = $d->amount_total-(db_summary::where('id_credit',$d->id)->sum('amount'));

                    $data_filter[]=$d;
            }

        }

        $data_all = array(
            'clients' => $data_filter
        );
        return view('route.index',$data_all);
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
