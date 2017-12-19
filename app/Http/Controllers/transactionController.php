<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_credit;
use App\db_summary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction.create');
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
        $date = $request->date_start;

        if(!isset($date)){return 'Fecha Vacia';};

        $data_summary = db_summary::whereDate('summary.created_at',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('credit.id_agent',Auth::id())
            ->join('credit','summary.id_credit','=','credit.id')
            ->join('users','credit.id_user','=','users.id')
            ->select(
                'users.name',
                'users.last_name',
                'credit.payment_number',
                'credit.utility',
                'credit.amount_neto',
                'credit.id as id_credit',
                'summary.number_index',
                'summary.amount',
                'summary.created_at'
                )
            ->groupBy('summary.id')
            ->get();

        $data_credit = db_credit::whereDate('credit.created_at',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('credit.id_agent',Auth::id())
            ->join('users','credit.id_user','=','users.id')
            ->select(
                'credit.id as credit_id',
                'users.id',
                'users.name',
                'users.last_name',
                'users.province',
                'credit.created_at',
                'credit.utility',
                'credit.payment_number',
                'credit.amount_neto')
            ->get();


        $data_bill = db_bills::whereDate('created_at',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('id_agent',Auth::id())
            ->get();

        foreach ($data_summary as $d){
            $total = db_summary::where('id_credit',$d->id_credit)->sum('amount');
            $total_credit = db_credit::where('id',$d->id_credit)->sum('amount_neto');
            $total_credit = $total_credit+($total_credit*$d->utility);
            $total = $total_credit-$total;

            $d->setAttribute('total_payment',$total);
        }

        $total_summary = $data_summary->sum('amount');
        $total_credit = $data_credit->sum('amount_neto');
        $total_bills = $data_bill->sum('amount');

        $data = array(
            'summary' => $data_summary,
            'credit' => $data_credit,
            'bills' => $data_bill,
            'total_summary' => $total_summary,
            'total_bills' => $total_bills,
            'total_credit' => $total_credit,
        );

        return view('transaction.index',$data);
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
