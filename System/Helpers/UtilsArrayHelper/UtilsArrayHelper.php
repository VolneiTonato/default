<?php

class UtilsArrayHelper {

    /**
     * 
     * @param string nome da classe
     * @param array post
     * @return object reference a classe
     * @example getObjectByPost('Pessoa',$_POST)
     */
    public static function getObjectByPost($class, Array $post) {
        $obj = new $class;
        $ref = new ReflectionClass($class);
        $post = self::AjustarNomeAtributoByPost($post);
        $dados = array();
        $listaMetodos = array();



        foreach ($post as $key => $value) {
            foreach ($ref->getProperties() as $atributo) {
                if (strtolower($key) == strtolower($atributo->getName())) {

                    $method = 'set' . $key;

                    if (in_array($method, $listaMetodos))
                        continue;


                    $listaMetodos[] = $method;

                    if (!$ref->hasMethod($method))
                        continue;

                    $objMethod = new ReflectionMethod($class, $method);

                    if (!$objMethod->isPublic())
                        continue;

                    $objMethod->invoke($obj, $value);
                }
            }
        }
        return $obj;
    }

    /**
     * 
     * @param object
     * @return array
     * @example getArray((object) $pessoa)
     */
    public static function getArrayByObject($object) {
        $arr = array();
        $newArray = array();
        if (is_object($object)) {
            $arr = (array) $object;
        }


        if (is_array($arr)) {
            $ref = new ReflectionClass($object);

            foreach ($arr as $k => $v) {
                foreach ($ref->getProperties() as $p) {
                    $preg = "/" . $p->getName() . "$/";
                    preg_match($preg, $k, $return);

                    if (isset($return[0])) {
                        if (strtolower($return[0]) == strtolower($p->getName())) {
                            $newArray[$p->getName()] = $v;
                        }
                    }
                }
            }
            return $newArray;
        }
    }

    public static function getArrayClassByPost($class, Array $post) {
        $obj = new $class;
        $ref = new ReflectionClass($class);
        $post = self::AjustarNomeAtributoByPost($post);
        $dados = array();

        foreach ($post as $key => $value) {
            foreach ($ref->getProperties() as $atributo) {
                if (strtolower($key) == strtolower($atributo->getName())) {

                    if (!array_key_exists($key, $dados)) {
                        $dados[$key] = $value;
                    }
                }
            }
        }
        return $dados;
    }

    private static function AjustarNomeAtributoByPost(Array $post) {
        $itensInvalidos = array("-", "_", " ");
        $dados = array();
        foreach ($post as $key => $value) {
            $key = str_replace(array_values($itensInvalidos), " ", $key);
            $key = ucwords(strtolower($key));
            $key = str_replace(" ", "", $key);
            $key = strtolower(substr($key, 0, 1)) . substr($key, 1, strlen($key));
            $dados[$key] = $value;
        }
        return $dados;
    }

    /**
     * 
     * @param object referenciado
     * @param array Entity
     * @param bool __call
     * @return Object Reference
     * @throws Exception
     * @example getObjectReference($objReference, array('id'=>'1','nome'=>'nome da pessoa'), false)
     */
    public static function getObjectReference($target, $options, $tryCall = false) {
        if (!is_object($target)) {
            throw new Exception('Target should be an object');
        }
        if (!($options instanceof Traversable) && !is_array($options)) {
            throw new Exception('$options should implement Traversable');
        }

        $tryCall = (bool) $tryCall && method_exists($target, '__call');

        foreach ($options as $name => &$value) {
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));

            if ($tryCall || method_exists($target, $setter)) {
                call_user_func(array($target, $setter), $value);
            } else {
                continue; // instead of throwing an exception
            }
        }
        return $target;
    }

    public static function getValuePorIndice(Array $param, $indice) {
        if (isset($param[$indice])) {
            return $param[$indice];
        }
        return "";
    }

}

?>
