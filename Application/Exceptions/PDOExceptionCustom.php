<?php

class PDOExceptionCustom extends Exception {
    
    public function __construct(PDOException $e) {
        $this->setErro($e);
    }
    
    private function getErros($codigo = 0){
        $erros = array(
            '23000' => "Não é possível inserir valores duplicados para campo unico!",
            '42S22' => "Não foi possível encontrar um campo na base de dados!"
        );
        if(isset($erros[$codigo])){
            return $erros[$codigo];
        }
        return null;
    }

    private function setErro(PDOException $e) {
        $msg = $this->getErros($e->getCode());
        
        if($msg == ""){
            $this->message = $e->getMessage();
        }else{
            $this->message = $msg;
        }
    }
}

?>
