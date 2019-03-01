<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Encuesta;
use App\Models\Opcion;
use App\Models\EncuestaOpcion;

class EncuestaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encuestas = Encuesta::where('estado', 'Activo')->orderBy('created_at', 'DESC')->paginate(8);

        return view('encuesta.index')->with('encuestas', $encuestas);
    }

    /**
     * Crea encuestas en la pagina de inicio con un Ajax.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearEncuesta(Request $request)
    {
        
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {

            $Encuesta = new Encuesta();
            $Encuesta->titulo = $request->titulo;
            $Encuesta->descripcion = $request->descripcion;
            $Encuesta->created_by = auth()->user()->id;
            $Encuesta->save();

            $encuesta_actual = Encuesta::where('estado', 'Activo')->orderBy('idencuesta', 'DESC')->first();
            
            $http_response["encuesta"] = $encuesta_actual->idencuesta;
            $http_response["response"] = true;
            $http_response["message"] = "Guardado";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
    }

    /**
     * Funcion para crear opciones con Ajax en la pantalla de una encuesta.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearOpcion(Request $request){
        
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {
            
            $opcion = new Opcion();
            $opcion->opcion = $request->opcion;
            $opcion->created_by = auth()->user()->id;
            $opcion->save();

            $encuesta_actual = Encuesta::where('estado', 'Activo')->find($request->id);
            $opcion_actual = Opcion::where('estado', 'Activo')->orderBy('idopcion', 'DESC')->first();

            $encuesta_opcion = new EncuestaOpcion();
            $encuesta_opcion->idencuesta = $encuesta_actual->idencuesta;
            $encuesta_opcion->idopcion = $opcion_actual->idopcion;
            $encuesta_opcion->created_by = auth()->user()->id;
            $encuesta_opcion->save();

            $http_response["encuesta"] = $request->id;
            $http_response["opcion"] = $request->opcion;
            $http_response["response"] = true;
            $http_response["message"] = "Guardado";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $encuesta = Encuesta::where('estado', 'Activo')->find($id);


        return view('encuesta.show')
        ->with('encuesta', $encuesta)
        ->with('encuesta_opciones', $encuesta->encuesta_opciones);
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
