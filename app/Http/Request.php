<?php

namespace App\Http;
use App\Useful_funcs\Defeat;

class Request {

	/**
     *Получает данные и преобразовавыет их
     *
     * @param string $data
     */
	public static function getData($data){


        $new_data = explode("&", $data['request_data']);
      	$result = [];

      	foreach ($new_data as $key) {
      		$del = explode("=", $key);
      		$result[$del[0]] = urldecode($del[1]);
      	}


      	$object = new Request();
    		foreach ($result as $key => $value)
    		{
    		    // $object->$key =  Defeat::full_xss_defeat($value);
          $object->$key = $value;
    		}

        if(isset($data['fileData'])){
          $object->files = $data['fileData'];
        }



      	return $object;

	}


  /**
     *Получает данные и преобразовавыет их
     *
     * @param array $data
  */
  public static function getRequestData($data){

        $new_data = $data['request_data'];
        unset($new_data['route']);  //удаляем ключ route

        
        // $new_data = Defeat::xss_defeat($new_data);
        // print_r($new_data);

        $object = new Request();
        foreach ($new_data as $key => $value)
        {
            $object->$key = $value;
        }

        if(isset($data['fileData'])){
          $object->files = $data['fileData'];
        }


        return $object;

  }


    public function all(){
        $object = $this;

        $array = [];

        foreach($object as $key => $value) {
            $$key = $value;
            if(strval($key)!="csrf_token")
              $array[$key] = $value;
            if(strval($key)=="files"){
              $name = URL_MAIN."resources/images/".$object->files['file']['name'];
              unset($array['files']);
              $array['image'] = $name;
            }

        }
        return $array;
    }
}