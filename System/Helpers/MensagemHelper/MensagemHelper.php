<?php
class MensagemHelper{
	const ERRO = "alert-error";
	const INFORMACAO = "alert-info";
	const SUCESSO = "alert-success";
	const ALERTA = "";
	
	public static function setMensagem($mensagem, $tipo = MensagemHelper::SUCESSO){
		$html = "<div class=\"mensagem-interface alert {$tipo}\">";
		//$html.= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
        $html.= "<h4>{$mensagem}</h4>";
        $html.= "</div>";

		$_SESSION["MENSAGEM_CLASS_MENSAGEM_HELPER"] = $html;
	}
	
	public static function getMensagem(){
		if(isset($_SESSION["MENSAGEM_CLASS_MENSAGEM_HELPER"])){
			$aux = $_SESSION["MENSAGEM_CLASS_MENSAGEM_HELPER"];
			unset($_SESSION["MENSAGEM_CLASS_MENSAGEM_HELPER"]);
			return $aux;
		}
		return null;		
	}
}