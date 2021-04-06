<?php

namespace App\Http\Controllers;

use App\db_close_day;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('wallet','id_wallet','=','wallet.id')
            ->get();
        $sum = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('wallet','id_wallet','=','wallet.id')
            ->sum('agent_has_supervisor.base');
        $report = db_close_day::where('id_supervisor',Auth::id())->orderBy('id','desc')->get();

        $data = array(
            'clients' => $data,
            'report' => $report,
            'sum' => $sum
        );

        return view('supervisor_cash.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('wallet','id_wallet','=','wallet.id')
            ->get();

        $data = array(
            'wallet' => $data
        );

        return view('supervisor_cash.create',$data);
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
