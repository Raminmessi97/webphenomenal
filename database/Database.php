<?php

namespace Database;

class Database{
	/**
     * 
     * Переменная подключения к базе данных
     */
	private $connection_to_db;


	/**
     * 
     * Чтобы  создавать объект один раз (Singleton Pattern)
     */
	private static $instance=null;


	 /**
     * Method for connection to database
     */

     public static function getInstance(){
     	if(self::$instance==null){
     		return self::$instance = new self;
     	}
     	return self::$instance;
     }

      /**
     * Private Construct
     */

      private function __construct(){
      	// Берем данные для подключения к базе данных
      	$settings = require "settings.php";
      	// 

      	$this->connection_to_db = new \PDO("mysql:host=".$settings['host'].";dbname=".$settings['database'].";charset=utf8",$settings['user'],$settings['password']);

      	$this->connection_to_db->exec("SET NAMES UTF-8");
      }

	// Не позволяем клонировать
	private function __clone () {} 
	private function __wakeup () {}


    /**
     * Выполнение SQl запроса
     *
     * @param string $sql,array $params,string $className
     * @return data from database
     */

	public function query($sql,$params=[],$class='stdClass'){
		$stmt = $this->connection_to_db->prepare($sql);
		$stmt->execute($params);

    $count = $stmt->rowCount();
    $result = $stmt->fetchAll(\PDO::FETCH_CLASS,$class);

    if($count){
		  return $result;
    }
    else{
      return $count;
    }
		
	}

    public function queryOne($sql,$params=[],$class='stdClass'){
      $stmt = $this->connection_to_db->prepare($sql);
      $stmt->execute($params);

      $count = $stmt->rowCount();
      $result = $stmt->fetchAll(\PDO::FETCH_CLASS,$class);

      if($count==1){
        return $result[0];
      }
      else{
        return $count;
      }
  }



    /**
     * CRUD
     *
     * @param string $sql,array $params,string $className
     * @return result of creating
     */

    public function crud($sql,$params,$class='stdClass'){
      $stmt = $this->connection_to_db->prepare($sql);
      $stmt->execute($params);

      return $stmt->rowCount();  // Вернет 1 если объект создаст либо 0
    }



}