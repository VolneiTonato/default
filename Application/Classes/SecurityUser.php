<?php

class SecurityUser {

    private static $autenticacao;

    public static function IsLogadoNewsLetter() {
        self::$autenticacao = new AutenticacaoHelper();
        self::$autenticacao->setSessao(ApplicationSecurity::SessaoUsuarioNewsletter())
                ->setLoginModuleControllerAction("Gerencial", "Home", "Index")
                ->setErrorModuleControllerAction("Gerencial", "Autenticacao", "Index")
                ->checkLogin(AutenticacaoHelper::AUTH_REDIRECT);
    }

}
