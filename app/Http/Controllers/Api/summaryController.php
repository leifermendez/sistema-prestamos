<?php

namespace App\Http\Controllers\Api;

use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class summaryController extends Controller
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

    public function index(Request $request)
    {
        try {
            $id_credit = $request->id_credit;
            if (!isset($id_credit)) {
                $response = array(
                    'status' => 'fail',
                    'msj' => 'ID Credito Vacio',
                    'code' => 5
                );
                return response()->json($response);
            } else {
                if (!db_credit::where('id', $id_credit)->exists()) {
                    $response = array(
                        'status' => 'fail',
                        'msj' => 'ID No existe',
                        'code' => 5
                    );
                    return response()->json($response);
                }
            }
            $sql[] = ['id_agent', '=', Auth::id()];
            if (isset($id_credit)) {
                $sql[] = ['id_credit', '=', $id_credit];
            }
            $data_credit = db_credit::find($id_credit);
            $tmp = db_summary::where($sql)->get();
            $amount = floatval(db_credit::find($id_credit)->amount_neto) + floatval(db_credit::find($id_credit)->amount_neto * db_credit::find($id_credit)->utility);
            foreach ($tmp as $t) {
                $amount -= $t->amount;
                $t->rest = $amount;
            }
            $data_credit->utility_amount = floatval($data_credit->utility * $data_credit->amount_neto);
            $data_credit->utility = floatval($data_credit->utility * 100);
            $data_credit->payment_amount = (floatval($data_credit->amount_neto + $data_credit->utility_amount) / floatval($data_credit->payment_number));

            $data_credit->total = floatval($data_credit->utility_amount + $data_credit->amount_neto);
            $amount_last = 0;
            if (db_summary::where($sql)->exists()) {
                $amount_last = db_summary::where($sql)->orderBy('id', 'desc')->first()->amount;
            }
            $last = array(
                'recent' => $amount_last,
                'rest' => ($data_credit->total) - (db_summary::where($sql)->sum('amount'))
            );

            $data = array(
                'clients' => $tmp,
                'user' => User::find(db_credit::find($id_credit)->id_user),
                'credit_data' => $data_credit,
                'other_credit' => db_credit::where('id_user', $data_credit->id_user)->get(),
                'last' => $last,
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
        try {
            $amount = $request->amount;
            $id_credit = $request->credit_id;
            $revision = $request->rev;
            if (!isset($revision)) {
                if (db_summary::whereDate('created_at', Carbon::now()->toDateString())
                    ->where('id_credit', $id_credit)->exists()) {
                    $response = array(
                        'status' => 'fail',
                        'msj' => 'Ya existe un pago hoy',
                        'code' => 0
                    );

                    return response()->json($response);
                }
            }


            $redirect_error = '/summary?msg=Fields_Null&status=error';
            if (!isset($amount)) {
                $response = array(
                    'status' => 'fail',
                    'msj' => $redirect_error,
                    'code' => 5
                );
                return response()->json($response);
            };
            if (!isset($id_credit)) {
                $response = array(
                    'status' => 'fail',
                    'msj' => $redirect_error,
                    'code' => 5
                );
                return response()->json($response);
            };
            $index = db_summary::where('id_credit', $id_credit)
                ->where('id_agent', Auth::id())
                ->count();
            $values = array(
                'amount' => $amount,
                'id_credit' => $id_credit,
                'id_agent' => Auth::id(),
                'created_at' => Carbon::now(),
                'number_index' => ($index + 1)
            );

            db_summary::insert($values);
            $sum = db_summary::where('id_credit', $id_credit)->sum('amount');
    //        dd($sum);
            if ($sum >= (db_credit::find($id_credit)->amount_neto) + (db_credit::find($id_credit)->amount_neto * db_credit::find($id_credit)->utility)) {
                db_credit::where('id', $id_credit)->update(['status' => 'close']);
            }


            $sql[] = ['id_agent', '=', Auth::id()];
            if (isset($id_credit)) {
                $sql[] = ['id_credit', '=', $id_credit];
            }
            $amount_last = 0;
            if (db_summary::where($sql)->exists()) {
                $amount_last = db_summary::where($sql)->orderBy('id', 'desc')->first()->amount;
            }
            $data_credit = db_credit::find($id_credit);
            $data_credit->setAttribute('total', floatval(($data_credit->utility * $data_credit->amount_neto) + ($data_credit->amount_neto)));


            $last = array(
                'recent' => $amount_last,
                'rest' => round(($data_credit->total) - (db_summary::where($sql)->sum('amount')), 2),
            );

            $response = array(
                'status' => 'success',
                'data' => $last,
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        try {
            $id_wallet = $request->id_wallet;
            $amount = $request->amount;

            if (!isset($id_wallet)) {
                $response = array(
                    'status' => 'fail',
                    'msj' => 'ID wallet',
                    'code' => 5
                );
                return response()->json($response);
            };
            if (!isset($amount)) {
                $response = array(
                    'status' => 'fail',
                    'msj' => 'Amount',
                    'code' => 5
                );
                return response()->json($response);
            };

            $values = array(
                'amount' => $amount,
            );
            $data = db_summary::where('id', $id)->update($values);
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
