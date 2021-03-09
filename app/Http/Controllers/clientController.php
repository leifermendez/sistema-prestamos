<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_countries;
use App\db_credit;
use App\db_supervisor_has_agent;
use App\db_wallet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = array(
            'wallet' => db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor', Auth::id())
                ->join('wallet', 'agent_has_supervisor.id_wallet', '=', 'wallet.id')
                ->get(),
            'agents' => db_supervisor_has_agent::where('id_supervisor', Auth::id())
                ->join('users', 'id_user_agent', '=', 'users.id')->get(),
            'countries' => db_countries::all(),
        );
        return view('supervisor_client.create', $data);
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
        $id_wallet = $request->wallet;
        $id_agent = $request->agent;
        $country = $request->country;

        if (!isset($id_wallet)) {
            return 'ID wallet vacio';
        };
        if (!isset($id_agent)) {
            return 'ID agente vacio';
        };
        if (!isset($country)) {
            return 'Pais vacio';
        };

        db_supervisor_has_agent::where('id_user_agent', $id_agent)->where('id_supervisor', Auth::id())
            ->update(['id_wallet' => $id_wallet]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = db_agent_has_user::where('agent_has_client.id_wallet', $id)
            ->join('users', 'agent_has_client.id_client', '=', 'users.id')
            ->join('credit', 'users.id', '=', 'credit.id_user')
            ->select(
                'users.name',
                'users.last_name',
                'users.province',
                'users.status',
                'users.id as id_user',
                DB::raw('COUNT(*) as total_credit')
            )
            ->groupBy('users.id')
            ->get();

        foreach ($data as $datum) {
            $datum->credit_inprogress = db_credit::where('status', 'inprogress')->where('id_user', $datum->id_user)->count();
            $datum->credit_close = db_credit::where('status', 'close')->where('id_user', $datum->id_user)->count();
        }
        $data = array(
            'clients' => $data
        );

        return view('supervisor_client.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        $data = array(
            'user' => $data
        );
        return view('supervisor_client.unique', $data);
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
        $name = $request->name;
        $last_name = $request->last_name;
        $nit = $request->nit_number;
        $address = $request->address;
        $province = $request->province;
        $phone = $request->phone;
        $status = $request->status;

        $values = array(
            'name' => $name,
            'last_name' => $last_name,
            'nit' => $nit,
            'address' => $address,
            'province' => $province,
            'phone' => $phone,
            'status' => $status
        );

        User::where('id', $id)->update($values);
        if (db_agent_has_user::where('id_client', $id)->exists()) {
            $wallet = db_agent_has_user::where('id_client', $id)->first();
            return redirect('supervisor/client/' . $wallet->id_wallet);
        } else {
            return redirect('supervisor/client/');
        }

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
