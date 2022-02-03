<?php

namespace App\Http\Controllers;

use App\db_countries;
use App\db_wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class adminRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.route_index');
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

        return redirect('admin/route');
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
        $data = db_wallet::find($id);
        $data = array(
            'route' => $data,
            'countries' => db_countries::all()
        );

        return view('admin.route_edit', $data);
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
        $name = $request->name;
        $country = $request->country;
        $address = $request->address;

        $values = array(
            'name' => $name,
            'created_at' => Carbon::now(),
            'country' => $country,
            'address' => $address
        );

        db_wallet::where('id', $id)->update($values);

        return redirect('admin/route');
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
