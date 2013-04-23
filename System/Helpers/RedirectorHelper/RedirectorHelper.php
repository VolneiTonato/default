<?php

class RedirectorHelper {

    protected static $parameters = array();

    public static function setUrlParameter($name, $value) {
        self::$parameters[$name] = $value;
        return $this;
    }

    protected static function getUrlParameters() {
        $parms = "";
        foreach (self::$parameters as $name => $value)
            $parms .= $name . "/" . $value . "/";
        return $parms;
    }

    protected static function go($data) {

        header("Location: " . ApplicationPath::Root() . $data);
        exit();
    }

    public static function goToUrlPorTempo($url, $tempo = 1) {
        header("refresh:{$tempo};url={$url}");
        exit();
    }

    public static function goToUrl($url) {
        header("Location: " . $url);
    }

    public static function goToModule($module) {
        self::go($module . "/Home/" . self::getUrlParameters());
    }

    public static function goToModuleController($module, $controller) {
        self::go($module . "/" . $controller . "/Index/" . self::getUrlParameters());
    }

    public static function goToModuleControllerAction($module, $controller, $action) {
        self::go($module . "/" . $controller . "/" . $action . "/" . self::getUrlParameters());
    }

    public static function goToController($controller) {
        $sys = DependeceInjectionHelper::getInstance(System);
        if ($sys->VerificarModulo())
            self::go(self::getCurrentModule() . "/" . $controller . "/index/" . self::getUrlParameters());
        else
            self::go($controller . "/index/" . self::getUrlParameters());
    }

    public static function goToControllerAction($controller, $action) {
        $sys = DependeceInjectionHelper::getInstance(System);

        if ($sys->VerificarModulo()) {
            self::go(self::getCurrentModule() . "/" . $controller . "/" . $action . "/" . self::getUrlParameters());
        } else {
            self::go($controller . "/" . $action . "/" . self::getUrlParameters());
        }
    }

    public static function goToAction($action) {
        self::go(self::getCurrentController() . "/" . $action . "/" . self::getUrlParameters());
    }

    public static function goToIndex() {
        self::goToController('Index');
    }

    public static function getCurrentModule() {
        $start = DependeceInjectionHelper::getInstance(System);
        return $start->getModule();
    }

    public static function getCurrentController() {
        $start = DependeceInjectionHelper::getInstance(System);
        return $start->getController();
    }

    public static function getCurrentAction() {
        $start = DependeceInjectionHelper::getInstance(System);
        return $start->getAction();
    }

}

?>