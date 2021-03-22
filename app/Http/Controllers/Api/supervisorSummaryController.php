<?php

namespace App\Http\Controllers;

use App\db_summary;
use Illuminate\Http\Request;

class supervisorSummaryController extends Controller
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
    public function edit(Request $request,$id)
    {

        $id_wallet = $request->id_wallet;
        if(!isset($id_wallet)){return 'ID wallet';};

        $data = db_summary::where('summary.id',$id)
            ->join('credit','summary.id_credit','=','credit.id')
            ->join('users','credit.id_user','=','users.id')
            ->select(
                'users.name',
                'users.last_name',
                'users.province',
                'credit.id as credit_id',
                'credit.amount_neto',
                'credit.payment_number',
                'summary.amount as amount_value',
                'summary.id as id_summary'
            )
            ->first();

        $data->id_wallet = $id_wallet;

        return view('submenu.summary.edit',$data);
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
            $id_wallet = $request->id_wallet;
            $amount = $request->amount;

            if(!isset($id_wallet)){ return 'ID wallet';};
            if(!isset($amount)){ return 'Amount';};

            db_summary::where('id',$id)->update(['amount'=>$amount]);

            return redirect('supervisor/menu/edit/create?id_wallet='.$id_wallet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        db_summary::where('id',$id)->delete();

        return redirect('/supervisor/menu/edit/'.$id.'?date_start='.urlencode($request->date_start));
    }
}
