<?php

namespace App\Http\Controllers;

use App\db_blacklists;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class blacklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // pending_pay -> credit -> user
        //      ->join('credit', 'summary.id_credit', '=', 'credit.id')

        $clients = db_blacklists::where('id_agent', Auth::id())
            ->join('credit','credit.id','=','blacklists.id_credit')
            ->join('users','credit.id_user','=','users.id')
            ->select(
                'blacklists.*',
                'users.name as user_name',
                'users.last_name as user_last_name'
            )
            ->orderBy('id','DESC')
            ->get();



//        dd($clients);


        $data = array(
            'clients' => $clients
        );

//        dd($data);

        return view('blacklists.index',$data);
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
        $id_credit = $request->input('id_credit');
        db_blacklists::insert([
            'id_credit' => $id_credit,
            'created_at' => Carbon::now()
        ]);
        return redirect('route');
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