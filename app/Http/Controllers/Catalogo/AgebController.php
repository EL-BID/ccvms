<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;

use Session;
use App\Catalogo\Ageb;
use App\Catalogo\Municipio;

class AgebController extends Controller
{
    /**
	 * @api {get}   /catalogo/ageb/     1. Listar AGEB's 
	 * @apiVersion  0.1.0
	 * @apiName     Ageb
	 * @apiGroup    Catalogo/Ageb
	 *
	 * @apiParam    {String}        q                   Id o número de Ageb (Opcional).
     * @apiParam    {Number}        localidades_id      Id de municipio (Opcional).
     * @apiParam    {Request}       request             Cabeceras de la petición.
     *
     * @apiSuccess  {View}          show               Vista de Ageb (Se omite si la petición es ajax).
     * @apiSuccess  {Json}          data                Lista de ageb's
	 *
	 * @apiSuccessExample Ejemplo de respuesta exitosa:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "data": [{'id','municipios_id','localidades_id','usuario_id','created_at','updated_at'}...]
	 *     } 
	 *
	 * @apiErrorExample Ejemplo de repuesta fallida:
	 *     HTTP/1.1 404 No encontrado
	 *     {
	 *       "icon"     : String icono a utilizar en la vista,
     *       "error"    : String número de error,
     *       "title"    : String titulo del mensaje,
     *       "message"  : String descripción del error
	 *     }
	 */
    public function index(Request $request)
    {
        if (Auth::user()->can('show.catalogos') && Auth::user()->activo==1) {
            $parametros = Input::only('q','localidades_id'); 
            $data = DB::table('agebs as a')
            ->select('a.*','l.nombre as localidad','m.nombre as municipio')
            ->leftJoin('localidades as l','l.id','=','a.localidades_id')
            ->leftJoin('municipios as m','m.id','=','l.municipios_id')
            ->where('a.deleted_at',NULL)
            ->orderBy('a.id', 'ASC');
            if (Auth::user()->is('root|admin')) { } else {
                $data = $data->where('m.jurisdicciones_id', Auth::user()->idJurisdiccion);
            }  
            if ($parametros['q']) {
                $data = $data->where('a.id','LIKE',"%".$parametros['q']."%");
            }
            if ($parametros['localidades_id']) {
                $data = $data->where('a.localidades_id', $parametros['localidades_id']);
            }

            $data = $data->orderBy('localidad', 'ASC')->orderBy('a.id', 'ASC')->get();  
            if ($request->ajax()) {
                return response()->json([ 'data' => $data]);
            } else {      
                return view('catalogo.ageb.index')->with('data', $data);
            }
        } else {
            return response()->view('errors.allPagesError', ['icon' => 'user-secret', 'error' => '403', 'title' => 'Forbidden / Prohibido', 'message' => 'No tiene autorización para acceder al recurso. Se ha negado el acceso.'], 403);
        }
    }
    
    /**
	 * @api {get}   /catalogo/ageb/:id  2. Consultar AGEB 
	 * @apiVersion  0.1.0
	 * @apiName     GetAgeb
	 * @apiGroup    Catalogo/Ageb
	 *
	 *
	 * @apiSuccess {View}       index       Vista de Ageb (Se omite si la petición es ajax).
     * @apiSuccess {Json}       data        Detalles de una ageb
	 *
	 * @apiSuccessExample Ejemplo de respuesta exitosa:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "data": {'id','municipios_id','localidades_id','usuario_id','created_at','updated_at'}
	 *     }
	 *
     * @apiError AgebNotFound No se encuentra
     * 
	 * @apiErrorExample Ejemplo de repuesta fallida:
	 *     HTTP/1.1 200 No encontrado
	 *     {
     *       "error": No se encuentra el recurso que esta buscando
	 *     }
	 */
    public function show($id)
    {
        $data = Ageb::with('municipio','localidad')->find($id);           
        if(!$data ){            
            return response()->json(['error' => "No se encuentra el recurso que esta buscando."]);
        }
        return response()->json([ 'data' => $data]);
    }
}
