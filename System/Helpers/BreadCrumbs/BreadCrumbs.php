<?php
class BreadCrumbs{
	
	private static $_bread;
	private static $ignoredActions = array("index_action","home");

	public function __construct(){
		$system = DependeceInjectionHelper::getInstance(System);
		if($system->VerificarModulo()){
			$dados = array(ApplicationPath::Root() . $system->getModule() => $system->getModule() ,
					   ApplicationPath::Root() . $system->getModule() . "/" . $system->getController() => $system->getController(),
					   ApplicationPath::Root() . $system->getModule() . "/" . $system->getController() . "/" . $system->getAction() => $system->getAction() ); 
		}else{
			$dados = array(ApplicationPath::Root() . ApplicationConfig::BreadCrumbsInit() => ApplicationConfig::BreadCrumbsInit(),
					   ApplicationPath::Root() . $system->getController() => $system->getController(),
					   ApplicationPath::Root() . $system->getController() . "/" . $system->getAction() => $system->getAction() );	
		}
		
	
		foreach (self::$ignoredActions as $v){
			$idx = array_search($v, $dados);
			if(isset($dados[$idx])) unset($dados[$idx]);
		}
		
		$i = 1;
		$quantidade = count($dados);
		
		$html = '<div><ul class="breadcrumb">';
		foreach($dados as $chave=>$valor){
			if($i < $quantidade){
				$html.= sprintf('<li><a href="%s">%s</a> <span class="divider">/</span></li>',$chave,$valor);
			}else{
				$html.= sprintf('<li class="active">%s</li>',$valor);
			}
			$i++;
		}
		$html.= "</ul></div>";
		
		self::$_bread = $html;
	}
	
	public static function getBreadCrumbs(){
		if(isset(self::$_bread)){
			return self::$_bread;
		}
	}
}