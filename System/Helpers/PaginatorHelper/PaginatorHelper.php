<?php

class PaginatorHelper {

    private $limite;
    private $offSet;
    private $total;
    private $paginaAtual;
    private $url;

    function __construct() {
        $this->setLimite();
    }

    public function getLimite() {
        return $this->limite;
    }

    public function setLimite($limite = 10) {
        $this->limite = $limite;
    }

    public function getOffSet() {
        $this->offSet = ($this->getPaginaAtual() - 1) * $this->getLimite();
        return $this->offSet;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = ceil($total / $this->getLimite());
    }

    public function getPaginaAtual() {
        return $this->paginaAtual;
    }

    public function setPaginaAtual($paginaAtual) {
        $this->paginaAtual = $paginaAtual == 0 ? 1 : $paginaAtual;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function PaginatorNumberFull() {
        $pag = array();
        for ($i = 1; $i <= $this->getTotal(); $i++) {
            $pag[] = sprintf("<a href=\"{$this->getUrl()}page/%d\">%d</a>", $i, $i);
        }
        return implode('-', $pag);
    }

    public function PaginatorByNumberParam($number = 5) {
        $pag = array();

        for ($i = 1; $i <= $this->getTotal(); $i++) {
            if ($i == 1) {
                if ($this->getPaginaAtual() == 1 || $this->getTotal() == 1) {
                    $pag[] = sprintf("primeira");
                } else {
                    $pag[] = sprintf("<a href=\"{$this->getUrl()}page/%d\">%s</a>", $i, "primeira");
                }
            }
            if ($i == $this->getPaginaAtual()) {
                $pag[] = sprintf("<a href=\"{$this->getUrl()}page/%d\">%d</a>", $i, $i);
            }

            if (($this->getPaginaAtual() - $i <= $number) && ($this->getPaginaAtual() - $i > 0)) {
                $pag[] = sprintf("<a href=\"{$this->getUrl()}page/%d\">%d</a>", $i, $i);
            }
            if (($i - $this->getPaginaAtual() <= $number) && ($i - $this->getPaginaAtual() > 0)) {
                $pag[] = sprintf("<a href=\"{$this->getUrl()}page/%d\">%d</a>", $i, $i);
            }

            if ($i == $this->getTotal() || $this->getTotal() == 1) {
                if ($this->getPaginaAtual() == $this->getTotal() && $i == $this->getTotal()) {
                    $pag[] = "última";
                } else {
                    $pag[] = sprintf("<a href=\"{$this->getUrl()}page/%d\">%s</a>", $i, "última");
                }
            }
        }
        return implode(' ', $pag);
    }

}

?>
