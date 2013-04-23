<?php

/**
 * Usuarios
 *
 * @Table(name="usuarios")
 * @Entity
 */
class Usuario {

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
     * @Column(name="nome", type="string", length=50, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @Column(name="login", type="string", length=50, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @Column(name="senha", type="string", length=50, nullable=false)
     */
    private $senha;

    /**
     * @var boolean
     *
     * @Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @OneToOne(targetEntity="PermissaoAcesso", mappedBy="usuario")
     */
    private $permissao;
    

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function __construct() {
        $this->Initialize();
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Usuarios
     */
    public function setNome($nome) {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Usuarios
     */
    public function setLogin($login) {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * Set senha
     *
     * @param string $senha
     * @return Usuarios
     */
    public function setSenha($senha) {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get senha
     *
     * @return string 
     */
    public function getSenha() {
        return $this->senha;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Usuarios
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuarios
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    public function getPermissao() {
        return $this->permissao;
    }

    public function setPermissao($permissao) {
        $this->permissao = $permissao;
    }

    private function Initialize() {
        $this->setStatus(1);
    }

    public function Validation() {
        $validacao = new ValidarDadosHelper();
        $validacao->Set($this->getNome(), 'Nome')->Obrigatorio();
        $validacao->Set($this->getLogin(), 'Login')->Obrigatorio();
        $validacao->Set($this->getSenha(), 'Senha')->Obrigatorio();
        $validacao->Set($this->getStatus(), 'Status')->Obrigatorio();
        $validacao->Set($this->getEmail(), 'Email')->Obrigatorio()->ValidarEmail();
        if (!$validacao->Validar()) {
            throw new ValidacaoException(implode('<br />', $validacao->getErros()));
        }
    }

}
