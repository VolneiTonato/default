<?php

class DependeceInjectionHelper {
    
    private static $_instance;

    public static function getInstance($class) {
        if (!isset(self::$_instance)) {
            self::$_instance = new $class;
        }
        if (!self::$_instance instanceof $class) {
            self::$_instance = new $class;
        }

        return self::$_instance;
    }

    public static function getInstanceByObject($obj, $class) {
        if ($obj instanceof $class)
            return $obj;
        else
            return new $class;
    }

    public static function getObjectToArray(Array $resultado = array(), $class) {
        $obj = new ArrayObject($resultado);
        if ($obj->count() > 0)
            return self::getInstanceByObject($obj->getIterator()->current(), $class);

        return null;
    }
}

?>
