<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                $data = $this->getAgents();
                return view('graph.overdraft', array_merge($data, $response));
                break;
            case 'bill':
                $data = $this->getAgents();
                return view('graph.bill', array_merge($data, $response));
                break;
            case 'payment':
                $data = $this->getAgents();
                return view('graph.payment', array_merge($data, $response));
                break;
            default:
                return view('graph.index', $response);
        }

    }

    private function getAgents(): array
    {
        $data = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('users','id_user_agent','=','users.id')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                'users.*',
                'wallet.name as wallet_name'
            )
            ->get();
        return array(
            'clients' => $data,
        );
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
        $agent = $request->agent;
        $date_start = Carbon::createFromFormat('d/m/Y', $request->date_start);
        $response = $this->parseDates($date_start, $type, $agent);
        $data = $this->getAgents();
        switch ($type) {
            case 'overdraft':
                return view('graph.overdraft', array_merge($data, $response));
                break;
            case 'payment':
                return view('graph.payment', array_merge($data, $response));
                break;
            case 'bill':
                return view('graph.bill', array_merge($data, $response));
                break;
        }
    }

    private function parseDates($date_start, $type, $agent): array
    {
        setlocale(LC_TIME, 'Spanish');
        $thisWeekendSql = [];
        $lastWeekendSql = [];
        $dataGraph = [];
        $datesThisWeek = [$date_start->copy()->startOfDay()];
        $datesLastWeek = [$date_start->copy()->subDays(7)];

        for ($i = 0; $i < 6; $i++) {
            $datesThisWeek[] = $datesThisWeek[$i]->copy()->addDay()->startOfDay();
            $datesLastWeek[] = $datesLastWeek[$i]->copy()->addDay()->startOfDay();
        }

        if (count($datesThisWeek) && count($datesLastWeek)) {
//         this week
            $thisWeekendSql[] = ['created_at', '>=', reset($datesThisWeek)->startOfDay()];
            $thisWeekendSql[] = ['created_at', '<=', end($datesThisWeek)->hour(22)->minute(32)->second(5)->microsecond(123456)->toDateTimeString()];
            $thisWeekendSql[] = ['id_agent', $agent];

//         last week
            $lastWeekendSql[] = ['created_at', '>=', reset($datesLastWeek)->startOfDay()];
            $lastWeekendSql[] = ['created_at', '<=', end($datesLastWeek)->hour(22)->minute(32)->second(5)->microsecond(123456)->toDateTimeString()];
            $lastWeekendSql[] = ['id_agent', $agent];
        }

        switch ($type) {
            case 'overdraft':
                $dataGraph = $this->overdraft($datesThisWeek, $datesLastWeek, $agent, $thisWeekendSql, $lastWeekendSql);
                break;
            case 'bill':
                $dataGraph = $this->bill($datesThisWeek, $datesLastWeek, $agent, $thisWeekendSql, $lastWeekendSql);
                break;
            case 'payment':
                $dataGraph = $this->payment($datesThisWeek, $datesLastWeek, $agent, $thisWeekendSql, $lastWeekendSql);
                break;
        }

        return array(
            'data'=> array_merge($dataGraph, array(
                'labels' => array(
                    'thisWeekend' => reset($datesThisWeek)->copy()->isoFormat('ddd D').' - '.end($datesThisWeek)->copy()->isoFormat('ddd D'),
                    'lastWeekend' => reset($datesLastWeek)->copy()->isoFormat('ddd D').' - '.end($datesLastWeek)->copy()->isoFormat('ddd D')
                )
            ))
        );
    }

    private function overdraft($datesThisWeek, $datesLastWeek, $agent, $thisWeekendSql, $lastWeekendSql): array
    {
        $dataDaysThisWeekTotal = 0;
        $dataDaysLastWeekTotal = 0;
        $dataDaysLabels = [];
        $dataDaysThisWeek = [];;
        $dataDaysLastWeek = [];

        $dataItems = array(
            'thisWeekend' => db_credit::where($thisWeekendSql)->count(),
            'lastWeekend' => db_credit::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_credit::where($thisWeekendSql)->sum('amount_neto'),
            'lastWeekend' => db_credit::where($lastWeekendSql)->sum('amount_neto')
        );

        foreach ($datesLastWeek as $value) {
            if ($value->copy()->isoFormat('dddd') != 'domingo') {
                $totalTmp = db_credit::where([
                    ['created_at', '>=', $value],
                    ['created_at', '<=', $value->copy()->endOfDay()],
                    ['id_agent', $agent]
                ])->sum('amount_neto');
                $dataDaysLastWeek[] = $totalTmp;
                $dataDaysLastWeekTotal += $totalTmp;

                $dataDaysLabels[] = $value->copy()->isoFormat('ddd D');
            }
        }

        $i = 0;
        foreach ($datesThisWeek as $value) {
            if ($value->copy()->isoFormat('dddd') != 'domingo') {
                $totalTmp = db_credit::where([
                    ['created_at', '>=', $value],
                    ['created_at', '<=', $value->copy()->endOfDay()],
                    ['id_agent', $agent]
                ])->sum('amount_neto');
                $dataDaysThisWeek[] = $totalTmp;
                $dataDaysThisWeekTotal += $totalTmp;

                $dataDaysLabels[$i] = $dataDaysLabels[$i] . ' - ' . $value->copy()->isoFormat('ddd D');
                $i++;
            }
        }

        return array(
            'dataDays'=> array(
                'labels' => $dataDaysLabels,
                'data' => array(
                    'thisWeek' => $dataDaysThisWeek,
                    'lastWeek' => $dataDaysLastWeek
                ),
                'total' => array(
                    'thisWeek' => $dataDaysThisWeekTotal,
                    'lastWeek' => $dataDaysLastWeekTotal
                ),
            ),
            'dataAmount' => $dataAmount,
            'dataItems' => $dataItems
        );
    }

    private function payment($datesThisWeek, $datesLastWeek, $agent, $thisWeekendSql, $lastWeekendSql): array
    {
        $dataDaysThisWeekTotal = 0;
        $dataDaysLastWeekTotal = 0;
        $dataDaysLabels = [];
        $dataDaysThisWeek = [];;
        $dataDaysLastWeek = [];

        $dataItems = array(
            'thisWeekend' => db_summary::where($thisWeekendSql)->count(),
            'lastWeekend' => db_summary::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_summary::where($thisWeekendSql)->sum('amount'),
            'lastWeekend' => db_summary::where($lastWeekendSql)->sum('amount')
        );

        foreach ($datesLastWeek as $value) {
            if ($value->copy()->isoFormat('dddd') != 'domingo') {
                $totalTmp = db_summary::where([
                    ['created_at', '>=', $value],
                    ['created_at', '<=', $value->copy()->endOfDay()],
                    ['id_agent', $agent]
                ])->sum('amount');
                $dataDaysLastWeek[] = $totalTmp;
                $dataDaysLastWeekTotal += $totalTmp;

                $dataDaysLabels[] = $value->copy()->isoFormat('ddd D');
            }
        }

        $i = 0;
        foreach ($datesThisWeek as $value) {
            if ($value->copy()->isoFormat('dddd') != 'domingo') {
                $totalTmp = db_summary::where([
                    ['created_at', '>=', $value],
                    ['created_at', '<=', $value->copy()->endOfDay()],
                    ['id_agent', $agent]
                ])->sum('amount');
                $dataDaysThisWeek[] = $totalTmp;
                $dataDaysThisWeekTotal += $totalTmp;

                $dataDaysLabels[$i] = $dataDaysLabels[$i] . ' - ' . $value->copy()->isoFormat('ddd D');
                $i++;
            }
        }

        return array(
            'dataDays'=> array(
                'labels' => $dataDaysLabels,
                'data' => array(
                    'thisWeek' => $dataDaysThisWeek,
                    'lastWeek' => $dataDaysLastWeek
                ),
                'total' => array(
                    'thisWeek' => $dataDaysThisWeekTotal,
                    'lastWeek' => $dataDaysLastWeekTotal
                ),
            ),
            'dataAmount' => $dataAmount,
            'dataItems' => $dataItems
        );
    }

    private function bill($datesThisWeek, $datesLastWeek, $agent, $thisWeekendSql, $lastWeekendSql): array
    {
        $dataDaysThisWeekTotal = 0;
        $dataDaysLastWeekTotal = 0;
        $dataDaysLabels = [];
        $dataDaysThisWeek = [];;
        $dataDaysLastWeek = [];

        $dataItems = array(
            'thisWeekend' => db_bills::where($thisWeekendSql)->count(),
            'lastWeekend' => db_bills::where($lastWeekendSql)->count(),
        );
        $dataAmount = array(
            'thisWeekend' => db_bills::where($thisWeekendSql)->sum('amount'),
            'lastWeekend' => db_bills::where($lastWeekendSql)->sum('amount')
        );

        foreach ($datesLastWeek as $value) {
            if ($value->copy()->isoFormat('dddd') != 'domingo') {
                $totalTmp = db_bills::where([
                    ['created_at', '>=', $value],
                    ['created_at', '<=', $value->copy()->endOfDay()],
                    ['id_agent', $agent]
                ])->sum('amount');
                $dataDaysLastWeek[] = $totalTmp;
                $dataDaysLastWeekTotal += $totalTmp;

                $dataDaysLabels[] = $value->copy()->isoFormat('ddd D');
            }
        }

        $i = 0;
        foreach ($datesThisWeek as $value) {
            if ($value->copy()->isoFormat('dddd') != 'domingo') {
                $totalTmp = db_bills::where([
                    ['created_at', '>=', $value],
                    ['created_at', '<=', $value->copy()->endOfDay()],
                    ['id_agent', $agent]
                ])->sum('amount');
                $dataDaysThisWeek[] = $totalTmp;
                $dataDaysThisWeekTotal += $totalTmp;

                $dataDaysLabels[$i] = $dataDaysLabels[$i] . ' - ' . $value->copy()->isoFormat('ddd D');
                $i++;
            }
        }

        return array(
            'dataDays'=> array(
                'labels' => $dataDaysLabels,
                'data' => array(
                    'thisWeek' => $dataDaysThisWeek,
                    'lastWeek' => $dataDaysLastWeek
                ),
                'total' => array(
                    'thisWeek' => $dataDaysThisWeekTotal,
                    'lastWeek' => $dataDaysLastWeekTotal
                ),
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
