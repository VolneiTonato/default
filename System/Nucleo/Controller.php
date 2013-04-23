<?php

class Controller extends System {

    protected static $_dadosView = array();
    private static $_content = null;
    private static $_contentExtras = array();

    const CONST_NAV_LAYOUT = "CONST_NAV_LAYOUT";
    const CONST_BANNER_LAYOUT = "CONST_BANNER_LAYOUT";
    const CONST_SLIDES_LAYOUT = "CONST_SLIDES_LAYOUT";

    private function DefinirLayout() {
        if ($this->VerificarModulo()) {
            $layout = ApplicationPath::Module() . $this->CorrigirUrl($this->getModule()) . '/Layouts/Scripts/';
        } else {
            $layout = ApplicationPath::Application() . 'Layouts/Scripts/';
        }
        return $layout;
    }

    private function DefinirView() {

        if ($this->VerificarModulo()) {
            $view = ApplicationPath::Module() . $this->CorrigirUrl($this->getModule()) . '/Views/' . $this->CorrigirUrl($this->getController()) . '/';
        } else {
            $view = ApplicationPath::Application() . 'Views/' . $this->CorrigirUrl($this->getController()) . '/';
        }
        return $view;
    }

    public function DefinirCharSet($charset = "utf-8") {
        header("Content-Type: text/html;  charset={$charset}", true);
    }

    private function ValidarArquivo($file, $dir) {
        if (file_exists("{$dir}{$file}.phtml")) {
            return true;
        } else {
            return false;
        }
    }

    private function RetornarPathFile($file, $dir) {
        if ($this->ValidarArquivo($file, $dir)) {
            return "{$dir}{$file}.phtml";
        } else {
            UtilitariosHelper::getLayoutErrorInicial("Layout {$dir}{$file}.phtml não encontrado!<br />Contactar o desenvolvedor!");
        }
    }

    private function ObterConteudo($file) {
        return $this->RetornarPathFile($file, $this->DefinirLayout());
    }

    private function ObterConteudoBanner($file) {
        return $this->RetornarPathFile($file, $this->DefinirLayout() . 'Banners/');
    }

    private function ObterConteudoSlides($file) {
        return $this->RetornarPathFile($file, $this->DefinirLayout() . 'Slides/');
    }

    private function ObterLayout($file = null) {
        if ($file != null) {
            $file = parent::CorrigirUrl($file);
        } else {
            $file = "Layout";
        }

        return $this->RetornarPathFile($file, $this->DefinirLayout());
    }

    private function ObterView($file) {
        $file = parent::CorrigirUrl($file);
        return $this->RetornarPathFile($file, $this->DefinirView());
    }

    private function IsAjax($ajax = false) {
        if ($ajax) {
            $this->DefinirCharSet();
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param $view -> Nome da view do controller
     * @param $layout -> Array associativo. A key é o modulo e o valor o layout
     * @param $conteudoExtra = um array com as constantes de conteudo extrada do controoler
     * @param $ajax -> se true retorna apenas o conteudo da view
     */
    public function View($view = null, $layout = null, Array $conteudoExtra = array(), $ajax = false) {

        extract(self::$_dadosView, EXTR_PREFIX_ALL, 'VIEW');

        self::$_content = $this->ObterView($view);
        //self::$_contentExtras[Controller::CONST_NAV_LAYOUT] = $this->ob($conteudoExtra[Controller::CONST_NAV_LAYOUT]);
        //self::$_contentExtras[Controller::CONST_BANNER_LAYOUT] = $this->ObterConteudoBanner($conteudoExtra[Controller::CONST_BANNER_LAYOUT]);

        if ($this->IsAjax($ajax) && self::$_content != null) {
            require(self::$_content);
            return true;
        }
        require($this->ObterLayout($layout));
    }

    public static function Banner() {
        if (isset(self::$_contentExtras[Controller::CONST_BANNER_LAYOUT])) {
            extract(self::$_dadosView, EXTR_PREFIX_ALL, 'VIEW');
            require(self::$_contentExtras[Controller::CONST_BANNER_LAYOUT]);
        }
    }

    public static function Menu() {
        if (isset(self::$_contentExtras[Controller::CONST_NAV_LAYOUT])) {
            extract(self::$_dadosView, EXTR_PREFIX_ALL, 'VIEW');
            require(self::$_contentExtras[Controller::CONST_NAV_LAYOUT]);
        }
    }

    public static function Content() {
        if (isset(self::$_content)) {
            extract(self::$_dadosView, EXTR_PREFIX_ALL, 'VIEW');
            require(self::$_content);
        }
    }

    public function Init() {
        new BreadCrumbs();
        self::$_dadosView['CONTROLLER'] = $this->getController();
        self::$_dadosView['ACTION'] = $this->getAction();
        self::$_dadosView['MODULE'] = $this->getModule();
        self::$_dadosView['HTML_TITULO_PAGINA'] = HtmlHelper::TituloDinamico();
        Main::Init();
    }

}

?>