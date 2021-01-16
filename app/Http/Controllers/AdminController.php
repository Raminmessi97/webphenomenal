<?php
namespace App\Http\Controllers;
use App\Views\View;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;
use App\Http\Request;
use App\Http\Controller;

class AdminController extends Controller{

	// contruct
 public function __construct(){
 	return $this->middleware(['auth','admin']); // 1-ый вариант - ко всем action-ам
    // return $this->middleware(['auth','admin'], ['except'=>['show','create']]); // 1-ый вариант
    // return $this->middleware(['auth','admin'], ['only'=>['create']]); //2-ый вариант
 	// return $this->middleware(['auth','admin'])->only(['create']); //3-ий вариант
 	// return $this->middleware(['auth','admin'])->except(['index','show']); 4-ый вариант
}


		/**
	     * Display a listing of the resource.
	     *
	     */
		public function index(){
			View::view("admin/index",[]);
		}		
		
		/**
	     * Show data with id=$id
	     * @param int $id
	     */
		public function show($id){
			echo "Admin.show".$id;
		}

		/**
	     * Show the form for creating a new resource.
	     *
	     */
		public function create(){
			echo "admin.create";
		}

		/**
	     * Store a newly created resource in storage.
		 *@param Request $request;
	     */
		public function store(Request $request){

		}

		/**
	     * Show the form for editing the specified resource.
	     */
		public function edit($id){
			echo "admin.edit".$id;
		}

		/**
	     * Update the specified resource in storage.
	     * @param  Request $request
	     * @param  int  $id
	     */
		public function update(Request $request,$id){
			
		}

		/**
	     * Remove the specified resource from storage.
	     *
	     * @param  int  $id
	     */
	    public function delete($id)
	    {
	    	
	   	}
}