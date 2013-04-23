<?php

class EntityFacotory {

    public static function Usuario() {
        return new Usuario();
    }


    public static function Permissao() {
        return new Permissao();
    }

    public static function PermissaoAcesso() {
        return new PermissaoAcesso();
    }

                

}

?>
