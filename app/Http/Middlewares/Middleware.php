<?php

namespace App\Http\Middlewares;


abstract class Middleware{

	private $next;

	public function linkWith($next_middleware){
		$this->next = $next_middleware;
		return $next_middleware;
	}

	public function check($user_name,$list){
		if(!$this->next){
			return true;
		}

		return $this->next->check($user_name,$list);
	}
}