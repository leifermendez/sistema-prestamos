<?php

namespace App\Http\Controllers;

use App\db_countries;
use App\db_supervisor_has_agent;
use App\db_wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_current = Auth::user();
        $ormSqlWallet = db_supervisor_has_agent::join('wallet', 'agent_has_supervisor.id_wallet', '=', 'wallet.id')
            ->join('users', 'agent_has_supervisor.id_user_agent', '=', 'users.id')
            ->select('wallet.*', 'users.name as user_name', 'users.id as user_id');

        if($user_current->level !== 'admin'){
            $ormSqlWallet = $ormSqlWallet->where('agent_has_supervisor.id_supervisor', Auth::id());
        }

        $data = array(
            'wallet' => $ormSqlWallet->get(),
            'agents' => db_supervisor_has_agent::where('id_supervisor', Auth::id())
                ->join('users', 'id_user_agent', '=', 'users.id')->get(),
            'countries' => db_countries::all(),
        );
        return view('supervisor_review.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('supervisor_review.show', array('id' => $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
