<?php

class AutenticacaoHelper {

    protected $loginModule;
    protected $sessao = array();
    protected $cookie = null;
    protected $loginController;
    protected $loginAction;
    protected $logoutModule;
    protected $logoutController;
    protected $logoutAction;
    protected $errorController, $errorModule, $errorAction;
    private $isModulo = false;

    const AUTH_BOOLEAN = "boolean";
    const AUTH_REDIRECT = "redirect";
    const AUTH_STOP = "stop";

    public function __construct() {
        $this->loginController = ApplicationConfig::ControllerDefault();
        $this->loginAction = ApplicationConfig::ActionDefault();
        $this->loginModule = ApplicationConfig::ModuleDefault();
        $this->logoutController = ApplicationConfig::ControllerDefault();
        $this->logoutAction = ApplicationConfig::ActionDefault();
        $this->logoutModule = ApplicationConfig::ModuleDefault();
        $this->errorAction = ApplicationConfig::ActionDefault();
        $this->errorController = ApplicationConfig::ControllerDefault();
        $this->errorModule = ApplicationConfig::ModuleDefault();
        $sys = DependeceInjectionHelper::getInstance("System");
        if ($sys->VerificarModulo()) {
            $this->isModulo = true;
        }
    }

    public function setSessao($sessao) {
        $this->sessao[] = $sessao;
        return $this;
    }

    public function setCookie($name) {
        $this->cookie = $name;
        return $this;
    }

    private function getCookie() {
        return $this->cookie;
    }

    public function setErrorModuleControllerAction($module = null, $controller, $action) {
        $this->errorController = $controller;
        $this->errorModule = $module;
        $this->errorAction = $action;
        return $this;
    }

    public function setLoginModuleControllerAction($module = null, $controller, $action) {
        $this->loginController = $controller;
        $this->loginModule = $module;
        $this->loginAction = $action;
        return $this;
    }

    public function setLogoutModuleControllerAction($module = null, $controller, $action) {
        $this->logoutController = $controller;
        $this->logoutAction = $action;
        $this->logoutModule = $module;
        return $this;
    }

    protected function createSessaoByCookie($obj) {
        SessionHelper::CreateSession($this->sessao[0], "AUTENTICACAO", true);
        SessionHelper::CreateSession($this->sessao[0], "AUTENTICACAO_DATA", serialize($obj));
    }

    public function Login($obj = null, $criarCookie = false) {

        if ($obj != null) {
            foreach ($this->sessao as $sessao):
                SessionHelper::CreateSession($sessao, "AUTENTICACAO", true);
                SessionHelper::CreateSession($sessao, "AUTENTICACAO_DATA", serialize($obj));
                if ($criarCookie == true)
                    CookieHelper::CreateCookie($this->getCookie(), serialize($obj), 60 * 24 * 5); //cria um cookie para 5 dias
            endforeach;
        }else {
            if ($this->isModulo) {
                RedirectorHelper::goToModuleControllerAction($this->errorModule, $this->errorController, $this->errorAction);
            } else {
                RedirectorHelper::goToControllerAction($this->errorController, $this->errorAction);
            }
        }

        if ($this->isModulo) {
            RedirectorHelper::goToModuleController($this->loginModule, $this->loginController);
        } else {
            RedirectorHelper::goToController($this->loginController);
        }
        return $this;
    }

    public function Logout() {
        foreach ($this->sessao as $sessao):
            SessionHelper::DeleteSession($sessao, "AUTENTICACAO");
            SessionHelper::DeleteSession($sessao, "AUTENTICACAO_DATA");
        endforeach;
        if ($this->getCookie() != "")
            CookieHelper::DeleteCookie($this->getCookie());

        if ($this->isModulo) {
            RedirectorHelper::goToModuleControllerAction($this->logoutModule, $this->logoutController, $this->logoutAction);
        } else {
            RedirectorHelper::goToControllerAction($this->logoutController, $this->logoutAction);
        }
    }

    //Uma unica sessão apenas deve ser passada
    public function checkLogin($acao) {

        switch ($acao) {
            case AutenticacaoHelper::AUTH_BOOLEAN:
                return SessionHelper::CheckSession($this->sessao[0], "AUTENTICACAO");
                break;
            case AutenticacaoHelper::AUTH_REDIRECT:

                if (CookieHelper::CheckCookie($this->getCookie())) {
                    $this->createSessaoByCookie(unserialize(CookieHelper::SelectCookie($this->getCookie())));
                }
                if (!SessionHelper::CheckSession($this->sessao[0], "AUTENTICACAO")) {
                    if ($this->isModulo) {
                        RedirectorHelper::goToModuleControllerAction($this->errorModule, $this->errorController, $this->errorAction);
                    } else {
                        RedirectorHelper::goToControllerAction($this->errorController, $this->errorAction);
                    }
                }
                break;
            case AutenticacaoHelper::AUTH_STOP:
                if (!SessionHelper::CheckSession($this->sessao[0], "AUTENTICACAO"))
                    exit();
                break;
        }
    }

    private function __desctruction() {
        unset($this);
    }

}

?>