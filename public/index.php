<?php

/**
 * 
 */

set_time_limit(60 * 30);

session_start();


require("../" . DIRECTORY_SEPARATOR . "System" . DIRECTORY_SEPARATOR . "Configuracao" . DIRECTORY_SEPARATOR . "ApplicationPath.php");
require("../" . DIRECTORY_SEPARATOR . "System" . DIRECTORY_SEPARATOR . "Configuracao" . DIRECTORY_SEPARATOR . "Bootstrap.php");

UtilitariosHelper::setIniPHP();



$start = new System();
$start->run();