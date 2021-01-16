<?php

namespace App\Models;
use Database\Database;
// use Database\Redis;
use App\Useful_funcs\Pagination;

abstract class ActiveRecord {
	/**
     * 
     * Чтобы  создавать объект один раз (Singleton Pattern)
     */
	private static $instance=null;

	/**
     * 
     * Переменная, которая хранит sql запрос
     */
	private $sql;

	/**
     * 
     * Переменная, которая хранит параметры
     */
	private $params=[];

	/**
     * 
     * Переменная, которая хранит подключение к базе данных
     */
	private $databaseConnect;

	/**
     * 
     * Переменная, которая хранит подключение redis
     */
	private static $redisConnect;

	/**
     * 
     * Переменная, используемые для параметров sql запросов
     */
	private $for_pdo_params = 1;

	// Не позволяем клонировать
	private function __clone () {} 
	private function __wakeup () {}


	/**
     * Create singleton instance 
     */


	public static function getInstance(){
		// if(self::$instance==null){
			return self::$instance = new static();
		// }
		// return self::$instance;
	}



	private function __construct(){
		$this->databaseConnect = Database::getInstance();
// 		self::$redisConnect = Redis::getInstance();
	}



	/**
     * Метод для получения всех данных (например всех статей)
     */

	public function findAll(){
		$sql = "SELECT * FROM ".static::getTableName();

		$this->params = [];
		$this->sql = $sql;

		return $this;
	}

	/**
     * Статический Метод для получения всех данных (например всех статей)
     */


	public static function getAll(){
// 		self::$redisConnect = Redis::getInstance();

// 		if(self::$redisConnect->hget('get_all',static::getTableName())){
// 			// echo 'iz redis';
// 			return json_decode(self::$redisConnect->hget('get_all',static::getTableName()));

// 		}
// 		else{
			// echo 'iz bazi';
			$connect =  Database::getInstance();
			$sql = "SELECT * FROM ".static::getTableName();
			$params = [];

			$result = $connect->query($sql,$params,static::class);
// 			self::$redisConnect->hset('get_all',static::getTableName(),json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
// 			self::$redisConnect->expire('get_all',7200);

			return $result;
// 		}
	}

	/**
     * Метод для получение одной записи
     */
	public function findById($id){
		$sql = "SELECT * FROM ".static::getTableName()." WHERE id=:id";
		$params = ["id"=>$id];

		$this->params = $params;
		$this->sql = $sql;

		return $this;
	}

	/**
     * Статический Метод для получение одной записи
     *@param int $id
     */

	public static function find($id){

// 		self::$redisConnect = Redis::getInstance();

			$connect =  Database::getInstance();

			$sql = "SELECT * FROM ".static::getTableName()." WHERE id=:id";
			$params = ["id"=>$id];

			$result = $connect->queryOne($sql,$params,static::class);
			return $result;


	}



	/**
     * Задаем дополнительные условия
     */
	public function where($propertyName,$operator,$propertyValue){
		// $pdo_name = ":".$propertyName."".$this->for_pdo_params++;
		$this->params[] = $propertyValue;
		$this->sql .= " WHERE ".$propertyName." $operator "." ?";
		return $this;
	}

	/**
     * Задаем дополнительные условия
     */
	public function AndWhere($propertyName,$operator,$propertyValue){
		$pdo_name = ":".$propertyName.$this->for_pdo_params++;
		$this->params[$pdo_name] = $propertyValue;
		$this->sql .= " AND  ".$propertyName.$operator.$pdo_name;
		return $this;
	}

	/**
     * Метод для получения всех данных (например всех статей)
     */
	private function reflection(){
		$reflector  = new \ReflectionObject($this);
		$properties = $reflector->getProperties();
		$mapProperties = [];

		foreach ($properties as $property) {
			$propertyName = $property->getName();
			$mapProperties[$propertyName] = $this->$propertyName;
		}

		return $mapProperties;

	}

	/**
     * Метод создания записи в БД
     */

	public function create(){

		$mapProperties = array_filter($this->reflection()); // delete null values
		$columns = [];
		$values = [];

		foreach($mapProperties as $columnName => $columnValue){
				$columns[] = $columnName;
				$values[] = ":".$columnName;
			}

		
		$columns = implode(",",$columns);
		$values = implode(",",$values);

		$sql = "INSERT INTO ".static::getTableName()."(".$columns.") VALUES(".$values.")";
		$result = $this->databaseConnect->crud($sql,$mapProperties,static::class);

		return $result;
	}

	/**
     * Метод создания записи в БД
     *@param array $data
     */
	public function update($data){

		$id = $this->id;
		$res = "";

		foreach ($data as $column => $value) {
			$res.=$column."=:".$column.",";
		}
		$res = trim($res,',');
		$params = $data;
			

		$sql = "UPDATE ".static::getTableName()." SET ".$res." WHERE id=:id";
		$data['id'] = $id;

		$result = $this->databaseConnect->crud($sql,$data,static::class);
		return $result;
	}



	/**
     * Метод удалание записи из БД
     *@param int $id
     */
	public function delete(){

		$id =  $this->id;
		$sql = "DELETE FROM ".static::getTableName()." WHERE id=:id";

		$array = [":id"=>$id];
		$result = $this->databaseConnect->crud($sql,$array,static::class);
		return $result;
	}


	 /**
     * Получаем данные в зависимости от страницы $current_page
     *
     * @param int $limit (Количество данных на одной странице)
     * @return $this
     */

	public static function paginate($limit,$current_page){

		$url_main = "";

		$count = static::getCount();

		$pagination = new Pagination($count,$limit,$current_page,$url_main);
		$html=$pagination->get_pag();

		$offset = ($current_page-1)*$limit;
		$sql = "SELECT * FROM ".static::getTableName()." LIMIT ".$limit." OFFSET ".$offset;
		$params = [];


		// 
// 		self::$redisConnect = Redis::getInstance();

// 		if(self::$redisConnect->hget('main_pag','page-'.$current_page)){
// 			// echo "iz redis";
// 			$result = json_decode(self::$redisConnect->hget('main_pag','page-'.$current_page));

// 		}
// 		else{
			// echo "iz database";
			$connect =  Database::getInstance();
			$result = $connect->query($sql,$params,static::class);
// 			self::$redisConnect->hset('main_pag','page-'.$current_page,json_encode($result));

// 			self::$redisConnect->expire('main_pag',10800);	//время жизни 3 часа,чтобы данные  оставались актуальными
// 		}
		// 


		
		

		
		if($result){
			$object = new \StdClass();
			foreach ($result as $key => $value)
			{
			    $object->data[] = $value;
			}
			$object->links = $html; // в links мы храним ссылки на страницы
			return $object;
		}
		else{
			return false;
		}
	}

	public static function test(){
		return Redis::getInstance();
	}


	
	 /**
     * Получаем данные в зависимости от страницы $current_page
     *
     * @param int $limit (Количество данных на одной странице)
     * @return $this
     */
	public  function paginateT($limit,$current_page){

		$url_main = URL_MAIN.URL_ROUTE;

		if(preg_match("~page-([0-9]+)~", $url_main)){
			$url_main = preg_replace("~page-([0-9]+)~", "",$url_main);
		}
		$url_main = trim($url_main,"/");
		$url_main.="/";
		
		$connect =  Database::getInstance();
		$count = $connect->crud($this->sql,$this->params,static::class);


		$pagination = new Pagination($count,$limit,$current_page,$url_main);
		$html=$pagination->get_pag();

		$offset = ($current_page-1)*$limit;
		$sql = $this->sql." LIMIT ".$limit." OFFSET ".$offset;
		
		$result = $connect->query($sql,$this->params,static::class);

		// 
		if($result){
			$object = new \StdClass();
			foreach ($result as $key => $value)
			{
			    $object->data[] = $value;
			}
			$object->links = $html; // в links мы храним ссылки на страницы
			return $object;
		}
		else{
			return false;
		}
	}






	/**
     * Метод, возвращающий количество записей
     */
	public static function getCount(){
		$connect =  Database::getInstance();

		$sql = "SELECT * FROM ".static::getTableName();
		$params = [];

		$result = $connect->query($sql,$params,static::class);
		if($result)
			return count($result);
		else 
			return false;
	}



	 /**
     * Получаем данные в зависимости от страницы $current_page
     *
     * @param int $count (Количество получаемых данных)
     * @return $this
     */
     public static function getLastData($count,$params){

     	$result = "";

     	foreach ($params as $key => $value) {
     		$result.=$key."=:".$key.",";
     	}
     	$result = trim($result,",");

     	$connect =  Database::getInstance();

		$sql = "SELECT * FROM ".static::getTableName()." WHERE ".$result." ORDER BY created_at DESC LIMIT ".$count;
		$params = $params;

		$result = $connect->query($sql,$params,static::class);
		return $result;
     }


	/**
     * Конечный метод
     */
	public function get(){

		$sql = $this->sql;
		$params = $this->params;

		$result = $this->databaseConnect->query($sql,$params,static::class);
		return $result;
		// return $params;

	}



}

