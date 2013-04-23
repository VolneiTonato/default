<?php

class PermissaoDAO extends CrudFactory {
    
    public function __construct() {
        parent::__construct();
        $this->setEntity("Permissao");
    }
    
    public function FindBy($id) {
        parent::FindBy(array('id' => $id));
    }

}

?>
