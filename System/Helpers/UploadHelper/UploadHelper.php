<?php

class UploadHelper {

    private $path, $file, $fileName, $fileTmpName, $fileSize, $fileError, $fileMsgError;
    private $renomear;
    private $extensao;

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setFile($file) {
        $this->file = $file;
        $this->setFileName();
        $this->setFileTmpName();
        $this->setFileSize();
        $this->setFileError();
        return $this;
    }
    
    public function ValidarTamanho($tamanho = 2000000){
        if($this->fileSize > $tamanho){
            throw new UploadException("Arquivo ultrapassa o tamanho limite de {$tamanho}!");
        }
    }

    public function ValidarExtensao(Array $param = null) {
        $extensao = explode(".", $this->fileName);
        $this->extensao = strtolower(end($extensao));
        if (count($param) > 0) {
            if (!in_array($this->extensao, $param)) {
                $this->setError($this->ArrayErros("UPLOAD_EXTENSAO"));
            }
        }
    }

    public function RenomearArquivo($extensao = null) {

        if ($extensao != null) {
            $this->extensao = $extensao;
        }
        $this->fileName = UtilitariosHelper::CriptografarImagem($this->fileName) . ".{$this->extensao}";
    }

    protected function setFileError() {
        $this->fileError = $this->file["error"];
    }

    protected function setFileSize() {
        $this->fileSize = $this->file["size"];
    }

    protected function setFileName() {
        $this->fileName = $this->file['name'];
    }

    protected function setFileTmpName() {
        $this->fileTmpName = $this->file['tmp_name'];
    }

    public function getFile() {
        return $this->fileName;
    }

    public function upload() {
        if (move_uploaded_file($this->fileTmpName, $this->path . $this->fileName))
            return true;
        else
            throw new UploadException("Erro ao enviar o arquivo para o servidor!");
    }

    public function AlterarImagemRezise($width, $height, $tipo = 'inside', $concatenacao = "") {


        $imagem = WideImage::load($this->path . $this->getFile());
        $obj = $imagem->resize($width, $height, $tipo);
        $obj->saveToFile($this->path . $concatenacao . $this->getFile());
        $obj->destroy();
    }

    public function ExcluirImagem() {
        unlink($this->path . $this->getFile());
    }

    private function setError($msg) {
        $this->fileMsgError .= "{$msg} <br />";
    }

    public function getError() {
        return $this->fileMsgError;
    }

    private function ArrayErros($key) {
        $erros = array(UPLOAD_ERR_CANT_WRITE => 'Sem premissão no diretório!',
            UPLOAD_ERR_EXTENSION => 'Extensão inválida',
            UPLOAD_ERR_FORM_SIZE => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
            UPLOAD_ERR_INI_SIZE => 'O arquivo no upload é maior do que o limite definido no php.ini',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo selecionado!',
            UPLOAD_ERR_NO_TMP_DIR => 'Diretório temporário não exite!',
            UPLOAD_ERR_OK => 'Arquivo enviado com sucesso!',
            UPLOAD_ERR_PARTIAL => 'Envio parcial do arquivo!',
            "UPLOAD_EXTENSAO" => 'Extensão Inválida');
        return $erros[$key];
    }

    public function ValidarUploadTemporario() {

        if ($this->fileError > 0) {
            $this->setError($this->ArrayErros($this->fileError));
        }

        if ($this->getError() != "") {
            throw new UploadException(implode('<br />', $this->getError()));
        }

        return true;
    }

}

?>