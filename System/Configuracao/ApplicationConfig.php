<?php
class ApplicationConfig{
	
	public static function ModuleDefault(){
		return "";
	}
	
	public static function ControllerDefault(){
		return "Home";
	}
	
	public static function ActionDefault(){
		return "Index_Action";
	}
	
	public static function ModulesValidos(){
		return array('gerencial');
	}
	
	public static function ControllerErrorDefault(){
		return "Erro";
	}
	
	public static function ActionErroDefault(){
		return "Pagina";
	}
	
	public static function BreadCrumbsInit(){
		return "Home";
	}
}