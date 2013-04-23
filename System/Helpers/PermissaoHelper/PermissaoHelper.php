<?php

class PermissaoHelper {
   

    public static function ValidarUsuario($usuario, $permissao, $controller, $action = "index", $modulo = null, $mensagem = null) {

        if (in_array($permissao, $usuario->getPermissao()->getPermissoes()))
            return true;
        
        $mensagem = $mensagem == null ? "Você não tem permissão para acessar este módulo!" : $mensagem;

        MensagemHelper::setMensagem($mensagem, MensagemHelper::ALERTA);

        if ($modulo != null)
            RedirectorHelper::goToModuleControllerAction($modulo, $controller, $action);
        else
            RedirectorHelper::goToControllerAction($controller, $action);
    }

}

?>
