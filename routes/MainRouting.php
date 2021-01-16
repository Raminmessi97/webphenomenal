<?php  

namespace Router;
use Router\Router;
use App\Useful_funcs\NiceOutput;

class MainRouting{
	public static function all_routes(){	

		// Добавляем все routes
			require_once("web.php");
		// Добавляем все routes
			require_once("api.php");

		//get method
		$method = Router::rest_method();

		// data
		if(preg_match("/put|post/", $method))
			$request_data = Router::rest_request_data();
		else 
			$request_data = [];

		
		// 
		Router::get_all($method,$request_data);
// 

	}

	public static function for_cmd_routes(){
		// Добавляем все routes
			require_once("web.php");
		// Добавляем все routes
			require_once("api.php");

			return Router::see_all_routes();
	}
}