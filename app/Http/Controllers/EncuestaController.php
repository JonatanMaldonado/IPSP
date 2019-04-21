<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Encuesta;
use App\Models\Opcion;
use App\Models\EncuestaOpcion;
use App\Models\VotoUser;

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
            
            $http_response["encuesta"] = $Encuesta->idencuesta;
            $http_response["response"] = true;
            $http_response["message"] = "Guardado";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
    }

    /**
     * Ajax para editar una encuesta en su pagina de detalle.
     *
     * @return \Illuminate\Http\Response
     */
    public function editarEncuesta(Request $request){
        
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {
            $encuesta = Encuesta::find($request->id);
            $encuesta->titulo = $request->titulo;
            $encuesta->descripcion = $request->descripcion;
            $encuesta->save();
            
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
    public function showEdit($id)
    {
        $encuesta = Encuesta::where('estado', 'Activo')->find($id);


        return view('encuesta.edit')
        ->with('encuesta', $encuesta)
        ->with('encuesta_opciones', $encuesta->encuesta_opciones);
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

        $validacion = VotoUser::where('iduser', auth()->user()->id)->where('idencuesta', $encuesta->idencuesta)->first();

        $color = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-dark'];

        return view('encuesta.show')
        ->with('encuesta', $encuesta)
        ->with('encuesta_opciones', $encuesta->encuesta_opciones)
        ->with('validacion', $validacion)
        ->with('color', $color);
    }

    /**
     * Hace la funcionalidad de votar cuando elije una opcion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function votoUser(Request $request){
        
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {
        
            $voto = VotoUser::where('idencuesta', $request->idencuesta)->where('iduser', auth()->user()->id)->where('voto', 'No')->first();
            $voto->voto = 'Si';
            $voto->idopcion = $request->idopcion;
            $voto->save();

            $opcion = Opcion::find($request->idopcion);
            $opcion->num_votos = $opcion->num_votos + 1;
            $opcion->save();

            $http_response["voto"] = $voto;
            $http_response["response"] = true;
            $http_response["message"] = "Guardado";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
    }

}
