<?php
class LoginException extends RuntimeException{
	public function __construct(){
		$this->message = "Usuário ou senha inválido!";
	}
}