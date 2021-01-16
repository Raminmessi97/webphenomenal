<?php
namespace App\Http\Controllers\Api;	
use App\Models\Article;
use App\Useful_funcs\Defeat;
use App\Http\Request;
use App\Useful_funcs\NiceOutput;

class ArticleController {


	 /**
     * Display a listing of the resource.
     *
     */
	public function index(){
 	  $object = Article::getInstance();
 	  $articles = $object->findAll()->get();
 	  print_r(NiceOutput::getNiceJson($articles));
	}


    public function show($id){
        $article = Article::find($id);
        print_r(NiceOutput::getNiceJson($article));
    }

    public function page_articles($page){
        $pag_data = Article::paginate(5,$page);

          $data = [
               'data'=>$pag_data->data
          ];
         print_r(json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }



        /**
         * Show the form for editing the specified resource.
         */
        public function edit($id){
           echo "edit";
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         */
    public function delete(int $id){
        if(Article::find($id)){
            $article = Article::find($id);
            $result = $article->delete();
            if($result){
                echo "Article with id=".$id." was deleted successfully";
            }
            else{
               echo  "Error during deleting article with id=".$id; 
            }
        }
         else{
           echo "This article hasn't found";
         }
    }


    public function store(Request $request){
        // Будем хранить errors и successes
        $errors['errors'] = [];
        $successes['success'] =[];
        // 

        $title = $request->title;
        $text =  $request->text;
        $title_text =  $request->title_text;
        $category_id = $request->category;
        $file = $request->files;


        // if(!preg_match("/^[a-zA-Z0-9а-яёА-ЯЁ\s\.\-\,]{10,}$/u",$title)){
        //     $errors['errors'][] = "Тайтл слишком короткий";
        // }
        if(strlen($title)<10)
             $errors['errors'][] = "Тайтл слишком короткий";
         if(strlen($title_text)<20)
             $errors['errors'][] = "Описание слишком короткое";
        if(strlen($text)<20){
            $errors['errors'][] = "Текст слишком короткий";
        }

        $uploaded_url = PROJECT_ROOT."resources/images/";
        if(!$errors['errors']){
                if($file['file'])
                {
                   $avatar_name = $_FILES["file"]["name"];
                   $avatar_tmp_name = $_FILES["file"]["tmp_name"];

                   $image = URL_MAIN."resources/images/".$avatar_name;
                   $error = $_FILES["file"]["error"];

                   if(move_uploaded_file($avatar_tmp_name, $uploaded_url.$avatar_name))
                     $successes['success'][] = "Image was uploaded successfully";
                   else
                    $errors['errors'][] = "image was not uploaded successfully";
                }
        }
        
        if(!$errors['errors']){
            $object = Article::getInstance();
            $object->title = $title;
            $object->title_text = $title_text;
            $object->text = $text;
            $object->image = $image;
            $object->category_id = $category_id;
        
            if($object->create()){
                $successes['success'][] = "Articles was created successfully";
                print_r(json_encode($successes));
            }
            else{
                $errors['errors'][] = "Error during creating article";
                print_r(json_encode($errors));
            }
        }
        else{
            print_r(json_encode($errors));
        }
        
        }


    public function update(Request $request,$id){

        $errors['errors'] = [];
        $successes['success'] =[];

        foreach($request as $key => $value) {
            if($value){ 
                $$key = $value;
            }
        }




        // Будем хранить ошибки
        $errors['errors'] = [];
        // // 

        // $csrf_token = $request->csrf_token;

        if(isset($title)){
            if(!preg_match("/^[a-zA-Z0-9а-яёА-ЯЁ\s\.\-]{10,}$/u",$title)){
                 $errors['errors'][] = "Тайтл слишком короткий";
            }
        }
        if(isset($title_text)){
            if(strlen($title_text)<20){
                 $errors['errors'][] = "Описание слишком короткое";
            }
        }

        if(isset($text)){
            if(strlen($text)<20){
                $errors['errors'][] = "Текст слишком короткий";
            }
        }

        // if($_SESSION['csrf_token']!==$csrf_token){
        //     $errors['errors'][] = "CSRF ATTACK";
        // }

        $uploaded_url = PROJECT_ROOT."resources/images/";
        if(!$errors['errors']&&isset($request->files)){
            $file =  $request->files;
                if($file['file'])
                {
                   $avatar_name = $_FILES["file"]["name"];
                   $avatar_tmp_name = $_FILES["file"]["tmp_name"];

                   $image = URL_MAIN."resources/images/".$avatar_name;
                   $error = $_FILES["file"]["error"];

                   if(move_uploaded_file($avatar_tmp_name, $uploaded_url.$avatar_name))
                     $successes['success'][] = "Image was uploaded successfully";
                   else
                    $errors['errors'][] = "image was not uploaded successfully";
                }
        }
        

        

        $object = Article::find($id);

        if(!$errors['errors']){
            $result = $object->update($request->all());
            if($result){
                $successes['success'][] = "Articles was updated successfully";
                print_r(json_encode($successes));
            }
            else{
               $errors['errors'][] = "Error during updating article 1";
               print_r(json_encode($errors));
            }
        }
        else{
                  // $errors['errors'][] = "Error during updating article 2";
                 print_r(json_encode($errors));
          }
    }

}