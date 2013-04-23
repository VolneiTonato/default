<?php

/**
 * PermissoesAcesso
 *
 * @Table(name="permissoes_acesso")
 * @Entity
 */
class PermissaoAcesso {

    /**
     * @var string
     *
     * @Column(name="permissoes", type="text", nullable=true)
     */
    private $permissoes;

    /**
     * @Id
     * @OneToOne(targetEntity="Usuario",cascade={"persist"})
     * @JoinColumns({
     *   @JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;


    /**
     * Set permissoes
     *
     * @param string $permissoes
     * @return PermissoesAcesso
     */
    public function setPermissoes($permissoes) {
        $this->permissoes = $permissoes;

        return $this;
    }

    /**
     * Get permissoes
     *
     * @return string 
     */
    public function getPermissoes() {
        return unserialize($this->permissoes);
    }

    /**
     * Set usuario
     *
     * @param \Usuarios $usuario
     * @return PermissoesAcesso
     */
    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Usuarios 
     */
    public function getUsuario() {
        return $this->usuario;
    }

}
