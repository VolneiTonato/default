<?php
class RequisicaoException extends Exception{
	private $requisicaoEsperada;
	
	public function __construct($requisicao){
		$this->setRequisicaoEsperada($requisicao);
		$this->message = "Requisição inválida!";
	}
	
	
	public function setRequisicaoEsperada($requisicao){
		$this->requisicaoEsperada = ucfirst($requisicao);
	}
	
	public function getRequisicaoEsperadao(){
		return $this->requisicaoEsperada;
	}
}