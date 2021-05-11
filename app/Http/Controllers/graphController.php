<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_credit;
use App\db_summary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class graphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type;
        $response = array(
            'data'=>[]
        );
        switch ($type) {
            case 'overdraft':
                return view('graph.overdraft', $response);
                break;
            case 'bill':
                return view('graph.bill', $response);
                break;
            case 'payment':
                return view('graph.payment', $response);
                break;
            default:
                return view('graph.index', $response);
        }

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
        $type = $request->type;
        $date_start = Carbon::createFromFormat('d/m/Y', $request->date_start);
        $date_end = Carbon::createFromFormat('d/m/Y', $request->date_end);

        $response = $this->parseDates($date_start, $date_end, $type);
        switch ($type) {
            case 'overdraft':
                return view('graph.overdraft', $response);
                break;
            case 'payment':
                return view('graph.payment', $response);
                break;
            case 'bill':
                return view('graph.bill', $response);
                break;
        }
    }

    private function parseDates($date_start, $date_end, $type): array
    {
        setlocale(LC_TIME, 'Spanish');
        $thisWeekendSql = [];
        $lastWeekendSql = [];
        $dataGraph = [];
        $datesForDays = [$date_start->startOfDay()->copy()];
        $daysBetweenWeekends = $date_start->copy()->diffInDays($date_end);
        for ($i = 0; $i < $daysBetweenWeekends; $i++) {
            $datesForDays[] = $datesForDays[$i]->copy()->addDay()->startOfDay();
        }

        $date_last = $date_start->copy()->subDays($daysBetweenWeekends+1);
        $date_last_end = $date_start->copy()->subDay();

        // this week
        if (isset($date_start) && isset($date_end)) {
            $thisWeekendSql[] = ['created_at', '>=', $date_start->startOfDay()];
            $thisWeekendSql[] = ['created_at', '<=', $date_end->endOfDay()];
        }

        // last week
        if (isset($date_last) && isset($date_last_end)) {
            $lastWeekendSql[] = ['created_at', '>=', $date_last->startOfDay()];
            $lastWeekendSql[] = ['created_at', '<=', $date_last_end->endOfDay()];
        }
//        var_dump($lastWeekendSql);
        switch ($type) {
            case 'overdraft':
                $dataGraph = $this->overdraft($thisWeekendSql, $lastWeekendSql, $datesForDays);
                break;
            case 'bill':
                $dataGraph = $this->bill($thisWeekendSql, $lastWeekendSql, $datesForDays);
                break;
            case 'payment':
                $dataGraph = $this->payment($thisWeekendSql, $lastWeekendSql, $datesForDays);
                break;
        }

        $response = array_merge($dataGraph, array(
                'thisWeekend'=> 'Desde '.$date_start->format('d-m').' hasta '.$date_end->format('d-m'),
                'lastWeekend'=> 'Desde '.$date_last->format('d-m').' hasta '.$date_last_end->format('d-m')
            )
        );
        return array(
            'data'=> $response
        );
    }

    private function overdraft($thisWeekendSql, $lastWeekendSql, $datesForDays): array
    {
        $dataDaysData = [];
        $dataDaysLabels = [];
        $dataItems = array(
            'thisWeekend' => db_credit::where($thisWeekendSql)->count(),
            'lastWeekend' => db_credit::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_credit::where($thisWeekendSql)->sum('amount_neto'),
            'lastWeekend' => db_credit::where($lastWeekendSql)->sum('amount_neto')
        );

        foreach ($datesForDays as $value) {
            $dataDaysData[] = db_credit::where([
                ['created_at', '>=', $value],
                ['created_at', '<=', $value->copy()->endOfDay()]
            ])->sum('amount_neto');
//            print_r($value.' - '.$value->copy()->endOfDay().'<br>');
            $dataDaysLabels[] = $value->copy()->isoFormat('dddd D');
        }

        return array(
            'dataDays'=> array(
                'labels' => $dataDaysLabels,
                'data' => $dataDaysData
            ),
            'dataAmount' => $dataAmount,
            'dataItems' => $dataItems,
        );
    }

    private function payment($thisWeekendSql, $lastWeekendSql, $datesForDays): array
    {
        $dataDaysData = [];
        $dataDaysLabels = [];
        $dataItems = array(
            'thisWeekend' => db_summary::where($thisWeekendSql)->count(),
            'lastWeekend' => db_summary::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_summary::where($thisWeekendSql)->sum('amount'),
            'lastWeekend' => db_summary::where($lastWeekendSql)->sum('amount')
        );

        foreach ($datesForDays as $value) {
            $dataDaysData[] = db_summary::where([
                ['created_at', '>=', $value],
                ['created_at', '<=', $value->copy()->endOfDay()]
            ])->sum('amount');
//            print_r($value.' - '.$value->copy()->endOfDay().'<br>');
            $dataDaysLabels[] = $value->copy()->isoFormat('dddd D');
        }

        return array(
            'dataDays'=> array(
                'labels' => $dataDaysLabels,
                'data' => $dataDaysData
            ),
            'dataAmount' => $dataAmount,
            'dataItems' => $dataItems,
        );
    }

    private function bill($thisWeekendSql, $lastWeekendSql, $datesForDays): array
    {
        $dataDaysData = [];
        $dataDaysLabels = [];
        $dataItems = array(
            'thisWeekend' => db_bills::where($thisWeekendSql)->count(),
            'lastWeekend' => db_bills::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_bills::where($thisWeekendSql)->sum('amount'),
            'lastWeekend' => db_bills::where($lastWeekendSql)->sum('amount')
        );

        foreach ($datesForDays as $value) {
            $dataDaysData[] = db_bills::where([
                ['created_at', '>=', $value],
                ['created_at', '<=', $value->copy()->endOfDay()]
            ])->sum('amount');
//            print_r($value.' - '.$value->copy()->endOfDay().'<br>');
            $dataDaysLabels[] = $value->copy()->isoFormat('dddd D');
        }

        return array(
            'dataDays'=> array(
                'labels' => $dataDaysLabels,
                'data' => $dataDaysData
            ),
            'dataAmount' => $dataAmount,
            'dataItems' => $dataItems,
        );
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
