<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=> 'required',
            'email'=>'required|email',
            'password'=>'required|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        //develve respuesta
        return response()->json([
            "status"=>1, //si esta todo ok
            "msg"=>"Regsitro exitoso",
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('email',$request->email)->first();

        if(isset($user->id)){
            if(Hash::check($request->password,$user->password)){//compara los password
                //creamos el token
                $token = $user->createToken("auth_token")->plainTextToken;
                //si esta todo ok
                return response()->json([
                    "status"=>1, //si esta todo ok
                    "msg"=>"Login correcto",
                    "access_token"=>$token
                ]);

            }else{
                return response()->json([
                    "status"=>0, //si esta todo ok
                    "msg"=>"La password es incorrecta",
                ],404);
            }
        }else{
            return response()->json([
                "status"=>0, //si esta todo ok
                "msg"=>"Credenciales incorrectas",
            ],404);
        }
    }

    public function userProfile(){
        return response()->json([
            "status"=>1, //si esta todo ok
            "msg"=>"Acerca del Perfil de Usuario",
            "data"=>auth()->user()
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status"=>1, //si esta todo ok
            "msg"=>"Logout exitoso",
        ]);
    }
}
