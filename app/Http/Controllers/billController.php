<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_list_bills;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class billController extends Controller
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

        $sql = array(
            ['id_agent','=',Auth::id()]
        );
        if(isset($date_start) && isset($date_end)){
            $sql[]=['bills.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)];
            $sql[]=['bills.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)];
        }else{
            $sql[]=['bills.created_at','=',Carbon::now()];
        }

        $data=db_bills::where($sql)
            ->join('wallet','bills.id_wallet','=','wallet.id')
            ->select('bills.*','wallet.name as wallet_name')
            ->get();
        $data = array(
            'clients' => $data,
            'total' => $data->sum('amount')
        );

        return view('bill.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = db_list_bills::all();
        return view('bill.create',array('bills' => $data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $amount = $request->amount;
        $description = $request->description;
        $type = $request->type_bill;
        $wallet = db_supervisor_has_agent::where('id_user_agent',Auth::id())->first();
        $values = array(
            'description' => $description,
            'id_agent' => Auth::id(),
            'amount' => $amount,
            'created_at' => Carbon::now(),
            'type' => $type,
            'id_wallet' => $wallet->id_wallet
        );

        db_bills::insert($values);

        return redirect('bill');
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
