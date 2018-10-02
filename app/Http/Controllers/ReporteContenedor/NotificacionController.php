<?php
// namespace App\Http\Controllers\v1\Sistema;
namespace App\Http\Controllers\ReporteContenedor;


use App\Http\Controllers\Controller;


use App\Http\Requests;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB, Session, Auth;
use JWTAuth;


// use App\Models\Sistema\SisUsuario;
// use App\Models\Sistema\Notificaciones;
// use App\Models\Sistema\NotificacionesUsuarios;

use App\User;
use App\Models\ReporteContenedor\Notificaciones;
use App\Models\ReporteContenedor\NotificacionesUsuarios;

/**
* Controlador Notificacion
*
 * @package    CCVMS API
 * @subpackage Controlador
 * @author     Luis Alberto Valdez Lescieur <luisvl13@gmail.com>
* @created    2017-10-20
*
* Controlador `Notificacion`: Manejo de notificaciones
*
*/
class NotificacionController extends Controller {
	/**
	 * Muestra una lista de los recurso según los parametros a procesar en la petición.
	 *
	 * <h3>Lista de parametros Request:</h3>
	 * <Ul>Paginación
	 * <Li> <code>$pagina</code> numero del puntero(offset) para la sentencia limit </ li>
	 * <Li> <code>$limite</code> numero de filas a mostrar por página</ li>	 
	 * </Ul>
	 * <Ul>Busqueda
	 * <Li> <code>$valor</code> string con el valor para hacer la busqueda</ li>
	 * <Li> <code>$order</code> campo de la base de datos por la que se debe ordenar la información. Por Defaul es ASC, pero si se antepone el signo - es de manera DESC</ li>	 
	 * </Ul>
	 *
	 * Ejemplo ordenamiento con respecto a id:
	 * <code>
	 * http://url?pagina=1&limite=5&order=id ASC 
	 * </code>
	 * <code>
	 * http://url?pagina=1&limite=5&order=-id DESC
	 * </code>
	 *
	 * Todo Los parametros son opcionales, pero si existe pagina debe de existir tambien limite
	 * @return Response 
	 * <code style="color:green"> Respuesta Ok json(array("status": 200, "messages": "Operación realizada con exito", "data": array(resultado)),status) </code>
	 * <code> Respuesta Error json(array("status": 404, "messages": "No hay resultados"),status) </code>
	 */
	public function index(){
		$datos = Request::all();
		//$usuario = User::where("email", $obj->get('email'))->first();
		// Si existe el paarametro pagina en la url devolver las filas según sea el caso
		// si no existe parametros en la url devolver todos las filas de la tabla correspondiente
		// esta opción es para devolver todos los datos cuando la tabla es de tipo catálogo
		if(array_key_exists("pagina", $datos)){
			$pagina = $datos["pagina"];
			if(isset($datos["order"])){
				$order = $datos["order"];
				if(strpos(" ".$order,"-"))
					$orden = "desc";
				else
					$orden = "asc";
				$order=str_replace("-", "", $order); 
			}else{
				$order = "id"; $orden = "asc";
			}
			
			if($pagina == 0){
				$pagina = 1;
			}
			if($pagina == 1)
				$datos["limite"] = $datos["limite"] - 1;

			// si existe buscar se realiza esta linea para devolver las filas que en el campo que coincidan con el valor que el usuario escribio
			// si no existe buscar devolver las filas con el limite y la pagina correspondiente a la paginación
			if(array_key_exists("buscar", $datos)){
				$columna = $datos["columna"];
				$valor   = $datos["valor"];
				$data = NotificacionesUsuarios::with("Notificaciones")->where("usuarios_id",Auth::user()->id)->where("leido", NULL)->orderBy($order, $orden)->orderBy('created_at', 'DESC');
				
				$search = trim($valor);
				$keyword = $search;
				$data = $data->whereNested(function($query) use ($keyword){	
						$query->Where("mensaje", "LIKE", "%".$keyword."%")
							->orWhere("tipo", "LIKE", '%'.$keyword.'%'); 
				});				
				$total = $data->get();
				$data = $data->skip($pagina-1)->take($datos["limite"])->get();
			}
			else{
				$data = NotificacionesUsuarios::with("Notificaciones")->where("usuarios_id",Auth::user()->id)->where("leido", NULL)
				->skip($pagina-1)->take($datos["limite"])->orderBy($order, $orden)->orderBy('created_at', 'DESC');
				$data = $data->get();
				$total = $data->get();
				
			}
			
		}else{
			$data = NotificacionesUsuarios::with("Notificaciones")->where("usuarios_id",Auth::user()->id)->where("leido", NULL)->orderBy('created_at', 'DESC')->take(3);
			$data = $data->get();
			$total = $data;
		}

		if(count($data)<=0){
			return Response::json(array("status" => 200, "messages" => "No hay resultados"),200);
		}else {
			$total_n = NotificacionesUsuarios::with("Notificaciones")->where("usuarios_id",Auth::user()->id)->where("leido", NULL)->get();

			$notificaciones = [];
            foreach ($data as $key => $value) {

                $mensaje = json_decode($value->notificaciones->mensaje);
                $mensaje->id = $value->id;
                //$mensaje->mensaje->leido = $value->leido;
                if(property_exists($value, "tipo"))
                    $mensaje->mensaje->tipo = $value->tipo;
                array_push($notificaciones, array("mensaje" => $mensaje));
			}
			return Response::json(array("status" => 200, "messages" => "Operación realizada con exito", "data" => $notificaciones, "total" => count($total), "total_n" => count($total_n)),  200);			
		}
	}


	
	/**
	 * Actualizar el  registro especificado en el la base de datos
	 *
	 * <h4>Request</h4>
	 * Recibe un Input Request con el json de los datos
	 *
	 * @param  int  $id que corresponde al identificador del dato a actualizar 	 
	 * @return Response
	 * <code style="color:green"> Respuesta Ok json(array("status": 200, "messages": "Operación realizada con exito", "data": array(resultado)),status) </code>
	 * <code> Respuesta Error json(array("status": 304, "messages": "No modificado"),status) </code>
	 */
	public function update($id){
		$datos = (object) Input::json()->all();		
		$success = false;
        
        DB::beginTransaction();
        try{
        	$obj =  JWTAuth::parseToken()->getPayload();
			$usuario = User::where("email", $obj->get('email'))->first();

            $data = NotificacionesUsuarios::find($id);

            if(!$data){
                return Response::json(['error' => "No se encuentra el recurso que esta buscando."], HttpResponse::HTTP_NOT_FOUND);
            }else{
            	$notificacion = NotificacionesUsuarios::where("id", $data->id)->where("usuarios_id", $usuario->id)->first();

            	if(property_exists($datos, "leido"))
        			$notificacion->leido = date("Y-m-d h:i:s");

        		if(property_exists($datos, "enviado"))
        			$notificacion->enviado = date("Y-m-d h:i:s");

        		if($notificacion->save())
        			$success = true;
            }                     

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(["status" => 500, 'error' => $e->getMessage()], 500);
        } 
        if($success){
			DB::commit();
			return Response::json(array("status" => 200, "messages" => "Operación realizada con exito", "data" => $data), 200);
		}else {
			DB::rollback();
			return Response::json(array("status" => 304, "messages" => "No modificado"),200);
		}
	}
}