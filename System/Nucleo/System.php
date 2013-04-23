<?php

Class System {

    private $_url;
    private $_explode;
    private $_module;
    private $_controllers;
    private $_action;
    private $_params;

    public function __construct() {
        $this->setUrl();
        $this->setExplode();
        $this->setModule();
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

    private function setUrl() {
        $_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : ApplicationConfig::ModuleDefault() . '/' . ApplicationConfig::ControllerDefault() . '/' . ApplicationConfig::ActionDefault());
        $this->_url = $_GET['url'];
    }

    private function setExplode() {
        $this->_explode = explode('/', $this->_url);
    }

    private function setController() {
        $idx = 0;
        if ($this->VerificarModulo())
            $idx = 1;
        $ct = (!isset($this->_explode[$idx]) || $this->_explode[$idx] == null || ucfirst($this->_explode[$idx]) == ApplicationConfig::ControllerDefault() ? ApplicationConfig::ControllerDefault() : $this->_explode[$idx]);
        $this->_controllers = $ct;
    }

    private function setModule() {
        $md = (!isset($this->_explode[0]) || $this->_explode[0] == null ? ApplicationConfig::ModuleDefault() : $this->_explode[0]);
        $this->_module = $md;
        if (!$this->VerificarModulo())
            $this->_module = null;
    }

    private function setAction() {
        $array = array("index", "init", "ini", "default", "home");
        $idx = 1;
        if ($this->VerificarModulo())
            $idx = 2;
        $ac = (!isset($this->_explode[$idx]) || $this->_explode[$idx] == null || in_array(strtolower($this->_explode[$idx]), $array) ? ApplicationConfig::ActionDefault() : $this->_explode[$idx]);
        $this->_action = $ac;
    }

    protected function CorrigirUrl($url) {

        if (preg_match("/[-]/", $url)) {
            $url = str_replace("-", " ", $url);
            $url = ucwords(strtolower($url));
            $url = str_replace(" ", "", $url);
        } else {
            $url = strtolower($url);
            $url = ucfirst($url);
        }
        return $url;
    }

    private function setParams() {
        if ($this->VerificarModulo())
            unset($this->_explode[0], $this->_explode[1], $this->_explode[2]);
        else
            unset($this->_explode[0], $this->_explode[1]);

        if (end($this->_explode) == null) {
            array_pop($this->_explode); //Se o array for vazio deleta
        }

        $i = 0;

        if (!empty($this->_explode)) {
            foreach ($this->_explode as $val) {
                if ($i % 2 == 0) {
                    $indArray[] = strtolower($val);
                } else {
                    $valArray[] = addslashes($val);
                }
                $i++;
            }
        } else {
            $indArray = array();
            $valArray = array();
        }

        if (count($indArray) == count($valArray) && !empty($indArray) && !empty($valArray)) {
            $this->_params = array_combine($indArray, $valArray);
        } else {
            $this->_params = array();
        }
    }

    private function getModuleApp() {
        return $this->CorrigirUrl($this->_module);
    }

    public function getModule() {
        return strtolower($this->_module);
    }

    private function getActionApp() {
        return $this->CorrigirUrl($this->_action);
    }

    public function getAction() {
        return strtolower($this->_action);
    }

    private function getControllerApp() {
        return $this->CorrigirUrl($this->_controllers);
    }

    public function getController() {
        return strtolower($this->_controllers);
    }

    public function getParams($name = null) {
        if ($name != null) {
            $name = strtolower($name);
            if (array_key_exists($name, $this->_params)) {
                return $this->_params[$name];
            } else {
                return false;
            }
        } else {
            $this->_params;
        }
    }

    /**
     * Metodo para verificar se o modulo irá usar o layout padrão
     * @return true ou false
     */
    public function VerificarModulo() {
        if (in_array(strtolower($this->getModuleApp()), ApplicationConfig::ModulesValidos())) {
            return true;
        } else {
            return false;
        }
    }

    private function RedirectSystem() {
        if ($this->VerificarModulo()) {
            RedirectorHelper::goToModuleControllerAction($this->getModuleApp(), ApplicationConfig::ControllerErrorDefault(), ApplicationConfig::ActionErroDefault());
        } else {
            RedirectorHelper::goToControllerAction(ApplicationConfig::ControllerErrorDefault(), ApplicationConfig::ActionErroDefault());
        }
    }

    public function run() {
        if ($this->VerificarModulo()) {
            $controller_path = ApplicationPath::Module() . $this->getModuleApp() . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $this->getControllerApp() . 'Controller.php';
        } else {
            $controller_path = ApplicationPath::Application() . "Controllers" . DIRECTORY_SEPARATOR . $this->getControllerApp() . "Controller.php";
        }
        
        
        if (strtolower($this->getModuleApp()) == "public") {
            return null;
        }
        
        
        if (!file_exists($controller_path)) {
            $this->RedirectSystem();
        } else {
            require_once $controller_path;
            $class = $this->getControllerApp();
            $app = new $class;
           
        }


        try {
            $reflectionMethod = new ReflectionMethod($app, $this->getActionApp());
        } catch (exception $e) {
            $this->RedirectSystem();
        }


        // Irá testar se o methodo existe e se o mesmo é difirente de public
        if (!method_exists($app, $this->getActionApp()) || !$reflectionMethod->isPublic()) {
            $this->RedirectSystem();
        } else {

            $action = $this->getActionApp();
            $app->init();
            $app->$action();
        }
    }

}