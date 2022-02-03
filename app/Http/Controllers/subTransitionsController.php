<?php

namespace App\Http\Controllers;

use App\db_agent_has_user;
use App\db_bills;
use App\db_debt;
use App\db_summary;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class subTransitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('submenu.transitions.create');
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
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        if(!isset($date_start)){return 'Fecha Inicio Vacia';};
        if(!isset($date_end)){return 'Fecha Final Vacia';};

        $data_debt = db_supervisor_has_agent::where('id_wallet',$id)
            ->join('debt','agent_has_supervisor.id_user_agent','=','debt.id_agent')
            ->join('users','debt.id_user','=','users.id')
            ->whereDate('debt.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('debt.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->select(
                'users.name',
                'users.last_name',
                'users.province',
                'debt.utility',
                'debt.amount_neto',
                'debt.created_at',
                'debt.id as debt_id',
                'debt.payment_number'
            )
            ->get();

        foreach ($data_debt as $d){
            $d->valor = (($d->amount_neto)+($d->amount_neto*$d->utility)-db_summary::where('id_debt',$d->debt_id)->sum('amount'));
        }

        $data_summary = db_supervisor_has_agent::where('id_wallet',$id)
            ->join('summary','agent_has_supervisor.id_user_agent','=','summary.id_agent')
            ->join('debt','summary.id_debt','=','debt.id')
            ->join('users','debt.id_user','=','users.id')
            ->whereDate('summary.created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->whereDate('summary.created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->select(
                'debt.id as debt_id',
                'users.id',
                'users.name',
                'users.last_name',
                'users.province',
                'summary.number_index',
                'summary.amount',
                'debt.amount_neto',
                'debt.utility',
                'summary.created_at',
                'debt.id as debt_id'
                )
            ->get();

        foreach ($data_summary as $data){
            $data->total_summary = db_summary::where('id_debt',$data->debt_id)->sum('amount');
        }

        $data_bill = db_bills::whereDate('created_at','>=',Carbon::createFromFormat('d/m/Y',$date_start)->toDateString())
            ->join('list_bill','bills.type','=','list_bill.id')
            ->whereDate('created_at','<=',Carbon::createFromFormat('d/m/Y',$date_end)->toDateString())
            ->where('id_wallet',$id)
            ->select(
                'bills.*',
                'list_bill.name as type_bill'
            )
            ->get();


        $data = array(
            'summary' => $data_summary,
            'debt' => $data_debt,
            'bills' => $data_bill,
            'total_summary' => $data_summary->sum('amount'),
            'total_debt' => $data_debt->sum('amount_neto'),
            'total_bills' => $data_bill->sum('amount'),
            'id_wallet' => $id
        );

        return view('submenu.transitions.index',$data);
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
