<?php

class SerializacaoHelper {

    public static function ObterObjetoLogado($sessao) {
        return unserialize(SessionHelper::SelectSession($sessao, "AUTENTICACAO_DATA"));
    }

    public static function AlterarDadosUsuarioLogado($sessao, $usuario) {
        SessionHelper::CreateSession($sessao, "AUTENTICACAO_DATA", serialize($usuario));
    }

}
