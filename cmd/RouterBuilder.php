<?php

namespace Cmd;
use Router\Router;
use Router\MainRouting;

interface RouterBuilder{
	public function list();
	public function getByUri($uri);
	public function getByHttpMethod($http_method);
}

class ConcreteRouterBuilder1 implements RouterBuilder{

	private static $all_routes = [];
	// 	['route'=>"/","action"=>"ArticleController@index","http_method"=>"get","middlewares"=>null],
	// 	['route'=>"articles","action"=>"ArticleController@show","http_method"=>"get","middlewares"=>["auth"]],
	// 	['route'=>"articles/store","action"=>"ArticleController@store","http_method"=>"post","middlewares"=>["auth","admin"]],
	// 	['route'=>"articles/delete","action"=>"ArticleController@delete","http_method"=>"delete","middlewares"=>null],
	// ];

	public function list(){
		self::get_route_data();
		self::draw_table();
		// print_r(self::$all_routes);
	}



	public function getByUri($uri){
		echo $uri;

	}

	public function getByHttpMethod($http_method){
		echo $http_method;
	}

	private static function get_route_data(){
		$data= MainRouting::for_cmd_routes();
		$new_data = [];

		foreach ($data as $key => $value) {
			foreach ($value as $key => $new_value) {
				self::$all_routes[] = $new_value;
			}
		}

		// self::$all_routes = Router::see_all_routes();
	}

	private static function draw_table(){
		
		//define cmd width
		exec('mode con', $output);
		$cmd_width = explode(":", $output[4]);
		$cmd_width = intval(trim($cmd_width[1]));
		// 

		$data = self::$all_routes;
		$items = ['URI','Action','http_method','Middleware'];

		$one_item_width = 0.3*$cmd_width;
		$two_item_width = 0.3*$cmd_width;
		$three_item_width = 0.1*$cmd_width;
		$four_item_width = 0.1*$cmd_width;

		// Заголовки
		$string = "";
		$string.="   +".str_repeat("-", $one_item_width)."+".str_repeat("-", $two_item_width)."+".str_repeat("-",$three_item_width)."+".str_repeat("-", $four_item_width)."+\n\r";
		$string.="   | ".$items[0]."".str_repeat(" ", $one_item_width-strlen($items[0])-1)."| ".$items[1];
		$string.=str_repeat(" ", $two_item_width-strlen($items[1])-1)."| ".$items[2];
		$string.=str_repeat(" ", $three_item_width-strlen($items[2])-1)."| ".$items[3];
		$string .= str_repeat(" ", $four_item_width-strlen($items[3])-1)."|\n\r";
		$string.="   +".str_repeat("-", $one_item_width)."+".str_repeat("-", $two_item_width)."+".str_repeat("-",$three_item_width)."+".str_repeat("-", $four_item_width)."+\n\r";
		// 
	
		// print_r($data);
		// echo $string;
		foreach ($data as $key => $value) {

			if(isset($value['middlewares'])&&is_array($value['middlewares'])){
				$middlewares = $value['middlewares'];
				$middlewares = implode(",",$middlewares);
			}
			else{
				$middlewares = null;
			}


			$string.="   | ".$value['route']."".str_repeat(" ", $one_item_width-iconv_strlen($value['route'])-1)."| ".$value['ContAct'];
			$string.=str_repeat(" ", $two_item_width-iconv_strlen($value['ContAct'])-1)."| ".$value['http_method'];
			$string.=str_repeat(" ", $three_item_width-iconv_strlen($value['http_method'])-1)."| ".$middlewares;
			$string .= str_repeat(" ", $four_item_width-iconv_strlen($middlewares)-1)."|\n\r";
		}
		$string.="   +".str_repeat("-", $one_item_width)."+".str_repeat("-", $two_item_width)."+".str_repeat("-",$three_item_width)."+".str_repeat("-", $four_item_width)."+\n\r";
		echo $string;

	}
}



//director
class RouterBuilderDirector{

	private $builder;
	private $data;

	private static $keys = [
		"--method","--uri"
	];

	private static $actions = [
		"list"=>"list",
		"--uri"=>"getByUri",
		"--method"=>"getByHttpMethod"
	];

	public function __construct($data){
		$this->data= $data;
	}

	public function setBuilder(RouterBuilder $builder){
		$this->builder = $builder;
	}

	public function run(){
		$data = $this->data;

		$default_action = "list";
		$default_value = "";
		unset($data['type']);
		unset($data['routes']);

		$is_action_exists = false;

		if(!is_null($data)){
			foreach ($data as $key => $value) {
				if(in_array($key, self::$keys)){
					$default_action = $key;
					$default_value = $value;
				}	
				else{
					echo "\033[31mКлюч ".$key." не определен\033[33m\n\r";
					return false;
				}
			}
		}


		foreach (self::$actions as $key => $value) {
			if($key==$default_action){
				$action = $value;
				$is_action_exists = true;
				break;
			}
		}

		if($is_action_exists){
			$this->builder->$action($default_value);
			return true;
		}
		else{
			echo "\033[31mКлюч ".$key." не определен\033[33m\n\r";
			return false;
		}

	}



}
