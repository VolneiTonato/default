<?php
class ValidacaoException extends Exception{
	
	public function __construct($mensagem){
		$this->message = $mensagem;
	}
}