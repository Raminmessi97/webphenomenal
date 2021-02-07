<?php

class CsrfVerify{

	public function verify(){
		if(!isset($_SESSION['csrf_token']))
		{
			echo "error";
		}
		elseif (!) {
			# code...
		}

	}	
}

c