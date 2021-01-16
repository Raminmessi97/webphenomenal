<?php

namespace Database;



class Redis{

	/** 
     * Переменная redis
     */
	private static $instance=null;

	/**
     * 
     * Переменная подключения к базе данных redis
     */
	private  $redis_connection;


	/**
     * Create singleton instance 
     */
	public static function getInstance(){
		if(!self::$instance){
			$object = new self();
			self::$instance = $object;
			return $object->redis_connection;
		}
		return self::$instance->redis_connection;
	}





	private function __construct(){

		try{
			$this->redis_connection = new \Predis\Client([
		    'scheme' => 'tcp',
		    'host'   => '127.0.0.1',
		    'port'   => 6379,
		]);

		}
		catch(\Exception $e){
			 echo "Нет соединения с Redis";
   			 echo $e->getMessage();
		}
	}



}


// $client->set('foo', 'bar');
// $value = $client->get('foo');

// $array = [
//   'name'=>'ramin',
//   'age'=>23
// ];

// $client->set('data', json_encode($array));
// $value = $client->get('name');
// echo $value;



