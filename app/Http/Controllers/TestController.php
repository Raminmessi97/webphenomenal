<?php
namespace App\Http\Controllers;
use App\Views\View;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;
use App\Http\Request;
use App\Http\Controller;
use App\Models\Article;

class TestController extends Controller{

		// contruct
	 public function __construct(){
	 	// return $this->middleware(['auth','admin']); // 1-ый вариант - ко всем action-ам
	    // return $this->middleware(['auth','admin'], ['except'=>['ramin']]); // 1-ый вариант
	    // return $this->middleware(['auth','admin'], ['only'=>['index']]); //2-ый вариант
	 	// return $this->middleware(['auth','admin'])->only(['index']); //3-ий вариант
	 	// return $this->middleware(['auth','admin'])->except(['index']); //4-ый вариант
	}

		/**
	     * Display a listing of the resource.
	     *
	     */
		public function index(){
			header("Content-Security-Policy: default-src 'self';report-uri https://webphenomenal.ru/test/get_report/");
			header("Content-Security-Policy: script-src 'self' 'unsafe-eval' https://webphenomenal.ru");
			$options = array(
				'expires'=>time()+3600,
				'path'=>'/',
				'secure'=>true,
				'httponly'=>true,
				'samesite'=>'None'
			);
			setcookie("for_test",'test',$options);
			View::view("test/index");
			
		}

		public function test_xss($request){
			header("Content-Security-Policy: default-src 'self';report-uri https://webphenomenal.ru/test/get_report/ ");
			// header("Content-Security-Policy-Report-Only: default-src https:; report-uri https://webphenomenal.ru/test/get_report/");
			print_r($request);
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