<?php
namespace App\Models;	

class Category extends ActiveRecord {

	protected static function getTableName(){
		return "categories";
	}
}