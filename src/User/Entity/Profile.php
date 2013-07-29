<?php
/**
 * Class User\Entity\Profile
 *
 * Create on 28/07/2013
 *
 * php version 5.4
 *
 * @category PHP
 * @package  User
 * @author   Diego Pimentel <diegoper37@hotmail.com>
 * @access   public
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Traits\TraitId,
    Base\Traits\TraitData,
    Base\Traits\TraitStatus;

use Zend\Form\Annotation;

/**
 * Class User\Entity\Profile
 *
 * @category PHP
 * @package  User
 * @author   Diego Pimentel <diegoper37@hotmail.com>
 *
 * @ORM\Entity(repositoryClass="User\Entity\Repository\ProfileRepository")
 * @ORM\Table(name="users_profiles")
 *
 * @Annotation\Name("UsersProfiles")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 */
class Profile
{
    use TraitId;
    use TraitData;
    use TraitStatus;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="login_id", referencedColumnName="id")
     **/
    protected $user;

    /**
     * Atributo de $nome
     *
     * @ORM\Column(type="string", length=100)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":100}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Nome Completo:"})
     *
     * @var string
     * @access protected
     */
    protected $nome = NULL;

    /**
     * Atributo de $telefone
     *
     * @ORM\Column(type="string", length=100,nullable=true)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":100}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Telefone:"})
     *
     * @var string
     * @access protected
     */
    protected $telefone = NULL;

    /**
     * Atributo de $sexo
     *
     * @ORM\Column(type="string", length=1,nullable=true)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":1}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Sexo:"})
     *
     * @var string
     * @access protected
     */
    protected $sexo = NULL;

    /**
     * Atributo de $endereco
     *
     * @ORM\Column(type="string", length=100,nullable=true)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":100}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Endereco:"})
     *
     * @var string
     * @access protected
     */
    protected $endereco = NULL;

    /**
     * Atributo de $cidade
     *
     * @ORM\Column(type="string", length=100,nullable=true)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":100}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Cidade:"})
     *
     * @var string
     * @access protected
     */
    protected $cidade = NULL;


    /**
     * Set nome
     *
     * Metodo para atribuir valor ao atributo $nome
     *
     * @param string $nome
     * @return obj
     */
    public function setNome($nome)
    {
        $this->nome = (string) $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * Metodo para receber o valor do atributo $nome.
     *
     * @return string $nome
     */
    public function getNome()
    {
        return $this->nome;
    }

	/**
     * Set telefone
     *
     * Metodo para atribuir valor ao atributo $telefone.
     *
     * @param string $telefone
     * @return obj
     */
    public function setTelefone($telefone)
    {
        $this->telefone = (int) $telefone;
        return $this;
    }

    /**
     * Get telefone
     *
     * Metodo para receber o valor do atributo $telefone.
     *
     * @return string $telefone
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

	/**
     * Set sexo
     *
     * Metodo para atribuir valor ao atributo $sexo.
     *
     * @param string $sexo
     * @return obj
     */
    public function setSexo($sexo)
    {
        $this->sexo = (string) $sexo;
        return $this;
    }

    /**
     * Get sexo
     *
     * Metodo para receber o valor do atributo $sexo.
     *
     * @return string $sexo
     */
    public function getSexo()
    {
        return $this->sexo;
    }

	/**
     * Set $endereco
     *
     * Metodo para atribuir valor ao atributo $endereco.
     *
     * @param string $endereco
     * @return obj
     */
    public function setEndereco($endereco)
    {
        $this->endereco = (string) $endereco;
        return $this;
    }

    /**
     * Get $endereco
     *
     * Metodo para receber o valor do atributo $endereco.
     *
     * @return string $endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

	/**
     * Set $cidade
     *
     * Metodo para atribuir valor ao atributo $cidade.
     *
     * @param string $cidade
     * @return obj
     */
    public function setCidade($cidade)
    {
        $this->cidade = (string) $cidade;
        return $this;
    }

    /**
     * Get $cidade
     *
     * Metodo para receber o valor do atributo $cidade.
     *
     * @return string $cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set login
     *
     * Metodo para atribuir valor ao atributo $login.
     *
     * @param string $login
     * @return obj
     */
    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    /**
     * Get login
     *
     * Metodo para receber o valor do atributo $login.
     *
     * @return string $login
     */
    public function getLogin() {
        return $this->login;
    }

}