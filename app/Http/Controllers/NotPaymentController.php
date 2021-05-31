<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\db_credit;
use App\db_not_pay;
use App\db_summary;
use App\Exports\NotPayExport;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
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

        $startDate = Carbon::createFromFormat('d/m/Y', $date_start);
        $endDate = Carbon::createFromFormat('d/m/Y', $date_end);
        $day_start = Carbon::parse($startDate)->Format('l');
        $day_end = Carbon::parse($endDate)->Format('l');

        if ($day_start !== "Monday") {
            return back()->with('error', 'La fecha inicial debe ser un lunes');
        }
        if ($day_end !== "Sunday") {
            return back()->with('error', 'La fecha final debe ser un domingo');
        }

        $dateRanges = CarbonPeriod::create($startDate, $endDate);
        Cookie::queue('date_start', $request->date_start);
        Cookie::queue('date_end', $request->date_end);

        $data_credit  = db_credit::where('credit.id_agent', Auth::id())
            ->where('credit.status', 'inprogress')
            ->join('users', 'users.id', '=', 'credit.id_user')
            ->orderBy('credit.created_at', 'asc')
            ->select(
                'credit.id as id_credit',
                'users.id as id_user',
                'users.name',
                'users.last_name'
            )
            ->get();
        $daysOfWeek = [];

        foreach ($data_credit as $data) {
            if (db_credit::where('id_user', $data->id_user)->where('id_agent', Auth::id())->exists()) {

                foreach ($dateRanges->toArray() as $dateRange) {
                    $day = Carbon::parse($dateRange)->Format('l');
                    $daysOfWeek[$day] =  db_summary::where('id_credit', $data->id_credit)
                        ->whereDate('summary.created_at', '=', $dateRange)
                        ->sum('amount');
                }
                $data->summary_day = $daysOfWeek;
            }
        }

        $data_credit = $this->parse_not_payments($data_credit);

        $data = array(
            'clients' => $data_credit
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

    private function parse_not_payments($data_credit): array
    {
        $listaFinal = [];
        foreach ($data_credit as $data) {
            if (isset($listaFinal[$data->id_user])) {
                foreach ($data->summary_day as $key => $item) {
                    $listaFinal[$data->id_user]->summary_day[$key] += $item;
                }
            } else {
                $listaFinal[$data->id_user] = (object) array(
                    'id_credit' => $data->id_credit,
                    'id_user' => $data->id_user,
                    'name' => $data->name,
                    'last_name' => $data->last_name,
                    'summary_day' => $data->summary_day
                );
            }
        }
        return $listaFinal;
    }
}
