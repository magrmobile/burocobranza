<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
Use JwtAuth;
use Carbon\Carbon;
use App\Stop;

use Illuminate\Auth\Events\Logout;
use Yadahan\AuthenticationLog\AuthenticationLog;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $credentials = $request->only('username','password');

        $api_attempt = Auth::guard('api')->attempt($credentials);

        if($api_attempt) {
            $user = Auth::guard('api')->user();
            $jwt = JwtAuth::generateToken($user);

            $ip = $request->ip();
            $userAgent = $request->userAgent();
            $known = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();

            $authenticationLog = new AuthenticationLog([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'login_at' => Carbon::now(),
            ]);
    
            $user->authentications()->save($authenticationLog);

            /*$lastStop = Stop::where('operator_id', $user->id)
                    ->latest('id')
                    ->first();

            if($lastStop == null) {
                $lastStopDateTimeStart = $user->lastLoginAt()->formatLocalized('%Y-%m-%d').' '.$user->lastLoginAt()->format('H:i:s');
            } else {
                $lastStopDateTimeStart = $lastStop->stop_datetime_end;
            }*/

            $success = true;
            $message = "Login Successfull";
            $id = $user->id;
            $supervisor_id = $user->supervisor_id;
            $active_user = $user->active_user;
            $role = $user->role;
            $name = $user->name;
            $username = $user->username;
            $process_id = $user->process_id;
            $lastStopDateTimeStart = $user->lastLoginAt()->formatLocalized('%Y-%m-%d').' '.$user->lastLoginAt()->format('H:i:s');
            
            // Return successfull sign in response with generated jwt.
            return compact('success','id','supervisor_id','active_user','role','name','username','jwt','message','lastStopDateTimeStart');

        } else {
            // Return response for failed attempt...
            $success = false;
            $message = 'Invalid Credentials';
            return response()->json(compact('success','message'), 401);
            //return compact('success','message');
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $authenticationLog = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();

        if (! $authenticationLog) {
            $authenticationLog = new AuthenticationLog([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);
        }

        $authenticationLog->logout_at = Carbon::now();

        $user->authentications()->save($authenticationLog);

        Auth::guard('api')->logout();

        $success = true;

        return compact('success');
    }
}
