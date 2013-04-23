<?php

require_once(ApplicationPath::Libraries() . 'DoctrineORM/libraries/Doctrine.php');

abstract class DoctrineFactory extends Doctrine {

    public function __construct() {
        parent::__construct();
    }
    
}

?>
