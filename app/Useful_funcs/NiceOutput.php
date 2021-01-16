<?php

namespace App\Useful_funcs;

class NiceOutput {

	 /**
     * Вывод данных в формате json в красивом формате
     *@param array $data
     *@return array $changed_data
     */

     public static function getNiceJson($data){
     	 header('Content-Type: application/json');
     	 $data = json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
     	 return $data;
     }

}