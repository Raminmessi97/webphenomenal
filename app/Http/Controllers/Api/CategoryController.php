<?php
namespace App\Http\Controllers\Api;
use App\Views\View;
use App\Useful_funcs\Defeat;
use App\Useful_funcs\Redirect;
use App\Http\Request;
use App\Models\Category;
use App\Useful_funcs\NiceOutput;
class CategoryController{
/**
	     * Display a listing of the resource.
	     *
	     */
		public function index(){
			$categories = Category::getAll();
			echo(NiceOutput::getNiceJson($categories));
		}		
		/**
	     * Show the form for 
	     * @param int $id
	     */
		public function show($id){

		}

		/**
	     * Show the form for creating a new resource.
	     *
	     */
		public function create(){

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