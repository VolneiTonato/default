<?php

Class LogHelper {
	private static $_diretorio;
	private static $_arquivo;
	private static $_resourse;
	private static $linha, $erro, $file;
	
	private static function Initialize(){
		self::getDiretorio();
		self::getNomeArquivo();
	}
	
	public static function LogSql($conteudo){
		self::Initialize();
		self::$_diretorio .= "SQL/";
		self::AbrirArquivo();
		self::gravarConteudo($conteudo);
	}
	
	private static function gerarLayout(){
		$dados = "\n\r--------------------------------------\n\r";
		$dados .= "Data: " . date("d/m/Y") . "\n\r";
		$dados .= "Hora: " . date("h:i:s") . "\n\r";
		$dados .= "Arquivo: " . self::$file . "\n\r";
		$dados .= "Linha: " . self::$linha . "\n\r";
		$dados .= "Erro: " . self::$erro . "\n\r";
		$dados .= "-------------------------------------\n\r";
		return $dados;
	}
	
	public static function ErroApp($erro , $file = null, $linha = null){
		self::$erro = $erro;
		self::$file = $file;
		self::$linha = $linha;
		self::Initialize();
		self::$_diretorio .= "ERROS_APP/";
		self::AbrirArquivo();
		self::gravarConteudo(self::gerarLayout());
	}
	
	private static function AbrirArquivo(){
		self::$_resourse = fopen(self::$_diretorio . self::$_arquivo, "a+");
	}
	
	private static function getDiretorio(){
		self::$_diretorio = ApplicationPath::Log();
	}
	
	private static function getNomeArquivo(){
		self::$_arquivo = date("d-m-Y") . '.log';
	}
	
	private static function gravarConteudo($conteudo){
		fwrite(self::$_resourse, $conteudo);
	}
}

?>

