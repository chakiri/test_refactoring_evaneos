<?php

namespace App\Traits;

trait Instantiation
{
    private static $instance;

    //create singleton
    public static function getInstance(){
        if (!self::$instance){
            return self::$instance = new static(); //Function get static return name of class
        }
        return self::$instance;
    }
}