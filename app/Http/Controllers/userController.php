<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_audit;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            if (!db_supervisor_has_agent::where('id_user_agent', Auth::id())->exists()) {
                die('No existe relacion Usuario y Agente');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $payment_number = DB::table('payment_number')->get();
        array(
            $paymente_number = 'payment_number'
        );
        $user_current = Auth::user();

        $user_has_agent = db_agent_has_user::where('id_agent', Auth::id())
            ->join('users', 'id_client', '=', 'users.id')
            ->get();

        if ($user_current->level === 'admin') {
            $user_has_agent = db_agent_has_user::join('users', 'id_client', '=', 'users.id')
                ->get();
        }


        foreach ($user_has_agent as $user) {
            if (db_credit::where('id_user', $user->id)->exists()) {
                $user->closed = db_credit::where('status', 'close')->where('id_user', $user->id)->count();
                $user->inprogress = db_credit::where('status', 'inprogress')->where('id_user', $user->id)->count();
                $user->credit_count = db_credit::where('id_user', $user->id)->count();
                $user->amount_net = db_credit::where('id_user', $user->id)
                    ->where('status', 'inprogress')->get()->toArray();
                if (sizeOf($user->amount_net)) {
                    $tmp_credit = 0;
                    $user->gap_credit = 0;
                    $user->summary_net = 0;
                    foreach ($user->amount_net as $key => $value) {
                        $user->summary_net += db_summary::where('id_credit', $value['id'])
                            ->sum('amount');
                        $tmp_credit += $value['amount_neto'] ?? 0;
                        $user->gap_credit += $value['amount_neto'] * $value['utility'];
                    }
                    $user->sum_amount_gap = $tmp_credit + $user->gap_credit;
                    $tmp_rest = $tmp_credit - $user->summary_net;
                    $user->summary_net = $tmp_rest;
                } else {
                    $user->summary_net = 0;
                }
            }
        }

        $total_pending = floatval($user_has_agent->sum('summary_net') + $user_has_agent->sum('gap_credit'));
        $user_has_agent = array(
            'clients' => $user_has_agent,
            'total_pending' => $total_pending
        );
        //        dd($user_has_agent);
        return view('client.index', $user_has_agent);
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
            'payment_number' => DB::table('payment_number')->orderBy('name', 'asc')->get()
        );
        return view('client.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->level == 'agent') {
            return 'No tienes permisos';
        }
        $name = $request->name;
        $_id = $request->id;
        $last_name = $request->last_name;
        $address = $request->address;
        $province = $request->province;
        $phone = $request->phone;
        $nit = $request->nit_number;
        $utility = $request->utility;
        $payment_number = $request->payment_number;
        $amount = $request->amount;
        $lat = $request->lat;
        $lng = $request->lng;

        $redirect_error = '/client?msg=Fields_Null&status=error';
        if (!isset($name)) {
            return redirect($redirect_error);
        };
        if (!isset($last_name)) {
            return redirect($redirect_error);
        };
        if (!isset($address)) {
            return redirect($redirect_error);
        };
        if (!isset($province)) {
            return redirect($redirect_error);
        };
        if (!isset($phone)) {
            return redirect($redirect_error);
        };
        if (!isset($nit)) {
            return redirect($redirect_error);
        };
        if (!isset($utility)) {
            return redirect($redirect_error);
        };
        if (!isset($payment_number)) {
            return redirect($redirect_error);
        };
        if (!isset($amount)) {
            return redirect($redirect_error);
        };

        $base = db_supervisor_has_agent::where('id_user_agent', Auth::id())->first()->base;
        $base_credit = db_credit::whereDate('created_at', Carbon::now()->toDateString())
            ->where('id_agent', Auth::id())
            ->sum('amount_neto');
        $base -= $base_credit;


        $values = array(
            'name' => $this->removeAccents(strtoupper($name)),
            'last_name' => $this->removeAccents(strtoupper($last_name)),
            'email' => $nit,
            'level' => 'user',
            'address' => $this->removeAccents(strtoupper($address)),
            'province' => $this->removeAccents(strtoupper($province)),
            'phone' => $phone,
            'password' => Str::random(5),
            'lat' => $lat,
            'lng' => $lng,
            'nit' => $nit
        );

        if (!User::where('nit', $nit)->exists()) {
            $id = User::insertGetId($values);
        } else {
            $id = User::where('nit', $nit)->first()->id;
            if ($_id == $id) {
                if (db_agent_has_user::where('id_client', $id)->exists()) {
                    $agent_data = db_agent_has_user::where('id_client', $id)->first();
                    if ($agent_data->id_agent != Auth::id()) {
                        return 'Este usuario ya esta asignado a otro Agente';
                    }
                }
            } else {
                return 'Ya existe un ususario con el mismo nit';
            }
        }

        if (!db_agent_has_user::where('id_agent', Auth::id())->where('id_client', $id)->exists()) {
            db_agent_has_user::insert([
                'id_agent' => Auth::id(),
                'id_client' => $id,
                'id_wallet' => db_supervisor_has_agent::where('id_user_agent', Auth::id())->first()->id_wallet
            ]);
        }
        $order_list_credit = 0;
        if (db_credit::where('credit.id_user', $id)->where('id_agent', Auth::id())->exists()) {
            $order_list_credit = db_credit::where('credit.id_user', $id)->where('credit.id_agent', Auth::id())->orderBy('created_at', 'desc')->first()->order_list;
        }
        if (db_credit::orderBy('order_list', 'DESC')->first() === null) {
            $last_order = 0;
        } else {
            $last_order = db_credit::orderBy('order_list', 'DESC')->first()->order_list;
        }

        $values = array(
            'created_at' => Carbon::now(),
            'payment_number' => $payment_number,
            'utility' => $utility,
            'amount_neto' => $amount,
            'id_user' => $id,
            'id_agent' => Auth::id(),
            'order_list' => $order_list_credit > 0 ? $order_list_credit : ($last_order) + 1
        );
        db_credit::insert($values);

        $user_audit = User::find($id);
        $values['user_name'] = $user_audit->name.' '.$user_audit->last_name;
        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode($values),
            'event' => 'create',
            'device' => $request->device,
            'type' => 'Cliente'
        );
        db_audit::insert($audit);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array(
            'user' => User::find($id),
        );
        return view('client.show', $data);
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

    /* Función que elimina los acantos y letras ñ*/
    private function removeAccents($string){
        $original = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿ';
        $modify = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYBSAAAAAAACEEEEIIIIDOOOOOOUUUYYBY';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($original), $modify);
        return utf8_encode($string);
    }
}
