<?php

namespace Utils;

class Utils
{
    public static function deleteSession($name):void{
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }

    public static function isAdmin():bool{
        if(isset($_SESSION['admin'])){
            return true;
        }else{
            return false;
        }
    }

    public static function getHora(){
        return date("H:i:s");
    }

    public static function getFecha(){
        return date("Y-m-d");
    }
}