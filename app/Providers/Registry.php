<?php

namespace App\Providers;

/**
 * Description of index
 *
 */
class Registry {
    
    /**
     * Возващаемые объекты для всех страниц
     * @var array
     */
    public static $objects = [];

     /**
     * Данные которые должны быть доступны на каждой странице
     * @var array
     */
    private $for_public;
    

    /**
     * 
     * Чтобы  создавать объект один раз (Singleton Pattern)
     */
    protected static $instance;



    /**
     * 
     * 
     */
    
    protected function __construct() {
         $this->for_public = require "RegistryData.php";
        foreach($this->for_public as $name => $component){
            $object = $component[0]::getInstance();
            $action = $component[1];
            $object = $object->$action()->get();

            self::$objects[$name] =$object;
        }
    }
    
    public static function instance() {
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    public function __get($name) {
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }
    
    public function __set($name, $object) {
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $object;
        }
    }
    


     /**
     * Возвращает нужные нам объекты
     * @return $objects 
     */

    public function start(){
        return self::$objects;
    }
    
}
