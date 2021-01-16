<?php

namespace App\Useful_funcs;


class Redirect{


     /**
     * Redirect method(Переадресуем на другую страницу с некоторыми данными)
     *
     * @param string $url,string $name,array $data
     * @return header
     */

	public static function redirect($url,$name,$data){

		$_SESSION[$name] = $data;

          if(!preg_match("~http|https~", $url)){
               $url = URL_MAIN.$url;
          }
	         header('Location:'.$url);
	}

}