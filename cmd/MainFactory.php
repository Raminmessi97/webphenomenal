<?php

namespace Cmd;

require_once("CreateBuilder.php");
require_once("RouterBuilder.php");

class MainFactory{

	private static $data;
	private static $errors;

	public static function run(){

		if(!isset(self::$errors)){
			if(self::$data['type']=="create"){
				unset(self::$data['type']);

				$director = new CreateBuilderDirector(self::$data);
				$builder = new ConcreteBuilder1();
				$director->setBuilder($builder);
				$director->run();
			}
			elseif (self::$data['type']=="routes") {
				$director = new RouterBuilderDirector(self::$data);
				$builder = new ConcreteRouterBuilder1();
				$director->setBuilder($builder);
				$director->run();
			}
		}
		else{
			foreach (self::$errors as $error) {
				echo $error."\n\r";
			}
		}
	}

	public static function before_run($data){
		self::$data = $data;
		self::defineData();
	}

	private static function defineData(){
		$data = self::$data;
		
		$part1 =explode(":", $data[0]);
		$action = $part1[0];
		$type = $part1[1];

		if(isset($data[1])&&!preg_match("~--|-~",$data[1])){
			$maindata = $data[1];
			unset($data[1]);
			$last_new_data['mainData'] = $maindata;
		}

		unset($data[0]);
	

		$last_new_data['type'] = $action;
		$last_new_data[$action] = $type;



	
		$text = implode(" ", $data);
		$new_text = "";

		for($i=0;$i<strlen($text);$i++){
			if ($text[$i]=="=") {
				$new_text.=" = ";
			}else
			$new_text.=$text[$i];
		}

		$new_data = explode(" ", $new_text);

		$new_data = array_filter($new_data);
		$new_data = array_values($new_data);//последовательная немурация
		// print_r($new_data);


		$errors = [];
		for ($i=0; $i <count($new_data) ; $i++) { 
			if(preg_match("~--|-~", $new_data[$i]) ) {
				if (isset($new_data[$i+1]) && $new_data[$i+1]=="="){
					if(!preg_match("~--|-~", $new_data[$i+2]))
						$last_new_data[$new_data[$i]] = $new_data[$i+2];
					else{
						$errors[] = "Забыли указать значение для ключа ".$new_data[$i];
						print_r($errors);
						return false;
					}
				}
				else{
					$last_new_data[$new_data[$i]] = null;
				}

			}
		}
		self::$data= $last_new_data;



	}

	private static function oneMinuse($key,$value){
		self::$data[$key] = $value;
	}

	private static function twoMinuse($key){
		self::$data[$key] = null;
	}

}