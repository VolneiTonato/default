<?php

class UsuarioDAO extends CrudFactory {

    public function __construct() {
        parent::__construct();
        $this->setEntity("Usuario");
    }

    public function Save(Usuario $o) {
        if ($o->getId() > 0) {
            return parent::Save(parent::getReference($o->getId(), $o));
        }
        return parent::Save($o);
    }

    public function ObterUsuarioPorLoginSenha(Array $dados) {
        $arr = array_merge($dados, array("status" => 1));
        return parent::FindBy($arr);
    }

}

?>
