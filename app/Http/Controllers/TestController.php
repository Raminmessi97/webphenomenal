<?php
namespace App\Http\Controllers;
use App\Views\View;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;
use App\Http\Request;
use App\Http\Controller;
use App\Models\Article;

class TestController extends Controller{
	
		/**
	     * Display a listing of the resource.
	     *
	     */
		public function index(){
		    Defeat::csrf_defeat_session();
			View::view("test/index");
		}

		public function test_xss($request){
			 // print_r($request);
			 return json_encode($request);
		}	

		public function get_report($request){

			// $data = json_encode($request);
		
			$data = "Вид атаки:XSS\n";
			$data.="Дата атаки:".date("Y/m/d H:i")."\n";
			// $data+=json_encode($request);

			$data .= json_encode($request,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)."\n\r";	


			$fh = fopen("app/report2.txt", "a+") 
			or die("Создать файл не удалось");


			if(fwrite($fh, $data)){
				echo "Данные удачно записаны в модель data\033";
			}
			else{
				echo "Не удалось записать данные в модель filename";
			}
			fclose($fh);
		}


}