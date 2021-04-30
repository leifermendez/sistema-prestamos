<?php

namespace App\Http\Controllers;

use App\db_pending_pay;
use Carbon\Carbon;
use Illuminate\Http\Request;

class pendingPaymentController extends Controller
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
        $clients = db_pending_pay::join('credit', 'credit.id', '=', 'pending_pays.id_credit')
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select(
                'pending_pays.*',
                'users.name as user_name',
                'users.last_name as user_last_name'
            )
            ->orderBy('id', 'DESC')
            ->get();

        //        dd($clients);


        $data = array(
            'clients' => $clients
        );

        //        dd($data);

        return view('pending-pay.index', $data);
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
        db_pending_pay::insert([
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
