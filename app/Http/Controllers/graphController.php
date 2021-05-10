<?php

namespace App\Http\Controllers;

use App\db_credit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class graphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = array(
            'data'=>[]
        );
        return view('graph.overdraft', $response);
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
        switch ($type) {
            case 'overdraft':
                $date_start = Carbon::createFromFormat('d/m/Y', $request->date_start);
                $date_end = Carbon::createFromFormat('d/m/Y', $request->date_end);

                $response = $this->overdraft($date_start, $date_end);

                return view('graph.overdraft', $response);
                break;
        }
    }

    private function overdraft($date_start, $date_end) {
        $thisWeekendSql = [];
        $lastWeekendSql = [];
        $daysBetweenWeekends = $date_start->copy()->diffInDays($date_end);

        $date_last = $date_start->copy()->subDays($daysBetweenWeekends+1);
        $date_last_end = $date_start->copy()->subDay();

        // this week
        if (isset($date_start) && isset($date_end)) {
            $thisWeekendSql[] = ['credit.created_at', '>=', $date_start->startOfDay()];
            $thisWeekendSql[] = ['credit.created_at', '<=', $date_end->endOfDay()];
        }

        // last week
        if (isset($date_last) && isset($date_last_end)) {
            $lastWeekendSql[] = ['credit.created_at', '>=', $date_last->startOfDay()];
            $lastWeekendSql[] = ['credit.created_at', '<=', $date_last_end->endOfDay()];
        }
//        var_dump($lastWeekendSql);

        $dataItems = array(
            'thisWeekend' => db_credit::where($thisWeekendSql)->count(),
            'lastWeekend' => db_credit::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_credit::where($thisWeekendSql)->sum('amount_neto'),
            'lastWeekend' => db_credit::where($lastWeekendSql)->sum('amount_neto')
        );

        $response = array(
            'data'=> [
                'dataAmount' => $dataAmount,
                'dataItems' => $dataItems,
                'thisWeekend'=> 'Desde '.$date_start->format('d-m-Y').' hasta '.$date_end->format('d-m-Y'),
                'lastWeekend'=> 'Desde '.$date_last->format('d-m-Y').' hasta '.$date_last_end->format('d-m-Y')
            ]
        );

        return $response;
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
