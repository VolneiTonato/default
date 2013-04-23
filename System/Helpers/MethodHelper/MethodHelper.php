<?php
class MethodHelper{
	
	public static function isPost(){
		return $_SERVER["REQUEST_METHOD"] === "POST";
	}
	
	public static function isGet(){
		return $_SERVER["REQUEST_METHOD"] === "GET";
	}
	
	public static function isAjax(){
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}