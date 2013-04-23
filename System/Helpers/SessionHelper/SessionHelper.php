<?php

class SessionHelper {

    public static function CreateSession($param1, $param2 = null, $value) {
        if($param2 == null)
            return $_SESSION[$param1] = $value;
        return $_SESSION[$param1][$param2] = $value;
    }

    public static function SelectSession($param1, $param2 = null) {
        if($param2 == null)
            return $_SESSION[$param1];
        return $_SESSION[$param1][$param2];
    }

    public static function DeleteSession($param1, $param2 = null) {
        if ($param2 == null) {
            unset($_SESSION[$param1]);
        } else {
            unset($_SESSION[$param1][$param2]);
        }
    }

    /**
     * @param String $name
     * @return boolean
     */
    public static function CheckSession($param1, $param2 = null) {
        if($param2 == null)
            return isset($_SESSION[$param1]);
        
        return isset($_SESSION[$param1][$param2]);
    }

}

?>