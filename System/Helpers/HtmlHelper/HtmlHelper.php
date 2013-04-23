<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlHelper
 *
 * @author Volnei
 */
class HtmlHelper {

    public static function TituloDinamico() {
        $system = DependeceInjectionHelper::getInstance("System");
        if ($system->VerificarModulo())
            return "Newsletter | {$system->getModule()} | {$system->getController()} | {$system->getModule()}";
        else
            return "Newsletter | {$system->getController()} | {$system->getModule()}";
    }
    
    public static function CssTag($href , $type="text/css", $rel="stylesheet"){
        return "<link href=\"{$href}\" type=\"{$type}\"  rel=\"{$rel}\" />\n";
    }
    
    public static function JavascriptTag($src, $type="text/javascript"){
        return "<script src=\"{$src}\" type=\"{$type}\"></script>\n";
    }

}

?>
