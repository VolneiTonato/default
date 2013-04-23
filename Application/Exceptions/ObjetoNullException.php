<?php
class ObjetoNullException extends Exception{
	
	public function __construct($nomeObjeto){
		$this->message = "{$nomeObjeto} inválido(a)!";
	}
}