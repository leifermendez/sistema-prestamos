<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_list_bills;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class billsupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date_star = $request->date_start;
        $date_end = $request->date_end;
        $category = $request->category;

        $list_categories = db_list_bills::all();

        $ormQry = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor', Auth::id())
            ->join('wallet', 'agent_has_supervisor.id_wallet', '=', 'wallet.id')
            ->join('bills', 'wallet.id', '=', 'bills.id_wallet')
            ->join('list_bill', 'bills.type', '=', 'list_bill.id')
            ->join('users', 'bills.id_agent', '=', 'users.id')
            ->select(
                'bills.created_at as created_at',
                'wallet.name as wallet_name',
                'bills.type as type',
                'bills.description',
                'list_bill.name as category_name',
                'users.name as user_name',
                DB::raw('SUM(bills.amount) as amount')
            );

        $ormSum = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor', Auth::id())
            ->join('wallet', 'agent_has_supervisor.id_wallet', '=', 'wallet.id')
            ->join('bills', 'wallet.id', '=', 'bills.id_wallet');

        if (isset($date_star)) {
            $ormQry = $ormQry->where('bills.created_at', '>=',
                Carbon::createFromFormat('d/m/Y', $date_star)->toDateString());
            $ormSum = $ormSum
                ->where('bills.created_at', '>=', Carbon::createFromFormat('d/m/Y', $date_star)->toDateString());
        }

        if (isset($date_end)) {
            $ormQry = $ormQry->where('bills.created_at', '<=',
                Carbon::createFromFormat('d/m/Y', $date_end)->toDateString());
            $ormSum = $ormSum
                ->where('bills.created_at', '<=', Carbon::createFromFormat('d/m/Y', $date_end)->toDateString());
        }

        if (isset($category)) {
            $ormQry = $ormQry->where('bills.type', $category);
        }
        $sum = $ormSum->sum('bills.amount');

        $data = $ormQry->groupBy('bills.id')->get();


        $data = array(
            'clients' => $data,
            'sum' => $sum,
            'list_categories' => $list_categories,
        );


        return view('supervisor_bill.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = db_supervisor_has_agent::where('id_supervisor', Auth::id())
            ->join('wallet', 'id_wallet', '=', 'wallet.id')
            ->get();

        $data = array(
            'wallet' => $data,
            'list_bill' => db_list_bills::all(),
        );

        return view('supervisor_bill.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_wallet = $request->id_wallet;
        $amount = $request->amount;
        $bill = $request->bill;
        $description = $request->description;
        if (!isset($id_wallet)) {
            return 'ID wallet vacio';
        };
        if (!isset($amount)) {
            return 'Monto vacio';
        };
        if (!isset($bill)) {
            return 'Bill vacio';
        };

        $values = array(
            'created_at' => Carbon::now(),
            'description' => $description,
            'id_wallet' => $id_wallet,
            'type' => db_list_bills::find($bill)->name,
            'amount' => $amount
        );

        db_bills::insert($values);

        return redirect('/supervisor/bill');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = db_bills::where('id', $id)->first();

        return view('submenu.bill.edit', $data);
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
        $amount = $request->amount;
        $type = $request->type;
        $description = $request->description;
        $id_wallet = $request->id_wallet;

        if (!isset($type)) {
            return 'Type ';
        };
        if (!isset($amount)) {
            return 'Amount ';
        };
        if (!isset($id_wallet)) {
            return 'ID wallet ';
        };

        $values = array(
            'amount' => $amount,
            'description' => $description,
            'type' => $type
        );
        db_bills::where('id', $id)->update($values);

        return redirect('supervisor/menu/edit/create?id_wallet=' . $id_wallet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $date_start = $request->date_start;
        $id_wallet = $request->id_wallet;


        if (!isset($id)) {
            return 'ID vacio';
        };
        if (!db_bills::where('id', $id)->exists()) {
            return 'No existe ID';
        }
        db_bills::where('id', $id)->delete();

        return redirect('supervisor/menu/edit/' . $id_wallet . '?date_start=' . $date_start);
    }
}
