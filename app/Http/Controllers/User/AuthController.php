<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request):object{
        try{
            $validator = Validator::make($request->all(), $this->rules(),$this->message() );

            if ($validator->fails()) {
                return response()->json(['status'=>'error','errors' => $validator->errors()]);
            }
            $user =User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            if($user){
               return response()->json(['status'=>'success']);
           }else{
                return response()->json(['status'=>'error']);
            }

        }catch(Exception $ex){
            return response()->json(['status'=>'error']);
        }
    }
    public function login():object{
        try{
            $credentials = request(['email', 'password']);
            if ($token = auth::guard('api')->attempt($credentials)) {
                $user = auth::guard('api')->user();
                $user->api_token = $token;
                return response()->json(['status' => 'success', 'user' => $user]);
            }else{
                return response()->json(['status' => 'error']);

            }
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
    private function rules():array
    {
        return [
          'name' => ['required','unique:users','max:255'],
          'email'=> ['required','unique:users','email','max:255'],
          'password' => ['required','max:255']
        ];
    }
    private function message():array
    {
        return [
            'required' => __('messages.required'),
            'max' => __('messages.max'),
            'email.email' => __('messages.email'),
            'unique' => __('messages.unique'),
        ];
    }
}
