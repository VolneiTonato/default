<?php

Class Home extends Controller {

    public function Init() {
        parent::Init();
    }

    public function Index_Action() {
        $this->View("Index");
    }
}