<?php

namespace App\Useful_funcs;

class Defeat{

	public static function csrf_defeat_session(){
		$token  = bin2hex(random_bytes(32));
		$_SESSION['csrf_token'] = $token;
		return $token;
	}


	 /**
     * Defeat from csrf attacks
     *
     * @return $scrf_token
     */
	public static function csrf_defeat(){
		$token  = bin2hex(random_bytes(32));

		$arr_cookie_options = array (
                'expires' => time() + 3600*3,
                'path' => '/',
                'secure' => true,     // or false
                'httponly' => false,    // or false
                'samesite' => 'Strict' // None || Lax  || Strict
                );

		setcookie('csrf_token', $token, $arr_cookie_options);   
		return $token;
	}

	public static function csrf_token_cookie(){
		$token  = bin2hex(random_bytes(32));

		$arr_cookie_options = array (
                'expires' => time() + 3600*3,
                'path' => '/',
                'secure' => true,     // or false
                'httponly' => true,    // or false
                'samesite' => 'Strict' // None || Lax  || Strict
                );

		setcookie('csrf_token', $token, $arr_cookie_options);   
		return $token;
	}


	// 
	public static function encrypt_decrypt($action, $string) {
	    $output = false;

	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'This is my secret key:24/06/1997';
	    $secret_iv = 'This is my secret iv:24/06/1997';

	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    if ( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if( $action == 'decrypt' ) {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
    	return $output;
	}



	public static function new_csrf_defeat(){
		$plain_txt = "Diffucult plain text:24/06/1997";
		$encrypted_txt = self::encrypt_decrypt('encrypt', $plain_txt);
		return $encrypted_txt;
	}

	public static function check_nw_scrf($value){
		$decrypted_txt = self::encrypt_decrypt('decrypt', $value);

		$plain_txt = "Diffucult plain text:24/06/1997";
		if ( $plain_txt === $decrypted_txt ) 
			return true;
		else 
			return false;
	}


	/**
     * Defeat from xss attacks(Удаляет только опасные теги)
     *
     * @return string
     */
	public static function xss_defeat($var){
		// $var=  strip_tags($var);
		$var = htmlspecialchars($var, ENT_QUOTES);
		$var = htmlspecialchars_decode($var);
		return $var;
	}

	/**
     * Defeat from xss attacks(Удаляем все теги)
     *
     * @return string
     */
	public static function full_xss_defeat($var){
		$var=  strip_tags($var);
		$var = htmlentities($var, ENT_QUOTES);
		$var = html_entity_decode($var);
		return $var;
	}



}