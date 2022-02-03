<?php

namespace App\Http\Controllers;

use App\db_bills;
use App\db_debt;
use App\db_summary;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class trackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supervisor_tracker.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id_agent;
        return view('supervisor_tracker.create');
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
    public function show(Request $request,$id)
    {
        $date = $request->date_start;

        if(!isset($date)){return 'Fecha Vacia';};

        $data_summary = db_summary::whereDate('summary.created_at','=',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('debt.id_agent',$id)
            ->join('debt','summary.id_debt','=','debt.id')
            ->join('users','debt.id_user','=','users.id')
            ->select(
                'users.name',
                'users.last_name',
                'debt.payment_number',
                'debt.amount_neto',
                'debt.id as id_debt',
                'summary.number_index',
                'summary.amount',
                'summary.created_at',
                DB::raw('SUM(summary.amount) as total_payment')
            )
            ->groupBy('summary.id')
            ->get();



        $data_debt = db_debt::whereDate('debt.created_at','=',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('debt.id_agent',$id)
            ->join('users','debt.id_user','=','users.id')
            ->select(
                'debt.id as debt_id',
                'users.id',
                'users.name',
                'users.last_name',
                'users.province',
                'debt.created_at',
                'debt.utility',
                'debt.payment_number',
                'debt.amount_neto')
            ->get();

        $data_bill = db_bills::whereDate('created_at',Carbon::createFromFormat('d/m/Y',$date)->toDateString())
            ->where('id_agent',$id)
            ->get();

        $data = array(
            'summary' => $data_summary,
            'debt' => $data_debt,
            'bills' => $data_bill,
            'total_summary' => $data_summary->sum('amount'),
            'total_debt' => $data_debt->sum('amount_neto')
        );

        return view('supervisor_tracker.summary',$data);
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
