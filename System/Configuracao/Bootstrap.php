<?php

ini_set("error_reporting", E_ALL ^ E_NOTICE);

spl_autoload_register('AutoLoaderFrameWorkMVC');

function AutoLoaderFrameWorkMVC($file) {
    IncluirArquivoBootsTrap($file);
}

function IncluirArquivoBootsTrap($arquivo) {
   
    
    $paths = array(
        ApplicationPath::Configuracao(),
        ApplicationPath::Nucleo(),
        ApplicationPath::Classes(),
        ApplicationPath::DAO(),
        ApplicationPath::Models(),
        ApplicationPath::Module(),
        ApplicationPath::AcessaDados(),
        ApplicationPath::Exception(),
        ApplicationPath::HelpersPublic() . $arquivo . "/",
        ApplicationPath::Models() . "Entities/",
        ApplicationPath::Models() . "Proxies/");

    $arquivo = $arquivo . '.php';

    foreach ($paths as $path) {
        
        if (is_file($path . $arquivo)) {
            require($path . $arquivo);
            break;
        }
    }
}

