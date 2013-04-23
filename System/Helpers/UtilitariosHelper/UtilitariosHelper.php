<?php

class UtilitariosHelper {

    public static function obterPost($post = null) {
        return isset($_POST[$post]) ? $_POST[$post] : null;
    }

    public static function obterGet($get = null) {
        return isset($_GET[$get]) ? $_GET[$get] : null;
    }
	
	public static function obterFiles($file = null) {
        return isset($_FILES[$file]) ? $_FILES[$file] : null;
    }

    public static function CriptografarSenha($senha) {
        $vSenha = str_split($senha, 2);
        $nCount = count($vSenha);
        $vSalt = str_split(STRING_SENHA, $nCount);
        $vNovaString = null;
        for ($i = 0; $i < $nCount; $i++) {
            $vNovaString .= $vSenha[$i] . $vSalt[$i];
        }
        return md5($vNovaString . STRING_SENHA);
    }

    public static function QuebrarLinhaArquivo() {
        return chr(13) . chr(10);
    }

    /**
     * 
     * Metodo para excluir imagem
     * @param string $imagem : O caminho completo da imagem
     */
    public static function ExcluirImagem($imagem) {
        if (is_file($imagem)) {
            unlink($imagem);
        }
    }

    /**
     * 
     * Função necessária para pesquisa no banco Firebird, aonde é necessário a conversão de UTF8 para ANSI
     * @param string $string
     */
    public static function ConverterUtf8ToAnsi($string) {
        return iconv("UTF-8", "WINDOWS-1252", $string);
    }

    public static function FiltrarLetras($valor) {
        $aux = null;
        for ($i = 0; $i < strlen($valor); $i++) {
            $letra = strtolower(substr($valor, $i, 1));
            for ($j = 97; $j <= 122; $j++) {
                if ($letra == chr($j)) {
                    $aux .= $letra;
                }
            }
        }
        return $aux;
    }

    public static function setIniPHP() {
        date_default_timezone_set("America/Sao_Paulo");

        $config = array('display_errors' => 1,
            'error_reporting' => E_ALL ^ E_NOTICE,
            'memory_limit' => '500M',
            'register_globals' => 'off',
            'default_charset' => 'utf-8',
            'upload_max_filesize' => '3M',
            'asp_tags' => 'off',
            'short_open_tag' => 'off',
            'session.gc_divisor' => '1000');

        foreach ($config as $key => $value) {
            ini_set("{$key}", $value);
        }
    }

    public static function getLayoutErrorInicial($erro) {
        $html = "<center>\n\r<h1>$erro</h1></center>";
        echo $html;
        exit();
    }

}
