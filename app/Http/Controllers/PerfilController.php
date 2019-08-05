<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nada = bcrypt('secret');
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
    public function show()
    {
        return view('perfil.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('perfil.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {
            $mensaje = null;
            $old_password = Hash::check($request->inputOldPassword, auth()->user()->password);
            if($old_password) {
                $pass = Hash::make($request->inputNewPassword);

                $user = User::find(auth()->user()->id);
                $user->password = $pass;
                $user->save();

            }else {
                $mensaje = 'La contraseña anterior es incorrecta.';
            }

            $http_response["validar"] = $mensaje;
            $http_response["response"] = true;
            $http_response["message"] = "La contraseña se cambio exitosamente.";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
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