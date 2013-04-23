<?php

/**
 * 
 * Classe para definir os paths da aplicação
 * @author Volnei
 *
 */
class ApplicationPath{
	
	/**
	 * 
	 * Define o diretório root
	 */
	public static function Root(){
		return "/";
	}
        
        private static function DiretorioReal(){
            return "../";
        }
	
	/**
	 * 
	 * Define o diretório aonde ficará a application
	 */
	public static function Application(){
		return self::DiretorioReal() . "Application/";
	}
	
	/**
	 * 
	 * Diretorio para gravação de logs
	 */
	public static function Log(){
		return self::Application() . "Logs/";
	}
	
	/**
	 * 
	 * Diretório para as exceptions da aplicação
	 */
	public static function Exception(){
		return self::Application() . "Exceptions/";
	}
	
	/**
	 * 
	 * Diretório para acesso aos dados DAO
	 */
	public static function DAO(){
		return self::Application() . "Dao/";  
	}
	
	/**
	 * 
	 * Diretório para as regras de negócio
	 */
	public static function Models(){
		return self::Application() . "Models/";
	}
	
	/**
	 * 
	 * Diretório para os módulos da aplicação
	 */
	public static function Module(){
		return self::Application() . "Modules/";
	}
	
	/**
	 * 
	 * Diretório dos helpers (Funções auxiliares)
	 */
	public static function HelpersPublic(){
		return self::System() . "Helpers/";
	}
	
	/**
	 * 
	 * Diretório para classes referente a aplicação
	 */
	public static function Classes(){
		return self::Application() . "Classes/";
	}
	
	/**
	 * 
	 * Diretório de configurações do sistema
	 */
	public static function  Configuracao(){
		return self::System() . "Configuracao/";
	}
	
	/**
	 * 
	 * Diretório para acesso ao systema do sistema
	 */
	private static function System(){
		return self::DiretorioReal() . "System/";
	}
	
	/**
	 * 
	 * Diretório para acesso direto ao public imagens
	 */
	public static function Imagens(){
		return self::Root() . "Images/";
	}
	
	/**
	 * 
	 * Diretório para acesso direto ao public scripts
	 */
	public static function Scripts(){
		return self::Root() . "Scripts/";
	}
	
	/**
	 * 
	 * Diretório para acesso direto ao public library
	 */
	public static function ScriptsLibrary(){
		return self::Root() . "Library/";
	}
	
	/**
	 * 
	 * Diretório para acesso direto ao public estilos
	 */
	public static function Estilos(){
		return self::Root() . "Estilos/";
	}
	
	/**
	 * 
	 * Diretório para acesso os dados. 
	 * Rere-se as funções de query e conexão
	 */
	public static function AcessaDados(){
		return self::System() . "AcessaDados/";
	}
	
	
        
        public static function Libraries(){
            return self::DiretorioReal() . "Libraries/";
        }
	
	/**
	 * 
	 * Diretório para acesso ao núcleo do sistema
	 * Essa parte é para manipular a url
	 * e geriamento de acesso aos módules - controllers e actions
	 * 
	 */
	public static function Nucleo(){
		return self::System() . "Nucleo/"; 
	}
        
        public static function DiretorioImagensProdutos(){
            return "Images/Site/produtos/";
        }
        
        public static function BaseSite(){
            return "http://site-volneitonato.rhcloud.com/";
        }
}


