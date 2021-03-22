<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class subBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

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
    public function show(Request $request,$id)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        if(!db_supervisor_has_agent::where('id_wallet',$id)->exists()){
            return 'No existe agente con esta ruta';
        }

        $data_agent = db_supervisor_has_agent::where('id_wallet',$id)->first();
//        dd($data_agent);
        $sql = array(
            ['id_agent','=',$data_agent->id_user_agent]
        );
        if(isset($date_start) && isset($date_end)){
            $sql[]=['bills.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)];
            $sql[]=['bills.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)];
        }

        $data=db_bills::where($sql)
            ->join('wallet','bills.id_wallet','=','wallet.id')
            ->join('users','bills.id_agent','=','users.id')
            ->select('bills.*','wallet.name as wallet_name',
                'users.name as user_name',
                'users.last_name as user_lastname')
            ->get();

        $data = array(
            'id'=>$id,
            'clients' => $data,
            'total' => $data->sum('amount')
        );

        return view('submenu.bill.index',$data);
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
