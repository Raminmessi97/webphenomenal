<?php

namespace App\Http\Middlewares;


class  AuthMiddleware extends Middleware{
	
 	/**
     * @param  $array $authorised_author
     * @param  $array $all_users
     */
	public function check($author,$authors){
		 $check = false;

		 foreach ($authors as $key => $value) {
		 	if($value['author_email']===$author['author_email'])
		 		$check = true;
		 }

			if($check){
				return parent::check($author,$authors);
			}
				return false;
	}
}