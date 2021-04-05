<?php

namespace App\Http\Controllers\Api;

use App\db_agent_has_user;
use App\db_credit;
use App\Http\Controllers\Controller;
use App\db_not_pay;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class paymentController extends Controller
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
        try {
            $data_user = db_credit::where('credit.id_agent', Auth::id())
                ->join('users', 'credit.id_user', '=', 'users.id')
                ->select('credit.*', 'users.id as id_user',
                    'users.name', 'users.last_name'
                )
                ->get();

            foreach ($data_user as $data) {
                if (db_credit::where('id_user', $data->id_user)->where('id_agent', Auth::id())->exists()) {
                    
                    $tmp_amount = db_summary::where('id_credit', $data->id)
                    ->where('id_agent', Auth::id())
                    ->sum('amount');
                    $amount_neto = ($data->amount_neto) + ($data->amount_neto * $data->utility);
                    $tmp_quote = round(floatval(($amount_neto / $data->payment_number)), 2);
                    $tmp_rest = round(floatval($amount_neto - $tmp_amount), 2);
                    $data->setAttribute('credit_data', array(
                        'positive' => $tmp_amount,
                        'rest' => $tmp_rest,
                        'payment_done' => db_summary::where('id_credit', $data->id)->count(),
                        'payment_quote' => ($tmp_rest > $tmp_quote) ? $tmp_rest : $tmp_quote
                    ));
                    $data->setAttribute('credit_id', $data->id);
                    $data->setAttribute('amount_neto', $amount_neto);
                    $data->setAttribute('positive', $data->amount_neto - $tmp_amount);
                    $data->setAttribute('payment_current', db_summary::where('id_credit', $data->id)->count());
                }

            }
            $data = array(
                'clients' => $data_user
            );
            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        
        } catch (\Exception $e) {
            $response = array(
                'status' => 'fail',
                'msj' => $e->getMessage(),
                'code' => 5
            );
            return response()->json($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $amount = $request->amount;
            $credit_id = $request->credit_id;

            $redirect_error = '/payment?msg=Fields_Null&status=error';
            if (!isset($credit_id)) {            
                return response()->json(array(
                    'status' => 'fail',
                    'msj' => $redirect_error,
                    'code' => 5
                ));
            };
            if (!isset($amount)) {
                return response()->json(array(
                    'status' => 'fail',
                    'msj' => $redirect_error,
                    'code' => 5
                ));
            };

            $values = array(
                'created_at' => Carbon::now(),
                'amount' => $amount,
                'id_agent' => Auth::id(),
                'id_credit' => $credit_id,
            );

            $data = db_summary::insert($values);
            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        
        } catch (\Exception $e) {
            $response = array(
                'status' => 'fail',
                'msj' => $e->getMessage(),
                'code' => 5
            );
            return response()->json($response);
        }

        return response()->json($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            if (!db_credit::where('id', $id)->exists()) {
                return response()->json('No existe creido');       
            } else {
                $data_tmp = db_credit::where('id', $id)->first();
                if (Auth::id() != $data_tmp->id_agent) {
                    return response()->json('No tienes permisos');
                }
            }

            $data = db_credit::find($id);
            $data->user = User::find($data->id_user);
            $tmp_amount = db_summary::where('id_credit', $id)
                ->where('id_agent', Auth::id())
                ->sum('amount');
            $amount_neto = $data->amount_neto;
            $amount_neto += floatval($amount_neto * $data->utility);
            $data->amount_neto = $amount_neto;


    //        dd([$amount_neto,$tmp_amount]);

            $tmp_quote = round(floatval(($amount_neto / $data->payment_number)), 2);
            $tmp_rest = round(floatval($amount_neto - $tmp_amount), 2);

            $data->credit_data = array(
                'positive' => $tmp_amount,
                'rest' => round(floatval($amount_neto - $tmp_amount), 2),
                'payment_done' => db_summary::where('id_credit', $id)->count(),
                'payment_quote' => ($tmp_rest > $tmp_quote) ? $tmp_rest : $tmp_quote
            );

            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        
        } catch (\Exception $e) {
            $response = array(
                'status' => 'fail',
                'msj' => $e->getMessage(),
                'code' => 5
            );
            return response()->json($response);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            $id_credit = $request->id_credit;

            if (!isset($id_credit)) {
                return 'ID cretido';
            };

            $values = array(
                'created_at' => Carbon::now(),
                'id_credit' => $id_credit,
                'id_user' => $id
            );

            $data = db_not_pay::insert($values);
            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        
        } catch (\Exception $e) {
            $response = array(
                'status' => 'fail',
                'msj' => $e->getMessage(),
                'code' => 5
            );
            return response()->json($response);
        }
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
}
