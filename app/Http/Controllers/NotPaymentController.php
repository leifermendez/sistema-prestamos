<?php

namespace App\Http\Controllers;

use App\db_credit;
use App\db_summary;
use App\Exports\NotPayExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Maatwebsite\Excel\Facades\Excel;

class NotPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('not-payments.create');
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
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        if (!isset($date_start) || !isset($date_end)) {
            return back()->with('error', 'Todos los campos son obligatorios');
        };

        $day_start = Carbon::createFromFormat('d/m/Y', $date_start);
        $start = Carbon::parse($day_start)->isoFormat('dddd');
        $day_end = Carbon::createFromFormat('d/m/Y', $date_end);
        $end = Carbon::parse($day_end)->isoFormat('dddd');


        if ($start !== "lunes") {
            return back()->with('error', 'La fecha inicial debe ser un lunes');
        }
        if ($end !== "sábado") {
            return back()->with('error', 'La fecha final debe ser un sabado');
        }
        Cookie::queue('date_start', $request->date_start);
        Cookie::queue('date_end', $request->date_end);

        $data_user = db_credit::where('credit.id_agent', Auth::id())
            ->where('credit.status', 'inprogress')
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select(
                'credit.*',
                'users.id as id_user',
                'users.name',
                'users.last_name'
            )
            ->get();

        foreach ($data_user as $data) {
            if (db_credit::where('id_user', $data->id_user)->where('id_agent', Auth::id())->exists()) {
                $summary  = db_summary::where('id_credit', $data->id)
                    ->whereDate('summary.created_at', '>=', Carbon::createFromFormat('d/m/Y', $date_start),)
                    ->whereDate('summary.created_at', '<=', Carbon::createFromFormat('d/m/Y', $date_end))
                    ->orderBy('summary.created_at', 'asc')->get();
                $data->summary = $summary;
            }
        }


        $data = array(
            'clients' => $data_user
        );

        return view('not-payments.index', $data);
    }
    public function export()
    {
        $date_start =  Cookie::get('date_start');
        $date_end =  Cookie::get('date_end');
        return Excel::download(new NotPayExport($date_start, $date_end, Auth::id()), 'not_payments.xlsx');
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
