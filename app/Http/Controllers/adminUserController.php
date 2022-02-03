<?php

namespace App\Http\Controllers;

use App\db_countries;
use App\db_supervisor_has_agent;
use App\db_wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class adminUserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
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
        return view('admin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = $request->email;
        $username = $request->username;
        $name = $request->name;
        $pwd = $request->pwd;
        $role = $request->role;

        if (!isset($username)) {
            return 'Username vacio';
        };
        if (!isset($email)) {
            return 'Email vacio';
        };
        if (!isset($name)) {
            return 'Nombre vacio';
        };
        if (!isset($pwd)) {
            return 'Contraseña vacio';
        };
        if (!isset($role)) {
            return 'Nivel vacio';
        };

        if (User::where('username', $username)->exists()) {
            return 'Ya existe Username';
        }

        $values = array(
            'email' => $email,
            'username' => $username,
            'name' => $name,
            'role' => $role,
            'password' => bcrypt($pwd)
        );

        User::insert($values);

        return redirect('admin/user');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data_agent = User::where('role', 'agent')->get();
        foreach ($data_agent as $agent) {
            if (db_supervisor_has_agent::where('id_user_agent', $agent->id)->exists()) {
                $agent->ocuped = true;
            } else {
                $agent->ocuped = false;
            }
        }

        $data_wallets = db_wallet::all();
        foreach ($data_wallets as $wallet) {
            if (db_supervisor_has_agent::where('id_wallet', $wallet->id)->exists()) {
                $wallet->ocuped = true;
            } else {
                $wallet->ocuped = false;
            }
        }

        $data = array(
            'agents' => $data_agent,
            'user' => User::find($id),
            'wallets' => $data_wallets
        );

        return view('admin.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        $data = array(
            'user' => $data,
            'countries' => db_countries::all()
        );

        return view('admin.edit', $data);
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
        $act = $request->act;
        switch ($act) {
            case 'assign':
                $id_agent = $request->id_agent;
                $id_wallet = $request->id_wallet;

                $data_wallet = db_wallet::where('id', $id_wallet)->first();

                if (db_countries::where('id', $data_wallet->country)->exists()) {
                    $country = db_countries::where('id', $data_wallet->country)->first()->name;
                }

                $address = $data_wallet->address;


                if (!isset($id_agent)) {
                    return 'ID agent';
                };
                if (!isset($id_wallet)) {
                    return 'ID wallet';
                };

                $values = array(
                    'id_user_agent' => $id_agent,
                    'id_supervisor' => $id,
                    'created_at' => Carbon::now(),
                    'id_wallet' => $id_wallet
                );

                User::where('id', $id_agent)->update(['country' => $country, 'address' => $address]);

                db_supervisor_has_agent::insert($values);
                break;
            default:
                $username = $request->username;
                $email = $request->email;
                $name = $request->name;
                $pwd = $request->pwd;
                $role = $request->role;

                if (!isset($username)) {
                    return 'Username vacio';
                };
                if (!isset($email)) {
                    return 'Email vacio';
                };
                if (!isset($name)) {
                    return 'Nombre vacio';
                };
                if (!isset($pwd)) {
                    return 'Contraseña vacio';
                };

                $values = array(
                    'username' => $username,
                    'email' => $email,
                    'name' => $name,
                    'password' => bcrypt($pwd)
                );

                if (User::find($id)->role != 'admin') {
                    $values['role'] = $role;
                }

                User::where('id', $id)->update($values);
                break;
        }


        return redirect('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!isset($id)) {
            $response = array(
                'status' => 'fail',
                'msj' => 'Id vacio',
                'code' => 5
            );

            return response()->json($response);
        }

        if (!User::where('id', $id)->exists()) {
            $response = array(
                'status' => 'fail',
                'msj' => 'ID user no existe',
                'code' => 5
            );

            return response()->json($response);
        }

        User::where('id', $id)->update([
            'active_user' => 'disabled',
            'password' => Str::random(15),
        ]);

        return redirect('admin/user');

    }
}
