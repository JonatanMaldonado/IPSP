<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = \App\Producto::paginate();
        return view('home', compact('productos'));
    }

    public function destroyProduct(Request $request, $id){
        if($request->ajax()){
            $producto = \App\Producto::find($id);
            $producto->delete();
            $producto_total = \App\Producto::all()->count();

            return response()->json([
                'total' => $producto_total,
                'message' => $producto->nombre . 'fue eliminado correctamente',
            ]);
        }
    }
}
