<?php

namespace App\Http\Controllers;

use App\db_audit;
use App\db_credit;
use App\db_wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class creditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = db_credit::where('credit.id',$id)
            ->join('users','credit.id_user','=','users.id')
            ->select('credit.*',
                'users.name','users.last_name','users.nit','users.phone','users.province','users.address','users.status')
            ->first();

        return view('submenu.edit.credit',$data);
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
        $id_wallet = $request->id_wallet;
        $amount_neto = $request->amount_neto;
        if(!isset($amount_neto)){ return 'Amount vacio';};
        if(!isset($id_wallet)){ return 'ID Wallet';};

        db_credit::where('id',$id)->update(
            ['amount_neto'=>$amount_neto]
        );

        $wallet_audit = db_wallet::find($id_wallet);
        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode([
                'credit_id' => $id,
                'amount_neto'=>$amount_neto,
                'id_wallet'=>$id_wallet,
                'wallet' => $wallet_audit->name
            ]),
            'event' => 'update',
            'device' => $request->device,
            'type' => 'Cliente'
        );
        db_audit::insert($audit);

        return redirect('supervisor/menu/edit/create?id_wallet='.$id_wallet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $date_start = $request->date_start;
        $id_wallet = $request->id_wallet;

        if(!isset($id)){return 'ID vacio';};
        if(!db_credit::where('id',$id)->exists()){
            return 'No existe ID';
        }
        $credit = db_credit::where('credit.id', $id)
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select('credit.*', 'users.name as user_name')
            ->first();

        $agent = User::find($credit->id_agent);
        $credit['agent'] = $agent->name.' '.$agent->last_name;
        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode($credit),
            'event' => 'delete',
            'device' => $request->device,
            'type' => 'Credito'
        );

        db_audit::insert($audit);

        db_credit::where('id',$id)->delete();

        return redirect('supervisor/menu/edit/'.$id_wallet.'?date_start='.$date_start);
    }
}
