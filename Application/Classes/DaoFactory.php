<?php


class DaoFactory {
    
    public static function UsuarioDAO(){
        return new UsuarioDAO();
    }
    
    public static function PermissaoDAO(){        
        return new PermissaoDAO();
    }
    
    public static function PermissaoAcessoDAO(){
        return new PermissaoAcessoDAO();
    }
    
    
    
}

?>
