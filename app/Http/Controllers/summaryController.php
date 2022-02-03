<?php

namespace App\Http\Controllers;

use App\db_debt;
use App\db_summary;
use App\db_supervisor_has_agent;
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
        $id_debt = $request->id_debt;
        if (!isset($id_debt)) {
            return 'ID Deuda Vacio';
        } else {
            if (!db_debt::where('id', $id_debt)->exists()) {
                return 'ID No existe';
            }
        }
        $sql[] = ['id_agent', '=', Auth::id()];
        if (isset($id_debt)) {
            $sql[] = ['id_debt', '=', $id_debt];
        }
        $data_debt = db_debt::find($id_debt);
        $tmp = db_summary::where($sql)->get();
        $amount = floatval(db_debt::find($id_debt)->amount_neto) + floatval(db_debt::find($id_debt)->amount_neto * db_debt::find($id_debt)->utility);
        foreach ($tmp as $t) {
            $amount -= $t->amount;
            $t->rest = $amount;
        }
        $data_debt->utility_amount = floatval($data_debt->utility * $data_debt->amount_neto);
        $data_debt->utility = floatval($data_debt->utility * 100);
        $data_debt->payment_amount = (floatval($data_debt->amount_neto + $data_debt->utility_amount) / floatval($data_debt->payment_number));

        $data_debt->total = floatval($data_debt->utility_amount + $data_debt->amount_neto);
        $amount_last = 0;
        if (db_summary::where($sql)->exists()) {
            $amount_last = db_summary::where($sql)->orderBy('id', 'desc')->first()->amount;
        }
        $last = array(
            'recent' => $amount_last,
            'rest' => ($data_debt->total) - (db_summary::where($sql)->sum('amount'))
        );

        $data = array(
            'clients' => $tmp,
            'user' => User::find(db_debt::find($id_debt)->id_user),
            'debt_data' => $data_debt,
            'other_debt' => db_debt::where('id_user', $data_debt->id_user)->get(),
            'last' => $last,
        );

        return view('summary.index', $data);
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

        $amount = $request->amount;
        $id_debt = $request->debt_id;
        $revision = $request->rev;
        if (!isset($revision)) {
            if (db_summary::whereDate('created_at', Carbon::now()->toDateString())
                ->where('id_debt', $id_debt)->exists()) {
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
            return redirect($redirect_error);
        };
        if (!isset($id_debt)) {
            return redirect($redirect_error);
        };
        $index = db_summary::where('id_debt', $id_debt)
            ->where('id_agent', Auth::id())
            ->count();
        $values = array(
            'amount' => $amount,
            'id_debt' => $id_debt,
            'id_agent' => Auth::id(),
            'created_at' => Carbon::now(),
            'number_index' => ($index + 1)
        );

        db_summary::insert($values);
        $sum = db_summary::where('id_debt', $id_debt)->sum('amount');
//        dd($sum);
        if ($sum >= (db_debt::find($id_debt)->amount_neto) + (db_debt::find($id_debt)->amount_neto * db_debt::find($id_debt)->utility)) {
            db_debt::where('id', $id_debt)->update(['status' => 'close']);
        }


        $sql[] = ['id_agent', '=', Auth::id()];
        if (isset($id_debt)) {
            $sql[] = ['id_debt', '=', $id_debt];
        }
        $amount_last = 0;
        if (db_summary::where($sql)->exists()) {
            $amount_last = db_summary::where($sql)->orderBy('id', 'desc')->first()->amount;
        }
        $data_debt = db_debt::find($id_debt);
        $data_debt->setAttribute('total', floatval(($data_debt->utility * $data_debt->amount_neto) + ($data_debt->amount_neto)));


        $last = array(
            'recent' => $amount_last,
            'rest' => round(($data_debt->total) - (db_summary::where($sql)->sum('amount')), 2),
        );

        if ($request->input('format') === 'json') {
            $response = array(
                'status' => 'success',
                'data' => $last,
                'code' => 0
            );
            return response()->json($response);
        } else {
            return redirect('summary?id_debt=' . $id_debt . '&show=last');
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
        $id_wallet = $request->id_wallet;
        $amount = $request->amount;

        if (!isset($id_wallet)) {
            return 'ID wallet';
        };
        if (!isset($amount)) {
            return 'Amount';
        };

        $values = array(
            'amount' => $amount,
        );
        db_summary::where('id', $id)->update($values);

        return redirect('supervisor/menu/edit/create?id_wallet=' . $id_wallet);
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
