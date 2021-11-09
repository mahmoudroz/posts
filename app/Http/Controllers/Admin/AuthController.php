<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login():object{

     try{
         $credentials = request(['email', 'password']);
         if ($token = Auth::guard('admin-api')->attempt($credentials)) {
             $admin = Auth::guard('admin-api')->user();
             $admin->api_token = $token;
             return response()->json(['status' => 'success', 'admin' => $admin]);
         }else {
             return response()->json(['status' => 'error']);

         }
     }catch (Exception $ex){
         return response()->json(['status' => 'error']);
     }
    }
    public function getUsers():object{
        try{
            ////select('title_' .$this->get_default_lang() . ' as title','body_'.$this->get_default_lang() . ' as body')->
            $users= User::select()->get();
            if($users){
                return response()->json(['status'=>'success','data'=>$users]);
            }
            else{
                return response()->json(['status'=>'error']);

            }
        }catch (Exception $ex){
            return response()->json(['status'=>'error']);
        }

    }
    public function deleteUser($id):object{
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return response()->json(['status' => 'success']);
            }
            return response()->json(['status' => 'error']);

        }catch (Exception $ex){
            return response()->json(['status' => 'error']);
        }
    }
    public function logout():object
    {
        try{
            auth()->logout();

            return response()->json(['status' => 'success']);

        }catch (Exception $ex){
            return response()->json(['status' => 'error']);
        }
    }


}
