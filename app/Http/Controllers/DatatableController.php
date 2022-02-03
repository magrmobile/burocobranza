<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\User;
use App\db_wallet;
use App\db_summary;
use App\db_debt;
use App\db_close_day;
use App\db_supervisor_has_agent;
use Carbon\Carbon;
use Auth;

class DatatableController extends Controller
{
    public function users() {
        $data = User::where('users.role', '<>', 'user')
        ->where('users.active_user','=','enabled')
        ->leftJoin('agent_has_supervisor', 'users.id', '=', 'id_user_agent')
        ->leftJoin('wallet', 'agent_has_supervisor.id_wallet', '=', 'wallet.id')
        ->select(
            'users.*',
            'wallet.name as wallet_name',
            'agent_has_supervisor.id_supervisor as id_supervisor'
        )
        ->get();

        foreach ($data as $datum) {
            if (User::where('id', $datum->id_supervisor)->exists()) {
                $datum->supervisor = User::where('id', $datum->id_supervisor)->first()->name;
            } else {
                $datum->supervisor = null;
            }

        }

        return datatables()->of($data)
            ->addColumn('action', function($user){
                $btn = '
                    <a href="'.route('user.edit', $user->id).'" class="btn btn-sm btn-primary">Editar</a>
                    <button onclick="deleteData('.$user->id.')" class="btn btn-sm btn-danger">Eliminar</button>';
                return $btn; 
                
            })
            ->make(true);
    }

    public function routes() {
        $data = db_wallet::leftJoin('countries', 'countries.id','=','wallet.country')
        ->select(
            'wallet.*',
            'countries.name as country_name'
        )
        ->get();

        return datatables()->of($data)
            ->addColumn('action', function($user){
                $btn = '<a href="'.route('route.edit', $user->id).'" class="btn btn-sm btn-primary">Editar</a>';
                    //<button onclick="deleteData('.$user->id.')" class="btn btn-sm btn-danger">Eliminar</button>';
                return $btn; 
                
            })
            ->make(true);
    }

    public function supervisor_agent() {
        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor',Auth::id())
            ->join('users','id_user_agent','=','users.id')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                'users.*',
                'wallet.name as wallet_name',
                'agent_has_supervisor.base as base_total'
            )
            ->get();
        
        foreach($data as $datum){
            $datum->today = Carbon::now()->toDateString();
        }

        return datatables()->of($data)
            ->addColumn('action', function($agent){
                $btn = "<a href='".url('supervisor/agent')."/".$agent->id."/edit' class='btn btn-sm btn-primary'>Base</a>";
                return $btn; 
            })
            ->make(true);
    }

    public function supervisor_close() {
        $data = db_supervisor_has_agent::where('agent_has_supervisor.id_supervisor',Auth::id())
            ->join('users','agent_has_supervisor.id_user_agent','=','users.id')
            ->get();

        foreach ($data as $datum){
            $datum->show = true;
            $datum->wallet_name = db_wallet::where('id',$datum->id_wallet)->first()->name;
            $summary=db_summary::whereDate('created_at','=',Carbon::now()->toDateString())
                ->where('id_agent',$datum->id_user_agernt)
                ->exists();

            if($summary){
                $datum->show = true;
            }

            $debt=db_debt::whereDate('created_at','=',Carbon::now()->toDateString())
                ->where('id_agent',$datum->id_user_agernt)
                ->exists();

            if($debt){
                $datum->show = true;
            }

            $close_day=db_close_day::where('id_agent',$datum->id_user_agent)
                ->whereDate('created_at','=',Carbon::now()->toDateString())
                ->exists();
            if($close_day){
                $datum->show = false;
            }
            
            $datum->today = Carbon::now()->toDateString();
        }

        return datatables()->of($data)
            ->addColumn('action', function($row){
                $btn = "<a href='".url('supervisor/close')."/".$row->id_user_agent."' class='btn btn-sm btn-danger'>Cerrar</a>";
                return $btn; 
            })
            ->make(true);
    }

    public function supervisor_tracker() {
        $data = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('users','id_user_agent','=','users.id')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                    'users.*',
                    'wallet.name as wallet_name'
                )
             ->get();

        foreach($data as $datum){
            $datum->today = Carbon::now()->toDateString();
        }

        return datatables()->of($data)
            ->addColumn('action', function($row){
                $btn = "<a href='".url('supervisor/tracker')."/create?id_agent=".$row->id."' class='btn btn-sm btn-success'>Seguir</a>";
                return $btn; 
            })
            ->make(true);
    }

    public function supervisor_statistics_agents() {
        $data = db_supervisor_has_agent::where('id_supervisor',Auth::id())
            ->join('users','id_user_agent','=','users.id')
            ->join('wallet','agent_has_supervisor.id_wallet','=','wallet.id')
            ->select(
                'users.*',
                'wallet.name as wallet_name'
            )
            ->get();
        
        foreach($data as $datum){
            $datum->today = Carbon::now()->toDateString();
        }

        return datatables()->of($data)
            ->addColumn('action', function($row){
                $btn = "<a href='".url('supervisor/statistics')."/create?id_agent=".$row->id."' class='btn btn-sm btn-success'>Seguir</a>";
                return $btn; 
            })
            ->make(true);
    }
 
}
