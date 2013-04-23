<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiretorioHelper
 *
 * @author Volnei
 */
class DiretorioHelper {

    const DELETAR_DIR = "deletar";
    const RENOMEAR_DIR = "renomear";
    const CRIAR_DIR = "criar";

    public static function ManipularDiretorio($path, $acao, $pathNew = null) {
        if (!is_dir($path)) {
            return false;
        }

        $lcontrole = false;
        switch ($acao) {
            case UtilitariosHelper::CRIAR_DIR:
                $lcontrole = mkdir($path, 0700);
                break;

            case UtilitariosHelper::DELETAR_DIR:
                $lcontrole = rmdir($path);
                break;

            case UtilitariosHelper::RENOMEAR_DIR:
                if ($pathNew != null && $path != $pathNew) {
                    $lcontrole = rename($path, $newname);
                }
                break;
        }
        return $lcontrole;
    }

}

?>
