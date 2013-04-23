<?php

class Main {

    private static $_sessao;

    public static function Init() {
        self::CarregarPermissoes();
    }

    public static function CarregarPermissoes() {
        try {
            self::$_sessao = "PERMISSOES_MAIN";
            if (!SessionHelper::CheckSession(self::$_sessao)) {
//                $permissoes = DaoFactory::PermissaoDAO()->FindAll();
                SessionHelper::CreateSession(self::$_sessao, null, serialize($permissoes));
            }
            return unserialize(SessionHelper::SelectSession(self::$_sessao));
        } catch (Exception $e) {
            UtilitariosHelper::getLayoutErrorInicial($e->getMessage());
        }
    }

    public static function DestruirSessoes() {
        SessionHelper::DeleteSession("PERMISSOES_MAIN");
    }

}

?>
