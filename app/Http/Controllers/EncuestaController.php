<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Encuesta;
use App\Models\Opcion;
use App\Models\EncuestaOpcion;
use App\Models\VotoUser;
use App\User;

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
        $encuestas = Encuesta::where('estado', 'Activo')->orderBy('created_at', 'DESC')->paginate(5);

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

            $encuesta = new Encuesta();
            $encuesta->titulo = $request->titulo;
            $encuesta->descripcion = $request->descripcion;
            $encuesta->created_by = auth()->user()->id;
            $encuesta->updated_by = auth()->user()->id;
            $encuesta->save();

            $usuarios = User::where('estado', 'Activo')->get();

            foreach ($usuarios as $value) {
                $voto_user = new VotoUser();
                $voto_user->iduser = $value->id;
                $voto_user->idencuesta = $encuesta->idencuesta;
                $voto_user->idopcion = 1;
                $voto_user->voto = 'No';
                $voto_user->save();
            }
            
            $http_response["encuesta"] = $encuesta->idencuesta;
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
            $encuesta->updated_by = auth()->user()->id;
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
            $opcion->updated_by = auth()->user()->id;
            $opcion->save();

            $encuesta_actual = Encuesta::where('estado', 'Activo')->find($request->id);

            $encuesta_opcion = new EncuestaOpcion();
            $encuesta_opcion->idencuesta = $encuesta_actual->idencuesta;
            $encuesta_opcion->idopcion = $opcion->idopcion;
            $encuesta_opcion->created_by = auth()->user()->id;
            $encuesta_opcion->updated_by = auth()->user()->id;
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

        $total = 0;

        foreach ($encuesta->encuesta_opciones as $key => $value) {
            $total = $total + $value->opcion->num_votos;
        }

        if($total == 0) {
            $total = 1;
        }

        return view('encuesta.show')
        ->with('encuesta', $encuesta)
        ->with('encuesta_opciones', $encuesta->encuesta_opciones)
        ->with('validacion', $validacion)
        ->with('color', $color)
        ->with('total', $total);
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

    /**
     * Funcion para editar opciones.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editarOpcion(Request $request){
        
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {

            $opcion = Opcion::find($request->id);
            $opcion->opcion = $request->opcion;
            $opcion->updated_by = auth()->user()->id;
            $opcion->save();
        
            $http_response["response"] = true;
            $http_response["message"] = "La opción se modifico exitosamente.";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
    }

    /**
     * Funcion para eliminar opciones.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminarOpcion(Request $request){
        
        $http_response = array("response" => false, "message" => "Error");
        
        if ($request->ajax()) {

            $encuesta_opcion = EncuestaOpcion::where('idopcion', $request->id)->first();
            $encuesta_opcion->estado = 'Inactivo';
            $encuesta_opcion->updated_by = auth()->user()->id;
            $encuesta_opcion->save();
        
            $http_response["response"] = true;
            $http_response["message"] = "La opción se elimino exitosamente.";
        
        }else{
            $http_response["message"] = "Acceso no autorizado";
        }
        
        return response()->json($http_response);
    }

}
