<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_credit;
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

        $data_user = db_credit::where('credit.id_agent', Auth::id())
            ->join('users', 'credit.id_user', '=', 'users.id')
            ->select('credit.*', 'users.id as id_user',
                'users.name', 'users.last_name'
            )
            ->get();

        foreach ($data_user as $data) {
            if (db_credit::where('id_user', $data->id_user)->where('id_agent', Auth::id())->exists()) {

                $data->setAttribute('credit_id', $data->id);
                $data->setAttribute('amount_neto', ($data->amount_neto) + ($data->amount_neto * $data->utility));
                $data->setAttribute('positive', $data->amount_neto - (db_summary::where('id_credit', $data->id)
                        ->where('id_agent', Auth::id())
                        ->sum('amount')));
                $data->setAttribute('payment_current', db_summary::where('id_credit', $data->id)->count());
            }

        }
        $data = array(
            'clients' => $data_user
        );

        return view('payment.index', $data);
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
        $amount = $request->amount;
        $credit_id = $request->credit_id;

        $redirect_error = '/payment?msg=Fields_Null&status=error';
        if (!isset($credit_id)) {
            return redirect($redirect_error);
        };
        if (!isset($amount)) {
            return redirect($redirect_error);
        };

        $values = array(
            'created_at' => Carbon::now(),
            'amount' => $amount,
            'id_agent' => Auth::id(),
            'id_credit' => $credit_id,
        );

        db_summary::insert($values);

        return redirect('');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!db_credit::where('id', $id)->exists()) {
            return 'No existe creido';
        } else {
            $data_tmp = db_credit::where('id', $id)->first();
            if (Auth::id() != $data_tmp->id_agent) {
                return 'No tienes permisos';
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


        if ($request->input('format') === 'json') {
            $response = array(
                'status' => 'success',
                'data' => $data,
                'code' => 0
            );
            return response()->json($response);
        } else {
            return view('payment.create', $data);
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
        $id_credit = $request->id_credit;

        if (!isset($id_credit)) {
            return 'ID cretido';
        };

        $values = array(
            'created_at' => Carbon::now(),
            'id_credit' => $id_credit,
            'id_user' => $id
        );

        db_not_pay::insert($values);

        if ($request->ajax) {
            $response = array(
                'status' => 'success'
            );
            return response()->json($response);
        } else {
            return redirect('route');
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
