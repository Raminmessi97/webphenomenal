<?php

namespace Cmd;

interface ResourceBuilder{
	public function createController(string $filename);
	public function createModel(string $filename);
	public function createTemplate(string $filename);
	public function createResource();
}

class ConcreteBuilder1 implements ResourceBuilder{


	public $data_for_resource;

	public function createController($filename){
		if(file_exists("app/Http/Controllers/$filename.php")){
			echo "\033[31mКонтроллер $filename уже существует\033[33m\n\r";
		}
		else{
			if(preg_match("~\/~", $filename)){
				$fullpath = explode("/", $filename);
				
				$name_of_file = $fullpath[count($fullpath)-1];
				unset($fullpath[count($fullpath)-1]);
				$path = implode("/", $fullpath);
				trim($path,"/");

				if(!is_dir("app/Http/Controllers/$path")){
					mkdir("app/Controller/$path",0777,true);
				}

				$namespace = "App\Http\Controllers\\".$path;
			}
			else{
				$namespace = "App\Http\Controllers";
				$name_of_file = $filename;
			}
			$fh = fopen("app/Http/Controllers/$filename.php", "w") 
			or die("\033[31mСоздать файл не удалось\033[33m\n\r");



			

			$text = <<<_END
			<?php
			namespace $namespace;	\n\r
			class $name_of_file  {
				//body of controller
			}
			_END;

			if(fwrite($fh, $text)){
				echo "\033[32mДанные удачно записаны в контроллер $filename\033[33m\n\r";
			}
			else{
				echo "\033[31m Не удалось записать данные в контроллер $filename\033[33m\n\r";
			}
			fclose($fh);

		}

	}
	public function createModel($filename){

		if(file_exists("app/Models/$filename.php")){
			echo "\033[31m Модель $filename уже существует\033[33m\n\r";
		}else{
			$fh = fopen("app/Models/$filename.php", "w") 
			or die("\033[31mСоздать файл не удалось\033[33m\n\r");

			$text = <<<_END
			<?php
			namespace App\Models;	\n\r
			class $filename extends ActiveRecord {
				//body of model\n\r
				protected static function getTableName(){
					return "{$filename}";
				}
			}
			_END;

			if(fwrite($fh, $text)){
				echo "\033[32mДанные удачно записаны в модель $filename\033[33m\n\r";
			}
			else{
				echo "\033[31m Не удалось записать данные в модель $filename\033[33m\n\r";
			}
			fclose($fh);
		}

	}

	public function createTemplate($filename){
		if(file_exists("resources/views/$filename.php")){
			echo "\033[31m Темплейт $filename уже существует\033[33m\n\r";
		}
		else{
			if(preg_match("~\/~", $filename)){
				$fullpath = explode("/", $filename);
				
				$name_of_file = $fullpath[count($fullpath)-1];
				unset($fullpath[count($fullpath)-1]);
				$path = implode("/", $fullpath);
				trim($path,"/");

				if(!is_dir("resources/views/$path")){
					mkdir("resources/views/$path",0777,true);
				}

			}
			else{
				$name_of_file = $filename;
			}
			$fh = fopen("resources/views/$filename.php", "w") 
			or die("\033[31mСоздать файл не удалось\033[33m\n\r");

			
			$text = <<<_END
			<?php require_once("resources/views/layouts/header.php")?>
			\t<main class="content">
			\t<article>
			\t</article>    
			\t\t<?php require_once("resources/views/layouts/aside.php")?>
			\t</main>
			<?php require_once("resources/views/layouts/footer.php")?>
			_END;

			if(fwrite($fh, $text)){
				echo "\033[32mДанные удачно записаны в Темплейт $filename\033[33m\n\r";
			}
			else{
				echo "\033[31m Не удалось записать данные в Темплейт $filename\033[33m\n\r";
			}
			fclose($fh);

	}
}


	public function createResource(){
		$filename = $this->data_for_resource;

		$lines = file('app/Http/Controllers/'.$filename.".php");
		for($i=count($lines)-1;$i>=0;$i--){
			if(preg_match("/\}/", $lines[$i]))
				unset($lines[$i]);
			break;
		}

		$text = implode("", $lines);
			


$text.="\n\r\n\r";
$text.='
	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index(){
	}		
	/**
	 * Show the form for 
	 * @param int $id
	 */
	public function show($id){

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 */
	public function create(){

	}

	/**
	 * Store a newly created resource in storage.
	 *@param Request $request;
	 */
	public function store(Request $request){

	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id){
		
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @param  int  $id
	 */
	public function update(Request $request,$id){
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 */
	public function delete($id)
	{
		
	}

}';
		$fh = fopen("app/Http/Controllers/$filename.php", "w") or die("Открыть файл не удалось");
// 	
		if(fwrite($fh, $text)){
				echo "\033[32mДанные удачно записаны в контроллер $filename\033[33m\n\r";
		}
		else{
			echo "\033[31m Не удалось записать данные в контроллер $filename\033[33m\n\r";
		}
		
		fclose($fh);
	}

}



//director
class CreateBuilderDirector{

	private $builder;
	private $data;

	private static $keys = [
		'controller'=>['-m','--r','-t'],
		'model'=>['-c','-t'],
		'template'=>[]
	];

	private static $actions = [
	'-m'=>'createModel',
	'--r'=>'createResource',
	'-t'=>'createTemplate',
	'-c'=>'createController',
	];

	public function __construct($data){
		$this->data = $data;
	}

	public function setBuilder(ResourceBuilder $builder){
		$this->builder = $builder;
	}


	public function run(){
		$mainAction = "create".ucfirst($this->data['create']);
		$create = $this->data['create'];
		unset($this->data['create']);

		$maindata= $this->data['mainData'];
		$this->builder->$mainAction($maindata);
		unset($this->data['mainData']);

		// 
		$this->builder->data_for_resource = $maindata;

		foreach ($this->data as $key => $value) {
			if(in_array($key, static::$keys[$create])){
				$method = self::$actions[$key];
				$this->builder->$method($value);
			}
			else{
				echo "\033[31mКлюч ".$key." не определен\033[33m\n\r";
			}
		}

	}
}
