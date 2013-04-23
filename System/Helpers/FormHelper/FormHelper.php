<?php

class FormHelper {
    
    public function __construct(Array $param) {
        echo "<form {$this->getDadosForm($param)} />";
    }
    
    private function getDadosForm(Array $param){
        $aux = null;
        foreach($param as $key=>$value){
            $aux .= " {$key}=\"{$value}\" ";
        }
        return $aux;
    }
    
    public function Input(Array $param){
        echo "<input {$this->getDadosForm($param)} />";
    }
    
    public function Label($for, $titulo, Array $param){
        echo "<label for={$for}>{$titulo}</label>";
    }
    
    public function TextArea(Array $param, $valor = null){
        echo "<textarea {$this->getDadosForm($param)}>{$valor}</textarea>";        
    }
    
    public function Select(Array $param, Array $options, $valueSelected = null){
        $s = "<select {$this->getDadosForm($param)} >\n";
        foreach($options as $key=>$value){
            $s.= "\t<option ";
            if(strtolower($key) == strtolower($valueSelected)) $s .= " selected=\"selected\" ";
            $s.= ">{$value}</option>\n";
        }
        $s.= "</select>";
        echo $s;
    }
    
    public function __destruct() {
        echo "</form>";
    }
}

?>
