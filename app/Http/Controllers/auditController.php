<?php

namespace App\Http\Controllers;

use App\db_audit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class auditController extends Controller
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
        $sql = [];

        if (isset($date_start) && isset($date_end)) {
            $sql[] = ['audit.created_at', '>=', Carbon::createFromFormat('d/m/Y', $date_start)];
            $sql[] = ['audit.created_at', '<=', Carbon::createFromFormat('d/m/Y', $date_end)];
        } else {
            $sql[] = ['audit.created_at', '>=', Carbon::now()->startOfDay()];
            $sql[] = ['audit.created_at', '<=', Carbon::now()->endOfDay()];
        }

        $data = db_audit::where($sql)
        ->join('users', 'audit.id_user', '=', 'users.id')
        ->select('audit.*', 'users.name as user_name',
            'users.last_name as user_last_name',
            'users.level as user_level'
        )->orderBy('created_at','DESC')->get();

        $data = array(
            'audits' => $data
        );

        return view('audit.index', $data);
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
