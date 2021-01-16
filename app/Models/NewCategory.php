<?php
namespace App\Models;	

class NewCategory extends ActiveRecord {
	//body of controller

	protected static function getTableName(){
		return "new_categories";
	}
}