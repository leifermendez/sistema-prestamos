<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_close_day;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class dailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $agents_for_supervisor = db_supervisor_has_agent::where('id_supervisor', Auth::id())->get();

        foreach ($agents_for_supervisor as $item) {
            $data_summary = db_summary::whereDate('summary.created_at',
                Carbon::now()->toDateString())
                ->where('credit.id_agent', $item->id_user_agent)
                ->join('credit', 'summary.id_credit', '=', 'credit.id')
                ->join('users', 'credit.id_user', '=', 'users.id')
                ->select(
                    'users.name as user_name',
                    'users.last_name as user_last_name',
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
            $user = User::find($item->id_user_agent);
            $name = $user->name.' '.$user->last_name;
            $now = Carbon::now();
            $current_date = $now->format('d-m-Y');
            $close_day = db_close_day::whereDate('created_at', Carbon::now()->toDateString())
                ->where('id_agent', $item->id_user_agent)
                ->first();

            $base = db_supervisor_has_agent::where('id_user_agent', $item->id_user_agent)->first()->base ?? 0;
            $base_final = db_supervisor_has_agent::where('id_user_agent', $item->id_user_agent)->first()->base ?? 0;
            $base_credit = db_credit::whereDate('created_at', Carbon::now()->toDateString())
                ->where('id_agent', $item->id_user_agent)
                ->sum('amount_neto');
            $base -= $base_credit;
            $base_final = $base_final;
            $base_credit = $base_credit;

            $total_summary = $data_summary->sum('amount');

            $sql = array(
                ['id_agent', '=', $item->id_user_agent]
            );
            $sql[] = ['bills.created_at', '>=', Carbon::now()->startOfDay()];
            $sql[] = ['bills.created_at', '<=', Carbon::now()->endOfDay()];


            $bill = db_bills::where($sql)
                ->join('wallet', 'bills.id_wallet', '=', 'wallet.id')
                ->select('bills.*', 'wallet.name as wallet_name')
                ->get();


            $data[] = (object) [
                'name' => $name,
                'base_agent' => $base,
                'base_final' => $base_final,
                'total_bill' => $bill->sum('amount'),
                'total_summary' => $total_summary,
                'base_credit' => $base_credit,
                'current_date' => $current_date,
                'close_day' => $close_day
            ];
        }
        return view('daily-report.index', array(
            'data' => $data
        ));
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
