<?php

namespace GG\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Identifiants_U
 *
 * @ORM\Table(name="identifiants__u")
 * @ORM\Entity(repositoryClass="GG\UserBundle\Repository\Identifiants_URepository")
 */
class Identifiants_U
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mail
     *
     * @param string $username
     *
     * @return Identifiants_U
     */
    public function setUsername($name)
    {
        $this->username = $name;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Identifiants_U
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
