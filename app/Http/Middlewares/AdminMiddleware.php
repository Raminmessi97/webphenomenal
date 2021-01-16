<?php

namespace App\Http\Middlewares;


class AdminMiddleware extends Middleware{
	
	/**
     * @param  $array $authorised_author
     * @param  $array $all_users
     */
	public function check($author,$authors){

		if(($author['author_email']=="ramin.hes.97@gmail.com")&&($author['author_role']==2)){
			return parent::check($author,$authors);
		}
		return false;
	}
}