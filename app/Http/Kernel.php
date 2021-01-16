<?php
namespace App\Http;

class Kernel {


	/**
     * Все middlewares
     * @var array
     */
	private static $route_middlewares = [
		'auth' => '\App\Http\Middlewares\AuthMiddleware',
		'admin' => '\App\Http\Middlewares\AdminMiddleware'
	];


	/**
     * Метод для возвращения всех middlewares
     *
     */

	public static function get_all_middlewares(){
		return self::$route_middlewares;
	}


}