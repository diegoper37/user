<?php

/**
 * Class Entity\User
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
 * Class Entity\User
 *
 * @category PHP
 * @package  User
 * @author   Diego Pimentel <diegoper37@hotmail.com>
 *
 * @ORM\Entity(repositoryClass="User\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 *
 * @Annotation\Name("Users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 */
class User {

    use TraitId;
    use TraitData;
    use TraitStatus;

    /**
     * Atributo de $profile
     *
     * @ORM\OneToOne(targetEntity="Profile", mappedBy="user")
     * @var obj
     * @access protected
     */
    protected $profile = NULL;

    /**
     * Atributo de $login
     *
     * @ORM\Column(type="string", length=100, unique=true)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":100}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Login:"})
     *
     * @var string
     * @access protected
     */
    protected $login = NULL;

    /**
     * Atributo de $email
     *
     * @ORM\Column(type="string", length=100, unique=true)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":100}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Email:"})
     *
     * @var string
     * @access protected
     */
    protected $email = NULL;

    /**
     * Atributo de $senha
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":5, "max":50}})
     * @Annotation\Attributes({"type":"password"})
     * @Annotation\Options({"label":"Password:"})
     *
     * @var string
     * @access protected
     */
    protected $senha = NULL;

    /**
     * Set login
     *
     * Metodo para atribuir valor ao atributo $login.
     *
     * @param string $login
     * @return obj
     */
    public function setLogin($login) {
        $this->login = (string) $login;
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

    /**
     * Get profile
     *
     * Metodo para receber o valor do atributo $profile.
     *
     * @return string $profile
     */
    public function getProfile() {
        return $this->profile;
    }

    /**
     * Set email
     *
     * Metodo para atribuir valor ao atributo $email.
     *
     * @param string $email
     * @return obj
     */
    public function setEmail($email) {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * Get email
     *
     * Metodo para receber o valor do atributo $email.
     *
     * @return string $email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set senha
     *
     * Metodo para atribuir valor ao atributo $senha.
     *
     * @param string $senha
     * @return obj
     */
    public function setSenha($senha) {
        $this->senha = (string) $senha;
        $this->senha = md5($this->senha);
        return $this;
    }

    /**
     * Get senha
     *
     * Metodo para receber o valor do atributo $senha.
     *
     * @return string $senha
     */
    public function getSenha() {
        return $this->senha;
    }

}