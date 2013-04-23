<?php

require_once ('phpMailer/class.phpmailer.php');

class MailHelper {

    private $para;
    private $de;
    private $assunto;
    private $conteudo;
    private $deNome;
    private $paraNome;
    private $anexo;
    private $wraper;

    public function setPara($para) {
        $this->para = $para;
    }

    public function getPara() {
        return $this->para;
    }

    public function setDe($de) {
        $this->de = $de;
    }

    public function getDe() {
        return $this->de;
    }

    public function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

    public function getAssunto() {
        return $this->assunto;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function setDeNome($deNome) {
        $this->deNome = $deNome;
    }

    public function getDeNome() {
        return $this->deNome;
    }

    public function setParaNome($paraNome) {
        $this->paraNome = $paraNome;
    }

    public function getParaNome() {
        return $this->paraNome;
    }

    public function setAnexo(Array $anexos) {
        $this->anexo = $anexos;
    }

    public function getAnexo() {
        return $this->anexo;
    }

    public function setWraper($wraper = 50) {
        $this->wraper = $wraper;
    }

    public function getWraper() {
        return $this->wraper;
    }

    public function EnviarEmail() {
        try {
            $mail = new PHPMailer();  #estancia a classe para a variavel  mail
            $mail->IsHTML(true);  #Se true o texto é em html caso false é em texto plano
            $mail->EncodeString("UTF-8");
            $mail->IsSMTP();     #Chama a funcao isSMTP - conexão em SMPT
            $mail->SMTPAuth = true; #Caso o smtp precise de autenticação então a opção é true
            $mail->Mailer = "smtp";  #smtp ou mail - smpt padrão
            $mail->Port = 25;   #Porta do GMAIL, o padrão é 25
            $mail->Host = "" //Host;
            $mail->Username = "";  #Usuario + dominio
            $mail->Password = ""; # senha

            $mail->From = $this->getDe(); #Quem esta enviado o e-mail
            $mail->FromName = $this->getDeNome(); #Nome da pessoa antes do email dele opcional
            $mail->WordWrap = $this->wraper;

            if (!$mail->ValidateAddress($this->getDe())) {
                throw new Exception("Email inválido!");
            }
            if (empty($this->conteudo))
                return true;

            $mail->AddAddress($this->getPara(), $this->getParaNome()); //Para quem será enviado 

            if (count($this->getAnexo()) > 0) {
                foreach ($this->getAnexo() as $anexo) {
                    $mail->AddAttachment($anexo);
                }
            }

            $mail->Body = $this->getConteudo();
            $mail->AltBody = $this->getConteudo();


            $mail->Subject = $this->getAssunto();  # assunto

            if (!$mail->Send()) {
                throw new Exception("Erro ao enviar email");
            }
            unset($mail);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } catch (phpmailerException $e){
            throw new Exception($e->getMessage());
        }
    }

}

?>