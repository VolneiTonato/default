<?php

Class Erro extends Controller {

    public function Init() {
        parent::Init();
    }

    public function Pagina() {
        $this->View('Erro', 'layout-erro');
    }

}