<?php

namespace App\Views;

class View{

	


     /**
     * Метод, вызывающий нужный нам template
     *
     * @param  string $template,array $data
     * @return \Illuminate\Http\Response
     */

	public static function view($template,$data=[]){

		// Registry all data for all views 
		$app = \App\Providers\Registry::instance(); //
		$objects = $app->start();
		
		foreach ($objects as $key => $value) {
			$maindata[$key] = $value;
		}

		$current_page_url = self::getCurrentCategory();

		$main_path ="resources/views/";
		$template.=".php";
		$template =PROJECT_ROOT.$main_path.$template;
			
		extract($maindata);
		extract($data);
		require_once($template);


	}

	private static function getCurrentCategory(){

			if(URL_ROUTE!="/"){
				$urls = explode("/", URL_ROUTE);
               	$page = array_search("category",$urls);
               	$current_page_url = $urls[$page+1];

            }
			else{
                $current_page_url="";
            }

		return $current_page_url;
	}


}
