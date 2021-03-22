<?php

namespace App\Http\Controllers;

use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\db_wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class subDoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $id_wallet = $request->id_wallet;

        if (!isset($date_start)) {
            return 'Fecha Inicio';
        };
        if (!isset($date_end)) {
            return 'Fecha Final';
        };
        if (!isset($id_wallet)) {
            return 'ID wallet';
        };
        if (!db_supervisor_has_agent::where('id_wallet', $id_wallet)->exists()) {
            return 'No existe relacion wallet';
        };
        $id_agent = db_supervisor_has_agent::where('id_wallet', $id_wallet)->first();

        $data = db_credit::whereDate('credit.created_at', '>=', Carbon::createFromFormat('d/m/Y', $date_start)->toDateString())
            ->whereDate('credit.created_at', '<=', Carbon::createFromFormat('d/m/Y', $date_end)->toDateString())
            ->where('id_agent', $id_agent->id_user_agent)
            ->where('credit.status', '=', 'close')
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select('credit.id as credit_id',
                'users.name',
                'users.last_name',
                'credit.created_at as credit_date',
                'credit.amount_neto',
                'credit.utility',
                'credit.payment_number')
            ->get();



        foreach ($data as $datum) {
            $datum->summary_lasted = db_summary::where('id_credit', $datum->credit_id)
                ->orderBy('id', 'desc')
                ->first()->created_at;
            $datum->summary_amount = db_summary::where('id_credit', $datum->credit_id)
                ->orderBy('id', 'desc')
                ->first()->amount;
            $datum->summary_number_pay = db_summary::where('id_credit', $datum->credit_id)
                ->count();
        }

        $data = array(
            'credit' => $data,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'id_wallet' => $id_wallet
        );

        return view('submenu.done.index', $data);
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
        return view('submenu.done.create', array('id_wallet' => $id));
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
