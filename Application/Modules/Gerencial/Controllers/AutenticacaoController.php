<?php

class Autenticacao extends Controller {

    public function Init() {
        parent::Init();
    }

    public function Index_Action() {
        if (count($_SESSION[ApplicationSecurity::SessaoUsuarioNewsletter()]) > 0)
            RedirectorHelper::goToModuleController($this->getModule(),"Home");
        $this->View("Index", "Login");
    }

    public function Sair() {
        Main::DestruirSessoes();
        $autenticacao = new AutenticacaoHelper();
        $autenticacao->setLogoutModuleControllerAction($this->getModule(), 'Autenticacao', 'Index')
                ->setSessao(ApplicationSecurity::SessaoUsuarioNewsletter())
                ->Logout();
    }

    public function Logar() {
        try {
            if (!MethodHelper::isPost())
                throw new RequisicaoException("Post");

            $usuario = DaoFactory::UsuarioDAO()
                    ->ObterUsuarioPorLoginSenha(UtilsArrayHelper::getArrayClassByPost(Usuario, $_POST));

            if (count($usuario) > 0) {
                $usuario = DependeceInjectionHelper::getObjectToArray($usuario, Usuario);

                PermissaoHelper::ValidarUsuario($usuario, Permissao::ENTRAR_NO_SISTEMA, $this->getController());

                $autenticacao = new AutenticacaoHelper();
                $autenticacao->setLoginModuleControllerAction($this->getModule(), "Home", "Index")
                        ->setErrorModuleControllerAction($this->getModule(), "Autenticacao", "Index")
                        ->setSessao(ApplicationSecurity::SessaoUsuarioNewsletter())
                        ->Login($usuario);
            } else {
                throw new LoginException();
            }
        } catch (RequisicaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (ValidacaoException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (PDOException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ERRO);
        } catch (LoginException $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ALERTA);
        } catch (Exception $e) {
            MensagemHelper::setMensagem($e->getMessage(), MensagemHelper::ERRO);
        }

        RedirectorHelper::goToModuleController($this->getModule(),$this->getController());
    }

}

?>
