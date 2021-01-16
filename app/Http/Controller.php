<?php

namespace App\Http;

class Controller {

	/**
     * Все middlewares
     * @var array
     */
	public $middlewares;

	/**
     * Все методы
     * @var array
     */
	public $methods;




	/**
     * Protected function for middleware
     * @param array $middlewares
     * @param array $except_methods =[]
     */
	public function middleware($middlewares,$except_include_methods=[]){
		$this->middlewares['names'] = $middlewares;
		
		$this->middlewares['except'] = [];
		$this->middlewares['only'] = [];

		if($except_include_methods){
			foreach ($except_include_methods as $key=>$methods) {
				$this->middlewares[$key] = $methods;
			}
		}
		$this->methods = $this->reflection();

		return $this;
	}


	// Magic method __get

	public function __get($property){
		return $this->$property;
	}

	/**
     * Для каких методов будет задействован middlewares
     * @param array $methods
     */
	public function only($methods){
		$this->middlewares['except'] = [];
		$this->middlewares['only'] = $methods;
		$this->methods = $this->reflection();
	}

	/**
     * Protected function for middleware
     * @param array $except_methods
     */
	public function except($except_methods){
		$this->middlewares['except'] = $except_methods;
		$this->middlewares['only'] = [];
		$this->methods = $this->reflection();
	}

	private  function reflection(){
		$reflector  = new \ReflectionClass($this);
		$methods = $reflector->getMethods();
		$used_methods = [];



		if($this->middlewares['only']){
			foreach($this->middlewares['only'] as $method)
				$used_methods[] = $method;
		}
		else if($this->middlewares['except']){
			foreach ($methods as $method) {
				if($method->class==static::class&&$method->name!="__construct"){
					if(!in_array($method->name, $this->middlewares['except']))
						$used_methods[] = $method->name;
				}
			}
		}
		else{
			foreach ($methods as $method) {
				if($method->class==static::class&&$method->name!="__construct"){
					$used_methods[] = $method->name;
				}
			}
		}

		return $used_methods;

	}



}