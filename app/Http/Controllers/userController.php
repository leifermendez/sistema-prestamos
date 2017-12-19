<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_credit;
use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::user()->id;
            if(!db_supervisor_has_agent::where('id_user_agent',Auth::id())->exists()){
                die('No existe relacion Usuario y Agente');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user_has_agent = db_agent_has_user::where('id_agent',Auth::id())
            ->join('users','id_client','=','users.id')
            ->get();
        foreach ($user_has_agent as $user){
            if(db_credit::where('id_user',$user->id)->exists()){
                $user->closed = db_credit::where('status','close')->where('id_user',$user->id)->count();
                $user->inprogress = db_credit::where('status','inprogress')->where('id_user',$user->id)->count();
                $user->credit_count = db_credit::where('id_user',$user->id)->count();
            }

        }
        $user_has_agent = array(
            'clients' => $user_has_agent,
        );
        return view('client.index',$user_has_agent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $data = array(
            'user' => User::find($id),
            'payment_number' => DB::table('payment_number')->orderBy('name','asc')->get()
        );
        return view('client.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->level=='agent') {
            return 'No tienes permisos';
        }
        $name = $request->name;
        $last_name = $request->last_name;
        $address = $request->address;
        $province = $request->province;
        $phone = $request->phone;
        $nit = $request->nit_number;
        $utility = $request->utility;
        $payment_number = $request->payment_number;
        $amount = $request->amount;

        $redirect_error = '/client?msg=Fields_Null&status=error';
        if(!isset($name)){return redirect($redirect_error);};
        if(!isset($last_name)){return redirect($redirect_error);};
        if(!isset($address)){return redirect($redirect_error);};
        if(!isset($province)){return redirect($redirect_error);};
        if(!isset($phone)){return redirect($redirect_error);};
        if(!isset($nit)){return redirect($redirect_error);};
        if(!isset($utility)){return redirect($redirect_error);};
        if(!isset($payment_number)){return redirect($redirect_error);};
        if(!isset($amount)){return redirect($redirect_error);};

        $base=db_supervisor_has_agent::where('id_user_agent',Auth::id())->first()->base;
        $base_credit = db_credit::whereDate('created_at',Carbon::now()->toDateString())
            ->where('id_agent',Auth::id())
            ->sum('amount_neto');
        $base -= $base_credit;

        if($amount>$base){
            return 'No tienes dinero suficiente';
        }

        $values = array(
            'name' => strtoupper($name),
            'last_name' => strtoupper($last_name),
            'email' => $nit,
            'level' => 'user',
            'address' => strtoupper($address),
            'province' => strtoupper($province),
            'phone' => $phone,
            'password' => str_random(5),
            'nit' => $nit
        );

        if(!User::where('nit',$nit)->exists()){
            $id=User::insertGetId($values);
        }else{
            $id = User::where('nit',$nit)->first()->id;

            if(db_agent_has_user::where('id_client',$id)->exists()){
                $agent_data=db_agent_has_user::where('id_client',$id)->first();
                if($agent_data->id_agent!=Auth::id()){
                    return 'Este usuario ya esta asignado a otro Agente';
                }
            }
        }

        if(!db_agent_has_user::where('id_agent',Auth::id())->where('id_client',$id)->exists()){
            db_agent_has_user::insert([
                'id_agent'=>Auth::id(),
                'id_client'=>$id,
                'id_wallet'=>db_supervisor_has_agent::where('id_user_agent',Auth::id())->first()->id_wallet]);
        }

        if(db_credit::orderBy('order_list','DESC')->first()===null){
            $last_order=0;
        }else{
            $last_order=db_credit::orderBy('order_list','DESC')->first()->order_list;
        }

        $values = array(
            'created_at'=> Carbon::now(),
            'payment_number' => $payment_number,
            'utility' => $utility,
            'amount_neto' => $amount,
            'id_user' => $id,
            'id_agent' => Auth::id(),
            'order_list' => ($last_order)+1
        );
        db_credit::insert($values);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array(
            'user' => User::find($id),
        );
        return view('client.show',$data);
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
