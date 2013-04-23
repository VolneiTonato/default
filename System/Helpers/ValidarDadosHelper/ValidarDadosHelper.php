<?php

class ValidarDadosHelper {

    private $dados;
    private $erros = array();

    public function set($valor, $campo) {
        $this->dados = array("Valor" => $valor, "Campo" => $campo);
        return $this;
    }

    public function Obrigatorio() {
        if (trim($this->dados["Valor"]) == "") {
            $this->erros[] = sprintf("O campo %s é Obrigatório", $this->dados["Campo"]);
        }
        return $this;
    }

    public function ValidarInteiro($min_range = null, $max_range = null) {
        $option = array();
        $string = null;
        if ($min_range != null) {
            $option['option']['min_range'] = $min_range;
            $string .= " maior que {$min_range} ";
        }
        if ($max_range != null) {
            $option['option']['max_range'] = $max_range;
            $string .= " menor que {$max_range} ";
        }
        if (!filter_var($this->dados["Valor"], FILTER_VALIDATE_INT, $option)) {
            $this->erros[] = sprintf("O campo %s só aceita números inteiros {$string}", $this->dados["Campo"]);
        }
        return $this;
    }

    public function ValidarUrl() {
        if (!filter_var($this->dados['Valor'], FILTER_VALIDATE_URL)) {
            $this->erros[] = sprintf("O campo %s só aceita uma url válida", $this->dados["Campo"]);
        }
        return $this;
    }

    public function ValidarEmail() {
        if (!filter_var($this->dados['Valor'], FILTER_VALIDATE_EMAIL)) {
            $this->erros[] = sprintf("O campo %s só aceita um e-mail válido", $this->dados["Campo"]);
        }
        return $this;
    }

    public function setErro($erro) {
        $this->erros[] = $erro;
    }

    public function ValidarData() {
        //99-99-9999
        if (!preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $this->dados['Valor'])) {
            $this->erros[] = sprintf("O campo %s só aceita no formato 99/99/9999", $this->dados["Campo"]);
        }
        return $this;
    }

    public function ValidarTelefone() {
        //(99)9999-9999
        if (!preg_match("/^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$/", $this->dados['Valor'])) {
            $this->erros[] = sprintf("O campo %s só aceita no formato (99)9999-9999", $this->dados["Campo"]);
        }
        return $this;
    }

    public function Validar() {
        if (count($this->erros) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getErros() {
        return $this->erros;
    }

}

?>