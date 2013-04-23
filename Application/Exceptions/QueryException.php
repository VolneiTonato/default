<?php
class QueryException extends Exception{
	const CONSULTA = "consultar";
	const INSERT = "inserir";
	const DELETE = "deletar";
	const UPDATE = "alterar";
	
	public function __construct($opcao = QueryException::CONSULTA){
		$this->message = "Erro ao {$opcao} no banco de dados";
	}
}