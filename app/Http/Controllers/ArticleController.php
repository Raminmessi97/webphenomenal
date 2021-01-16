<?php
namespace App\Http\Controllers;	
use App\Models\Article;
use App\Models\Category;
use App\Views\View;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;
use App\Http\Request;

use App\Http\Controller;


class ArticleController extends Controller {


	public function __construct(){
 		// return $this->middleware(['auth','admin']); // 1-ый вариант - ко всем action-ам
    // return $this->middleware(['auth','admin'], ['except'=>['index']]); // 1-ый вариант
    return $this->middleware(['auth','admin'], ['only'=>['create','edit']]); //2-ый вариант
 	// return $this->middleware(['auth','admin'])->only(['create']); //3-ий вариант
 	// return $this->middleware(['auth','admin'])->except(['index','show']); 4-ый вариант
	}

	 /**
     * Display a listing of the resource.
     *
     */
	public function index($id){
		$article = Article::find($id);	

	   $timestamp = strtotime($article->updated_at);
       $new_date = date("d-m-Y", $timestamp);
       $article->updated_at = $new_date;

       $article_category = $article->getCategoryData();

       // for test xss 
       	setcookie("xss_attacked_cookie","xss attack",time()+3600,"/");
       	Defeat::csrf_defeat();
       // 


       $similar_articles = $article->getSimilarArticles();

		$data =  [
			'article'=>$article,
			'article_category'=>$article_category,
			'similar_articles'=>$similar_articles,
		];

		View::view("articles/index",$data);
	}


	 /**
     * Display a category articles
     *@param string $category_name
     */
	public function category_articles($category_name,$page=1){

		$object = Category::getInstance();
		$get_category = $object->findAll()->where("route_name","=",$category_name)->get();
		$id = $get_category[0]->id;

		$object2 = Article::getInstance();
		$articles = $object2->findAll()->where("category_id","=",$id)->paginateT(4,$page);
		if($articles){
		    $data = [
	           'data'=>$articles->data,
	           'links'=>$articles->links
	      	];
	      	foreach ($data['data'] as $key => $value) {
	          $timestamp = strtotime($value->created_at);
	          $new_date = date("d-m-Y", $timestamp);
	          $value->created_at = $new_date;

	          $text = strip_tags($value->text);
	          $text = substr($text, 0, 120);
	          $text = substr($text, 0, strrpos($text, ' '));
	          $text = $text."… ";
	          $value->text =  $text;
       	 }
	    }
	    else{
	    	$data = [
	    		'data'=>"Нет статей"
	    	];
	    }
	     
		View::view('category/index',$data);
	}

	/**
     * Show the form for creating a new resource.
     *
     */
	public function create(){
		$csrf_token = Defeat::csrf_token_cookie();

		$data = [
			'csrf_token'=>$csrf_token
		];
		View::view("articles/create",$data);
	}

	/**
     * Store a newly created resource in storage.
     */
	public function store(Request $request){
			if($_COOKIE['samesite']==$request->csrf_token)
				echo "cool";
			else
				echo "ATTACK";
	}

	/**
     * Show the form for editing the specified resource.
     */
	public function edit($id){
		View::view("articles/edit");
	}

	/**
     * Update the specified resource in storage.
     * @param  array $form_data
     * @param  int  $id
     */
	public function update(Request $request,$id){

		// url for redirect
		$url = "articles/".$id;

		// Будем хранить ошибки
		$errors = [];
		// 
		$title = $request->title;
		$text =  $request->text;
		$csrf_token = $request->csrf_token;

		//xss defeat
			$title = Defeat::xss_defeat($title);
			$text = Defeat::xss_defeat($text);
		// 

		if(!preg_match("/^[a-zA-Z0-9а-яёА-ЯЁ\s\.\-]{10,}$/u",$title)){
			$errors[] = "Тайтл слишком короткий";
		}
		if(!preg_match("/^[a-zA-Z0-9а-яёА-ЯЁ\s\.\-]{20,}$/u", $text)){
			$errors[] = "Текст слишком короткий";
		}

		if($_SESSION['csrf_token']!==$csrf_token){
			$errors[] = "CSRF ATTACK";
		}

		

		$object = Article::find($id);

		if(!$errors){
				$result = $object->update([
				'title'=>$title,
				'text'=>$text
			]);
			if($result){
		  		Redirect::redirect($url,'article_update_success',"Articles was updated successfully");
			}
			else{
			  Redirect::redirect($url,'article_update_error',"Error during updating article");
			}
		}
		else{
				$errors[] = "Произошла ошибка при обновлении записи";
				Redirect::redirect($url,'article_update_error',$errors);
		}
	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function delete($id)
    {
       	// url for redirect
		$url = "";

		// Будем хранить ошибки
		$errors = [];
		//  
		 if(Article::find($id)){
		 	$article = Article::find($id);
			$result = $article->delete();

			if($result){
		  		Redirect::redirect($url,'article_delete_success',"Articles was deleted successfully");
			}
			else{
			  Redirect::redirect($url,'article_delete_error',"Error during deleting article");
			}

		 }
		 else{
		 	 Redirect::redirect($url,'article_delete_error',"Нет такой записи");
		 }
	}
}