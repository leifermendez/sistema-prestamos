<?php

namespace App\Http\Controllers;

use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class agentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor',Auth::id())
            ->join('users','id_user_agent','=','users.id')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                'users.*',
                'wallet.name as wallet_name',
                'agent_has_supervisor.base as base_total'
            )
            ->get();
        $data = array(
            'clients' => $data,
            'today' => Carbon::now()->toDateString(),

        );
        return view('supervisor_agent.index',$data);
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
        $data = User::where('users.id',$id)->join('agent_has_supervisor','users.id','=','agent_has_supervisor.id_user_agent')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                'users.name',
                'users.last_name',
                'users.country',
                'users.address',
                'wallet.name as wallet_name',
                'users.id',
                'agent_has_supervisor.base as base_current'
            )
            ->first();

        return view('supervisor_agent.edit',$data);
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
        $base = $request->base_number;
        if(!isset($base)){return 'Base Vacia';};
        $base_current = db_supervisor_has_agent::where('id_user_agent',$id)
            ->where('id_supervisor',Auth::id())->first()->base;
        $base = $base_current+$base;
        db_supervisor_has_agent::where('id_user_agent',$id)
            ->where('id_supervisor',Auth::id())
            ->update(['base'=>$base]);

        return redirect('supervisor/agent');
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
