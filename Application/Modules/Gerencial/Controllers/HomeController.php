<?php

Class Home extends Controller {

    public function Init() {
        SecurityUser::IsLogadoNewsLetter();
        parent::Init();
    }

    public function Index_Action() {
        $this->View("Index");
    }
}