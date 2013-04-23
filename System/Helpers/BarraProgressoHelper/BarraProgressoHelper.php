<?php

class BarraProgressoHelper{
	private static $_increment = 1;
	public static $_total;
	public static $_closeBar = false;
	
	public static function BarraProgresso(){
		self::$_increment++;
		print "<script>BarraProgresso(" . self::$_increment ."," . self::$_total .");</script>";
		if(self::$_increment == self::$_total){
			sleep(2);
			self::BarraProgressoClose();
		}
	}
	
	public static function BarraProgressoClose(){
		return print "<script>BarraProgressoClose();</script>";
	}
	
	public static function BarraProgressoPesquisar($mensagem = "aguarde"){
		return print "<script>BarraProgressoPesquisa('{$mensagem}');</script>";
	}

}