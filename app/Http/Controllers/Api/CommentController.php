<?php
namespace App\Http\Controllers\Api;
use App\Http\Request;
use App\Useful_funcs\NiceOutput;
use App\Models\Comment;	
use App\Models\User;

class CommentController  {
	

	//create a new comment
	public function store(Request $request){
		// Будем хранить errors и successes
        $errors['errors'] = [];
        $successes['success'] =[];

  //       // 


		$text = $request->text;
		$article_id = $request->article_id;
		$user = User::user();
		$author_id = $user->id;



		if($_COOKIE['csrf_token']!=$request->csrf_token)
			$errors['errors'][] = "CSRF ATTACK";

		if(!$errors['errors']){
			$object = Comment::getInstance();
			$object->text = $text;
			$object->author_id = $author_id;
			$object->article_id = $article_id;

			if($object->create()){
				$successes['success'][] = "Вы успешно создали комментарий";
				print_r(json_encode($successes));
			}
			else{
				$errors['errors'][] = "Ошибка при создании комментария";
	            print_r(json_encode($errors));
			}
		}
		else{
	        print_r(json_encode($errors));
		}	

	}

	public function get($article_id){
		// $comments = Comment::getAll();
		$object2 = Comment::getInstance();
		$comments = $object2->findAll()->where("article_id","=",$article_id)->get();

		if($comments){
			foreach ($comments as $comment) {
				$user = User::find(intval($comment->author_id));
				$comment->author_name = $user->name;
				$date = self::data_to_nice_view($comment->date);
				$comment->date = $date;
			}
		}

		print_r(NiceOutput::getNiceJson($comments));
	}

	private static function data_to_nice_view($date){
		 $timestamp = strtotime($date);
	     $new_date = date("d-m-Y", $timestamp);	
	     return $new_date;
	}

	public function store_response(Request $request){
		print_r(NiceOutput::getNiceJson($request));
	}
}