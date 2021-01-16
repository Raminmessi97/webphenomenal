<?php

namespace App\Models;

class User extends ActiveRecord{

	protected static function getTableName(){
			return "users";
		}

	
	public function isAdmin(){
		$author_email= $this->email;
		$author_role = $this->role;

		if( ($author_email=="ramin.hes.97@gmail.com") && ($author_role==2) ) 
			return true;
		return false;
	}

	public static function user(){
		if(isset($_COOKIE['logged_user']))
			return json_decode($_COOKIE['logged_user']);
		else 
			return false;
	}


	/**
     * 
     * Сохранить пользователя в куки
     *@param user object
     */
	public static function set_user($json_user){
		$arr_cookie_options = array (
			'expires' => time() + 3600*5,
            'path' => '/',
            'secure' => true,     // or false
            'httponly' => true,    // or false
            'samesite' => 'Lax' // None || Lax  || Strict
        );

		setcookie("logged_user",$json_user,$arr_cookie_options);
		// setcookie('logged_user',$json_user,time() + 3600*5,"/"); 
	}

}