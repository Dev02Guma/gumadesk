<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ListaArticulos extends Model {
    protected $table = "tbl_listas_articulos_rutas";
    protected $fillable = ['id','Articulo','Ruta','Lista','Activo','created_at','updated_at'];

    public static function getProyecciones(Request $request){
        $ruta     = $request->input('ruta');        
        return ListaArticulos::where('Ruta',$ruta)->get();
    }

    public static function GuardarListas(Request $request) {
        if ($request->ajax()) {
            try {
                $datos_a_insertar = array();     
                $id_insert = '';
                

                $isExit = ListaArticulos::getProyecciones($request);

                ListaArticulos::where('Activo', 'S')->delete();
                foreach ($request->input('datos') as $key => $val) {
                    $datos_a_insertar[$key]['Articulo']        = $val['Articulos'];
                    $datos_a_insertar[$key]['Ruta']             = $val['Ruta'];
                    $datos_a_insertar[$key]['Lista']            = $val['Lista'];
                    $datos_a_insertar[$key]['Activo']           = 'S';
                    $datos_a_insertar[$key]['created_at']       = date('Y-m-d H:i:s');
                    $datos_a_insertar[$key]['updated_at']       = date('Y-m-d H:i:s');
                    
                }

                $response = ListaArticulos::insert($datos_a_insertar); 
                
                return response()->json($datos_a_insertar);
                
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
    


}