<?php

namespace App\Http\Controllers;

use App\db_audit;
use App\db_countries;
use App\db_wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminRouteController extends Controller
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
        $data = db_countries::all();
        $data = array(
            'countries' => $data
        );
        return view('admin.route_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $country = $request->country;
        $address = $request->address;

        $values = array(
            'name' => $name,
            'created_at' => Carbon::now(),
            'country' => $country,
            'address' => $address
        );
        db_wallet::insert($values);


        $audit = array(
            'created_at' => Carbon::now(),
            'id_user' => Auth::id(),
            'data' => json_encode($values),
            'event' => 'create',
            'device' => $request->device,
            'type' => 'Cartera'
        );
        db_audit::insert($audit);

        return redirect('home');
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
