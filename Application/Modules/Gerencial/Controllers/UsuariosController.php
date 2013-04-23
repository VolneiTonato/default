<?php

class Usuarios extends Controller {

    public function Init() {
        SecurityUser::IsLogadoNewsLetter();
        parent::Init();
        PermissaoHelper::ValidarUsuario(SerializacaoHelper::ObterObjetoLogado(ApplicationSecurity::SessaoUsuarioNewsletter()), Permissao::GERENCIAR_USUARIOS, "Home");
        self::$_dadosView["PERMISSOES"] = Main::CarregarPermissoes();
    }

    public function Index_Action() {
        parent::$_dadosView["USUARIOS"] = DaoFactory::UsuarioDAO()->FindAll();
        $this->View("Lista");
    }

    public function Adicionar() {
        $this->View("Formulario");
    }

    public function Editar() {
        try {
            if (!MethodHelper::isGet())
                throw new RequisicaoException("GET");

            $id = (int) $this->getParams('id');


            $usuario = DaoFactory::UsuarioDAO()->Find($id);

            if (count($usuario) == 0)
                throw new ObjetoNullException(Usuario);

            self::$_dadosView["USUARIO"] = $usuario;
        } catch (RequisicaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (PDOException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (ObjetoNullException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        }

        $this->View('Formulario');
    }

    public function AlterarSenha() {
        try {
            if (!MethodHelper::isGet())
                throw new RequisicaoException("Get");
            $id = (int) $this->getParams("id");

            $usuario = DaoFactory::UsuarioDAO()->Find($id);

            if (count($usuario) == 0)
                throw new ObjetoNullException();

            $usuario->setSenha("");
            DaoFactory::UsuarioDAO()->Save($usuario);

            RedirectorHelper::setUrlParameter('id', $usuario->getId());
        } catch (RequisicaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (ObjetoNullException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        }
        RedirectorHelper::goToModuleControllerAction($this->getModule(),$this->getController(), "Editar");
    }

    public function Salvar() {
        try {
            if (!MethodHelper::isPost())
                throw new RequisicaoException("Post");
            $msg = "incluído";



            $usuario = UtilsArrayHelper::getObjectByPost(Usuario, $_POST);

            self::$_dadosView["USUARIO"] = $usuario;

            if (count($usuario) == 0)
                throw new ObjetoNullException();

            if ($usuario->getId() > 0) {
                $user = DaoFactory::UsuarioDAO()->Find($usuario->getId());
                if ($user->getSenha() != "")
                    $usuario->setSenha($user->getSenha());
                $msg = "alterado";
            }

            $usuario->validation();

            DaoFactory::UsuarioDAO()->Save($usuario);

            $permissaoAcesso = DaoFactory::PermissaoAcessoDAO()->Find($usuario->getId());
            if (count($permissaoAcesso) == 0)
                $permissaoAcesso = new PermissaoAcesso ();

            $permissaoAcesso->setUsuario($usuario);
            $permissaoAcesso->setPermissoes(serialize(UtilitariosHelper::obterPost('permissoes')));

            DaoFactory::PermissaoAcessoDAO()->Save($permissaoAcesso);

            if ($usuario->getId() == SerializacaoHelper::ObterObjetoLogado(ApplicationSecurity::SessaoUsuarioNewsletter())->getId()) {
                $usuario->setPermissao($permissaoAcesso);
                SerializacaoHelper::AlterarDadosUsuarioLogado(ApplicationSecurity::SessaoUsuarioNewsletter(), $usuario);
            }


            MensagemHelper::setMensagem("Usuário {$msg} com sucesso!", MensagemHelper::SUCESSO);
            RedirectorHelper::goToController($this->getController());
        } catch (RequisicaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (PDOException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ERRO);
        } catch (ValidacaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ERRO);
            if ($usuario->getId() > 0)
                RedirectorHelper::setUrlParameter('id', $usuario->getId());
        } catch (ObjetoNullException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ERRO);
        }
        $this->View("Formulario");
    }

    public function Excluir() {
        try {
            if (!MethodHelper::isGet())
                throw new RequisicaoException("GET");
            DaoFactory::UsuarioDAO()->Remove((int) $this->getParams('id'));

            MensagemHelper::setMensagem("Usuário excluído com sucesso!");
        } catch (RequisicaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (PDOException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        }

        RedirectorHelper::goToModuleController($this->getModule(),$this->getController());
    }

}

?>
