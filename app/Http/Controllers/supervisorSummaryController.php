<?php

namespace App\Http\Controllers;

use App\db_audit;
use App\db_credit;
use App\db_summary;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode(db_summary::find($id)),
            'event' => 'update',
            'device' => $request->device,
            'type' => 'Pago'
        );
        db_audit::insert($audit);

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
        $summary = db_summary::find($id);
        $credit = db_credit::where('credit.id', $summary->id_credit)
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select(
                'credit.amount_neto as credit_amount_neto',
                'credit.order_list as credit_order_list',
                'credit.id_user as credit_id_user',
                'credit.payment_number as credit_payment_number',
                'credit.utility as credit_utility',
                'credit.status as credit_status',
                'users.name as credit_user_name')
            ->first();

        $user_audit = User::find($summary->id_agent);
        $credit['agent'] = $user_audit->name.' '.$user_audit->last_name;
        $credit['id'] = $summary->id;
        $credit['amount'] = $summary->amount;
        $credit['id_agent'] = $summary->id_agent;
        $credit['id_credit'] = $summary->id_credit;
        $credit['updated_at'] = $summary->updated_at;
        $credit['number_index'] = $summary->number_index;
        $credit['created_at'] = $summary->created_at;

        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode($credit),
            'event' => 'delete',
            'device' => $request->device,
            'type' => 'Pago'
        );
        db_audit::insert($audit);
        db_summary::where('id',$id)->delete();

        return redirect('/supervisor/menu/edit/'.$id.'?date_start='.urlencode($request->date_start));
    }
}
