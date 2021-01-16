<?php
namespace Router;

use App\Useful_funcs\Redirect;
use App\Http\Kernel;
use App\Models\User;
use App\Http\Request;
use App\Useful_funcs\NiceOutput;


class Router{

	/**
     * Текущий роут объекта
     * @var array
     */
	private $route;

	/**
     * Контроллер и action объекта
     * @var array
     */
	private $ContAct;

	/**
     * Текущий метод
     * @var array
     */
	private $method;

	/**
     * Массив с middlewares
     * @var array
     */
	private $middlewares=null;


	/**
     * Переменная, которая хранит все роуты
     * @var array
     */
	private static $routes;



	private static function union_all_methods($method,$route,$controller_and_action){
		self::$routes[$method][$route]['route'] = $route;
		self::$routes[$method][$route]['ContAct'] = $controller_and_action;
		self::$routes[$method][$route]['http_method'] = $method;
		self::set_controller_middlewares($route,$controller_and_action,$method);
	}





	/**
     * Get method of Router
     *
     * @param string $current_route
     * @param  string $controller_and_action
     * @return function before_check
     */
	public static function get($route,$controller_and_action){
		self::union_all_methods("get",$route,$controller_and_action);
		return self::before_check($route,$controller_and_action,"get");
	}

		/**
     * Post method of Router
     *
     * @param string $current_route
     * @param  string $controller_and_action
     * @return function before_check
     */
	public static function post($route,$controller_and_action){
		self::union_all_methods("post",$route,$controller_and_action);
		return self::before_check($route,$controller_and_action,"post");
	}

		/**
     * Put method of Router
     *
     * @param string $current_route
     * @param  string $controller_and_action
     * @return function before_check
     */
	public static function put($route,$controller_and_action){
		self::union_all_methods("put",$route,$controller_and_action);
		return self::before_check($route,$controller_and_action,"put");
	}

		/**
     * Delete method of Router
     *
     * @param string $current_route
     * @param  string $controller_and_action
     * @return function before_check
     */
	public static function delete($route,$controller_and_action){
		self::union_all_methods("delete",$route,$controller_and_action);
		return self::before_check($route,$controller_and_action,"delete");
	}

	/**
	 *Возвращает объект класса со свойствами
     *
     * @param  string  $route
     * @param  string $controller_and_action
     * @return object
     */

	private static function before_check($route,$controller_and_action,$method){

		//Создаем объект для middleware
		$router = new Router();
		$router->route = $route;
		$router->ContAct =$controller_and_action;
		$router->method = $method;

		return $router;
	}



	/**
     * Middleware method
     *
     * @param array $middlewares
     * Устанавливаем middleware для текущего роута
     */
	public function middleware($middlewares){
		$route = $this->route;
		$method = $this->method;

		self::$routes[$method][$route]['middlewares'] = $middlewares;

	}



	/**
     * Main method of Router
     *
     * @param null
     */

	public static function get_all($method,$request_data){
		$url_route = URL_ROUTE;
		$url_route = trim($url_route,"/"); //Удаляем слеш из начала и конца

		$hasRoute = false; // Нет такого маршрута

		//for cmd 
		$GLOBALS['routes'] = self::$routes;
		// 

	 	foreach (self::$routes as $routeName => $routeProps) {
	 		if($routeName===$method){
	 			foreach ($routeProps as $route => $value) {
 					if(preg_match("~^$route$~u", $url_route,$matches)){
						$hasRoute = true; //Нашли совпадение
						if(isset($value['middlewares']))
						{
							self::use_middlewares($value,$matches,$request_data);
						}
						else{
							self::check($value['ContAct'],$matches,$request_data);
						}
					}
	 			}
	 		}
	 	}
			if(!$hasRoute){
					echo "404 not found";
			}
	}


	/**
     * Check method of Router( Вызываем нужный контроллер с нужным методом)
     *
     * @param null
     */
	private static function check($controller_and_action,$matches,$request_data){


		// self::rest_test();
		// return false;
		array_shift($matches);

		$array = explode("@", $controller_and_action);

		$controller = $array[0];
		$action = $array[1];

		$controller = "\App\Http\Controllers\\".$controller;
		$object = new $controller;
		
		if(empty($request_data)){
			$object->$action(...$matches);
		}
		else{
			$object->$action($request_data,...$matches);
		}
		
	}


	/**
     * Возвращает rest метод
     *
     * @param null
     * @return rest_method
     */
	public static function rest_method(){
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		if( $method === 'post' && isset($_REQUEST['REQUEST_METHOD'])) {
		    $tmp = strtolower((string)$_REQUEST['REQUEST_METHOD']);
		    if( in_array( $tmp, array( 'put', 'delete'))) {
		        $method = $tmp;
		    }
		    unset($tmp);
		}
		return $method;
	}

	/**
     * Возвращает rest data
     *
     * @param null
     * @return rest_data
     */

	public static function rest_request_data(){

		if(file_get_contents('php://input')){
			$response['request_data'] = file_get_contents('php://input');
			if($_FILES){
				$response['fileData'] = $_FILES;	
			}
			$result = Request::getData($response);
			return $result;
		}

		if($_POST){
			$response['request_data'] = $_POST;
			if($_FILES){
				$response['fileData'] = $_FILES;	
			}
			$result = Request::getRequestData($response);
			return $result;
		}

	}


	/**
     * Use middlewares( Применение посредников)
     *
     * @param null
     */
	private static function use_middlewares($value,$matches,$request_data){
		$middlewares = $value['middlewares'];

		
		$author_list = [];	// Будет хранить все юзеры
		
		if(isset($_COOKIE['logged_user'])){
			$object = json_decode($_COOKIE['logged_user']);
			$author_email= $object->email;
			$author_role = $object->role;
			$author = ['author_email'=>$author_email,'author_role'=>$author_role];
		}
		else{
			$author =[]; // Будет хранить авторизованного юзера
		}

		$obj = User::getInstance();
		$authors =  $obj->findAll()->get();

		foreach ($authors as $key => $author_obj) {
			$author_list[$key]['author_email'] = $author_obj->email;
			$author_list[$key]['author_role'] = $author_obj->role;
		}

		$all_middlewares = Kernel::get_all_middlewares();

		$uses_middlewares = [];

		for($i=0;$i<count($middlewares);$i++){
			foreach ($all_middlewares as $key => $value2) {
				if($key===$middlewares[$i]){
					$uses_middlewares[$i] = $value2;
				}
			}
		}
		
		if(isset($_COOKIE['logged_user'])){
				if(count($middlewares)===1){	

						$run_middlewares = new $uses_middlewares[0];
						
						if($run_middlewares->check($author,$author_list)){
							self::check($value['ContAct'],$matches,$request_data);
						}
						else
							{
								$url = "";
								Redirect::redirect($url,"access_error","Запрещенная область");
							}
						
				}
				else{
					
					$run_middlewares = [];

					for($i=0;$i<count($uses_middlewares);$i++){
						$object = new $uses_middlewares[$i];
						$run_middlewares[] = $object;
					}

					for($i=0;$i<count($run_middlewares);$i++){
						if(isset($run_middlewares[$i+1]))
							$run_middlewares[$i]->linkWith($run_middlewares[$i+1]);
					}

					$first_handler = $run_middlewares[0];


					if($first_handler->check($author,$author_list)){
						self::check($value['ContAct'],$matches,$request_data);
					}
					else{
						$url = "";
						Redirect::redirect($url,"access_error","Запрещенная область");
					}
				}
			}
			else{
				$url = "";
				Redirect::redirect($url,"access_error","Запрещенная область");
			}
	}


	public static function resource($url,$contr){

		$controller = "\App\Http\Controllers\\".$contr;
		$object = new $controller;
		if(isset($object->middlewares)){
			$used_methods = $object->methods;
			$used_middlewares = $object->middlewares['names'];
		}



		$urls = [
		'get'=>[ 
		   $url=>["route"=>$url,"ContAct"=>$contr."@index","method"=>"index","http_method"=>"get"],
		   $url."/show/([0-9]+)"=>["route"=>$url."/show/([0-9]+)","ContAct"=>$contr."@show","method"=>"show","http_method"=>"get"],
		   $url."/create"=>["route"=>$url."/create","ContAct"=>$contr."@create","method"=>"create","http_method"=>"get"],
		   $url."/([0-9]+)"=>["route"=>$url."/([0-9]+)","ContAct"=>$contr."@edit","method"=>"edit","http_method"=>"get"]
		 ],
		 'post'=>[
		 	$url."/store"=>["route"=>$url."/store","ContAct"=>$contr."@store","method"=>"store","http_method"=>"post"]
		 ],
		 'put'=>[
		 	$url."/([0-9]+)"=>["route"=>$url."/([0-9]+)","ContAct"=>$contr."@update","method"=>"update","http_method"=>"put"]
		 ],
		 'delete'=>[
		 	$url."/([0-9]+)"=>["route"=>$url."/([0-9]+)","ContAct"=>$contr."@delete","method"=>"delete","http_method"=>"delete"]
		 ],
		];


		foreach ($urls as $method => $value) {
			foreach ($value as $route => $values) {
			 self::$routes[$method][$route]['route'] = $values['route'];
			 self::$routes[$method][$route]['ContAct'] = $values['ContAct'];
			 self::$routes[$method][$route]['http_method'] = $values['http_method'];
			 if(in_array($values['method'], $used_methods)){
			 	 self::$routes[$method][$route]['middlewares'] = $used_middlewares;
			 }else{
			 	self::$routes[$method][$route]['middlewares'] = null;
			 }
			
			 self::before_check($route,$values['ContAct'],$method);
			}
		}
	}

	public static function set_controller_middlewares($url,$controller_and_action,$method){
		$array = explode("@", $controller_and_action);

		$controller = $array[0];
		$action = $array[1];

		$controller = "\App\Http\Controllers\\".$controller;
		$object = new $controller;



		if(isset($object->middlewares)){
			$all_methods = $object->methods;
			$used_middlewares = $object->middlewares['names'];

			if(in_array($action, $all_methods)){
				if($object->middlewares){
					self::$routes[$method][$url]['middlewares'] = $used_middlewares;
				}
			}
		}


	}

	public static function see_all_routes(){
		return self::$routes;
	}

	public static function test(){
		return "ramin";
	}

}