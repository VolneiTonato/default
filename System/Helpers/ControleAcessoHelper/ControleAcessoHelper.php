<?php
class ControleAcessoHelper{
	const TEMPO_PROXIMO_LOGIN = "TEMPO_PROXIMO_LOGIN";
	const TEMPO_PROXIMA_RECUPERACAO_SENHA = "TEMPO_PROXIMA_RECUPERACAO_SENHA";
	const TEMPO_PROXIMO_ALTERACAO_CADASTRO = "TEMPO_PROXIMO_ALTERACAO_CADASTRO";
	
	public static function VerificarQuantidadeAcesso($constante , $minuto = 1, $tentativas = 3){
		$ip = $_SERVER["REMOTE_ADDR"];
		
		if(in_array($ip, unserialize(APP_IPS_BLOQUEADOS)))throw new Exception("Ip temporiariamente bloqueado! <br /> Entre em contato pelo email : volnei@hos.com.br");

		if(isset($_SESSION[APP_SESSAO_CONTROLE_ACESSO][$constante])){
			if(self::TempoRestante($constante) > 0)		return false;
		}
		if(isset($_SESSION[APP_SESSAO_CONTROLE_ACESSO]["IP_CONTROLE_ACESSO_{$constante}"])){
			if($_SESSION[APP_SESSAO_CONTROLE_ACESSO]["QUANTIDADE_ACESSO_{$constante}"] == $tentativas){			
				$_SESSION[APP_SESSAO_CONTROLE_ACESSO][$constante] =  time() + (60 * $minuto);
				UtilitariosHelper::EnviarEmailErro("Mensagem: O ip {$ip} está fazendo várias tentativas para acesso!" );
				return false;
			}else{
				$_SESSION[APP_SESSAO_CONTROLE_ACESSO]["QUANTIDADE_ACESSO_{$constante}"] += 1;
			}
		}else{
			$_SESSION[APP_SESSAO_CONTROLE_ACESSO]["IP_CONTROLE_ACESSO_{$constante}"] = $ip;
			$_SESSION[APP_SESSAO_CONTROLE_ACESSO]["QUANTIDADE_ACESSO_{$constante}"] = 1;
		}
		return true;
	}
	
	
	public static function TempoRestante($constante){
		if(time() < $_SESSION[APP_SESSAO_CONTROLE_ACESSO][$constante]){
			return  ($_SESSION[APP_SESSAO_CONTROLE_ACESSO][$constante]) - time();
		}
		self::ExcluirTentativasLogin();
		return 0;
				
	}
	
	public static function toString($constante){
		return self::TempoRestante($constante) <= 60 ? self::TempoRestante($constante) . " segundo(s)" : date('i',self::TempoRestante($constante)) . " minuto(s)";
	}
	
	public static function ExcluirTentativasLogin($constante = null){
		if ($constante == null){
			unset($_SESSION[APP_SESSAO_CONTROLE_ACESSO]);
		}else{
			unset($_SESSION[APP_SESSAO_CONTROLE_ACESSO][$constante]);
			unset($_SESSION[APP_SESSAO_CONTROLE_ACESSO]["IP_CONTROLE_ACESSO_{$constante}"]);
			unset($_SESSION[APP_SESSAO_CONTROLE_ACESSO]["QUANTIDADE_ACESSO_{$constante}"]);
		}
		
		
	}
}