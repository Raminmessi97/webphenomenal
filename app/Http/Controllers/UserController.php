<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Views\View;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;
use App\Http\Request;

class UserController{

	// cabinet
	public function user_cabinet(){
		$template = 'user/index';
		View::view($template);
	}

	public function user_logout(){
		$url = "";
		setcookie('logged_user',"",time()-3600,"/");

		Redirect::redirect($url,"user_logout","Пользователь успешно вышел из системы");
	}

	// end cabinet


	 /**
     * Show the form for creating a new resource.
     */

	public function create_form(){

		$csrf_token = Defeat::csrf_token_cookie();

		$data = [
			'csrf_token'=>$csrf_token
		];
		$template = 'auth/register';
		View::view($template,$data);
	}


	 /**
     * Creating the data
     */

	public function create(Request $request){

		$errors = [];

		$url_error = "register";
		$url_success = "";

		$name = $request->name;
		$csrf_token = $request->csrf_token;
		$email = $request->email;
		$password = $request->password;

		//xss defeat
			$name = Defeat::xss_defeat($name);
		// 

		if(!preg_match("/^[a-zA-Z0-9_-]{4,}$/", $name)){
			$errors[] = "Никнейм должен содержать от 4 символов и состоять из латинских букв";
		}

		if(preg_match("/[a-zA-Z0-9]{6,}/",$password)){
			$password = password_hash($password, PASSWORD_DEFAULT);
		}
		else{
			$errors[] = "Легкий Пароль";
		}


		if($_COOKIE['csrf_token']!==$csrf_token){
			$errors[] = "CSRF ATTACK";
		}




			$new_user = User::getInstance();
			$new_user->name = $name;
			$new_user->email = $email;
			$new_user->password = $password;

			
			if(!$errors){
				if($new_user->create()){
					$new_user->admin = 0;
					unset($new_user->password);
					$json_user = json_encode($new_user);
					$success = "Пользователь был успешно создан";

					User::set_user($json_user);

					Redirect::redirect($url_success,'user_create_success',$success);
				}
				else{
					$errors[] = "Произошла ошибка при создание Пользователя";
					Redirect::redirect($url_error,'user_create_errors',$errors);
				}
			}
			else
			{
				$errors[] = "Произошла ошибка при создание Пользователя";
				Redirect::redirect($url_error,'user_create_errors',$errors);
			}	

	}


// endRegister

	 /**
     * Show the form for login
     */
	public function create_login_form(){
		$csrf_token = Defeat::csrf_token_cookie();

		$data = [
			'csrf_token'=>$csrf_token
		];
		$template = 'auth/login';
		View::view($template,$data);
	}

	 /**
     * Login method
     */
	public function login_check(Request $request){

		$errors = [];

		$email = $request->email;
		$password = $request->password;
		$csrf_token = $request->csrf_token;

		$url_error = "login";

		if($_COOKIE['csrf_token']!==$csrf_token){
			$errors[] = "CSRF ATTACK";
		}

		 $object = User::getInstance();
		 $user= $object->findAll()->where("email","=",$email)->get();
		 $user = $user[0];



		 if($user&&!$errors){
		 	 if(password_verify($password, $user->password)){
		 	 	if($user->isAdmin()){
				    $user->admin = 1;
				 }else
				 $user->admin = 0;
				 unset($user->password);
				 $json_user = json_encode($user);

			 	$success = "Успешная авторизация";
				User::set_user($json_user);

			 	Redirect::redirect("","login_success",$success);
			 }
			 else {
			 	$errors[] = "Неправильный пароль";
			 	Redirect::redirect($url_error,"login_error",$errors);
			 }
		 }
		 else{
		 	$errors[] = "Пользователь не найден";
		 	Redirect::redirect($url_error,"login_error",$errors);
		 }

	}



// Endlogin



}