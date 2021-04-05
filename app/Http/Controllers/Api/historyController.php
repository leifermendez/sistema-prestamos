<?php

namespace App\Http\Controllers\Api;

use App\db_bills;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class historyController extends Controller
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
        return response()->json(array('history.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $date = $request->date_start;
            $base_amount = db_supervisor_has_agent::where('id_user_agent',Auth::id())->first()->base;
            $today_amount = db_summary::whereDate('created_at', '=', Carbon::createFromFormat('d/m/Y', $date)
                ->toDateString())
                ->where('id_agent',Auth::id())
                ->sum('amount');
            $today_sell = db_credit::whereDate('created_at','=',Carbon::createFromFormat('d/m/Y', $date)
                ->toDateString())
                ->where('id_agent',Auth::id())
                ->sum('amount_neto');
            $bills = db_bills::whereDate('created_at','=',Carbon::createFromFormat('d/m/Y', $date)
                ->toDateString())
                ->sum('amount');
            $total = floatval($base_amount+$today_amount)-floatval($today_sell+$bills);
            $average = 1000;

            $data = array(
                'base' => $base_amount,
                'today_amount' => $today_amount,
                'today_sell' => $today_sell,
                'bills' => $bills,
                'total' => $total,
                'average' => $average
            );
            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        
        } catch (\Exception $e) {
            $response = array(
                'status' => 'fail',
                'msj' => $e->getMessage(),
                'code' => 5
            );
            return response()->json($response);
        }
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
