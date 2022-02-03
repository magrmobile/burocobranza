<?php

namespace App\Http\Controllers;

use App\db_debt;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class subHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!isset($request->id_wallet)){
            return 'No existe ID Wallet';
        }
        
        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor',Auth::id())
            ->where('agent_has_supervisor.id_wallet',$request->id_wallet)
            ->join('debt','agent_has_supervisor.id_user_agent','=','debt.id_agent')
            ->join('users','debt.id_user','=','users.id')
            ->select('users.name',
                'users.last_name',
                'debt.amount_neto',
                'debt.payment_number',
                'debt.utility',
                'debt.id as debt_id')
            ->groupBy('users.id')
            ->get();


        foreach ($data as $datum){
            $datum->setAttribute('amount_neto',($datum->amount_neto)+($datum->amount_neto*$datum->utility));
            $datum->summary_total = $datum->amount_neto-(db_summary::where('id_debt',$datum->debt_id)
                ->sum('amount'));

            $datum->number_index = db_summary::where('id_debt',$datum->debt_id)
                    ->count();
        }

        $data_wallet = db_supervisor_has_agent::where('id_supervisor',Auth::id())
        ->where('agent_has_supervisor.id_wallet',$request->id_wallet)
        ->first();
        $total_summary = db_summary::where('id_agent',$data_wallet->id_user_agent)->sum('amount');
        $total_debt = db_debt::where('id_agent',$data_wallet->id_user_agent)->get();
        $total_debt_amount = 0;
        foreach ($total_debt as $cred){
            $total_debt_amount+=($cred->amount_neto)+($cred->amount_neto*$cred->utility);
        }
        $total_rest = ($total_debt_amount-$total_summary);


        $data = array(
            'clients' => $data,
            'total' => $total_summary,
            'total_rest' => $total_rest,
            'total_debt' => $total_debt_amount,
            'id_wallet' => $data_wallet->id
        );

        return view('submenu.history.index',$data);
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
    public function show($id)
    {
        $id_debt = $id;

        if(!isset($id_debt)){
            return 'ID debto Vacio';
        }else{
            if(!db_debt::where('id',$id_debt)->exists()){
                return 'ID No existe';
            }
        }
        $id_agent = db_supervisor_has_agent::where('id_supervisor',Auth::id())->first()->id_user_agent;
        $sql[]=['id_agent','=',$id_agent];
        if(isset($id_debt)){
            $sql[]=['id_debt','=',$id_debt];
        }
        $data_debt = db_debt::find($id_debt);
        $tmp = db_summary::where($sql)->get();
        $amount = floatval(db_debt::find($id_debt)->amount_neto)+floatval(db_debt::find($id_debt)->amount_neto*db_debt::find($id_debt)->utility);
        foreach ($tmp as $t){

            $amount-= $t->amount;
            $t->rest = $amount;
        }
        $data_debt->utility_amount = floatval($data_debt->utility*$data_debt->amount_neto);
        $data_debt->utility = floatval($data_debt->utility*100);
        $data_debt->payment_amount = (floatval($data_debt->amount_neto+$data_debt->utility_amount)/floatval($data_debt->payment_number));

        $data_debt->total = floatval($data_debt->utility_amount+$data_debt->amount_neto);
        $data = array(
            'clients' => $tmp,
            'debts' => db_debt::where('id_user',$data_debt->id_user)->orderBy('id','desc')->get(),
            'user' =>  User::find(db_debt::find($id_debt)->id_user),
            'debt_data' => $data_debt,
        );
        return view('submenu.history.show',$data);
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
