<?php

/**
 * Permissoes
 *
 * @Table(name="permissoes")
 * @Entity
 */
class Permissao {
    
    const ENTRAR_NO_SISTEMA = "ENTRAR_SISTEMA";
    const GERAR_RELATORIO = "GERAR_RELATORIO";
    const GERENCIAR_CLIENTES = "GERENCIAR_CLIENTE";
    const GERENCIAR_USUARIOS = "GERENCIAR_USUARIO";
    const GERENCIAR_TAMPLATES = "GERENCIAR_TEMPLATES";
    const GERENCIAR_ENVIO_EMAIL = "GERENCIAR_ENVIO_EMAIL";
    const GERENCIAR_CONFIGURACOES_GERAIS = "GERENCIAR_CONFIGURACOES_GERAIS";

    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="permissao", type="string", length=50, nullable=true)
     */
    private $permissao;

    /**
     *
     * @var string
     * 
     * @Column(name="descricao", type="string", length=50)
     */
    private $descricao;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set permissao
     *
     * @param string $permissao
     * @return Permissoes
     */
    public function setPermissao($permissao) {
        $this->permissao = $permissao;

        return $this;
    }

    /**
     * Get permissao
     *
     * @return string 
     */
    public function getPermissao() {
        return $this->permissao;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public static function ValidarPermissao(Usuario $usuario, $permissao){
        return in_array($permissao, $usuario->getPermissao()->getPermissoes());
    }

}
