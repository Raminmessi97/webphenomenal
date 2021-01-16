<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Views\View;
use App\Useful_funcs\NiceOutput;
use App\Useful_funcs\Pagination;
use App\Http\Request;
use App\Models\Category;
use App\Models\NewCategory;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;


class MainController {

     /**
     *
     * @param  int  $current_page
     */
     public function main($page=1){
         
        $pag_data = Article::paginate(4,$page);

          //for search form

        if($pag_data!=null){
            $data = [
                'data'=>$pag_data->data,
                'links'=>$pag_data->links,
            ];

             foreach ($data['data'] as $key => $value) {
                $timestamp = strtotime($value->created_at);
                $new_date = date("d-m-Y", $timestamp);
                $value->created_at = $new_date;
              }
        }
        else{
          $data = [];
        }
        

     
          View::view('homepage',$data);
     }

     public function all_cats(){
            $new_categories = NewCategory::getAll();

            $data = [
               'new_categories'=>$new_categories
            ];

            View::view('test/categories',$data);

     }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(){
               View::view("user/index",[]);
     }



     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function create($id){
          echo 'Create article with id='.$id;
     }

      /**
     * Get the search result from database
     *
     * @param Request $request
     */
     public function search($search){
      // return false;
      // $search = $_GET['q'];
      //   // url for redirect
      if (isset($_SERVER['HTTP_REFERER'])) {
          $url = $_SERVER['HTTP_REFERER'];
      }
      else{
        $url = "";
      }

      //   // Будем хранить ошибки
        $errors = [];

        if(!preg_match("/^[a-zA-Z0-9а-яёА-ЯЁ\s\.\-]{3,}$/u",$search)){
           $errors[] = "Поиск должен состоять только из букв или цифр";
           $errors[] = "Должно быть минимум 3 символа";
        }

          if(!$errors){
            $object = Article::getInstance();
             $article = $object->findAll()->where("title","LIKE","%".$search."%")->get();
             
             $data = [
              'data'=>$article
             ];
             View::view("search/index",$data);
          }
          else{
              $errors[] = "Произошла ошибка при поиске";
              Redirect::redirect($url,"search-error",$errors);
          }
      }
    

}