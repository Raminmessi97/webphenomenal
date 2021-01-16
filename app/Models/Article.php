<?php

namespace App\Models;
use App\Models\Category;

class Article extends ActiveRecord {

	protected static function getTableName(){
		return "articles";
	}

	public function getCategoryData(){
		$id = $this->category_id;
		$category = Category::find($id);
		return $category;
	}

	public function getSimilarArticles(){
		$count = 3;  //берем последние 3 записи
		$id = $this->category_id;

		$params = ["category_id"=>$id];

		return Article::getLastData($count,$params);
	}
}