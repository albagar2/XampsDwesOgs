<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrutasController extends Controller
{
    //metodo index que devuelve una vista

    public function index(){
        $frutas=['manzana', 'pera', 'naranja', 'kiwi', 'sandia'];
        return view('frutas.index', compact('frutas'));
    }

    public function naranjas(){
        return "Esta es la pagina de naranjas";
    }

    public function peras(){
        return "Esta es la pagina de peras";
    }

    public function recibeFrutas(Request $request){
        if($request->fruta =='pera'){
            return redirect()->route('frutas.index')->with('mensaje', 'Ha elegido pera');
        }else
            return back()->withInput()->with('mensaje', 'No puedes elegir pera');


        return $request->all();
        dd($request);
    }
}
