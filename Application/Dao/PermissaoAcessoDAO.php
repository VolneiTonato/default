<?php

class PermissaoAcessoDAO extends CrudFactory {

    public function __construct() {
        parent::__construct();
        $this->setEntity("PermissaoAcesso");
    }
    
    public function Save(PermissaoAcesso $o) {
        $permissao = $this->Find($o->getUsuario()->getId());
        if (count($permissao) > 0){
            $this->setEntity("Usuario");
            $usuario = parent::getReference($o->getUsuario()->getId(), $o->getUsuario());
            $o->setUsuario($usuario);
            $this->setEntity("PermissaoAcesso");
            parent::Save(parent::getReference($o->getUsuario()->getId(), $o));            
        }else{
            parent::Save($o);
        }
    }

}

?>
