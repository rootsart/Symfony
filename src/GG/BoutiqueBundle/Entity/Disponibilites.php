<?php

namespace GG\BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disponibilites
 *
 * @ORM\Table(name="disponibilites")
 * @ORM\Entity(repositoryClass="GG\BoutiqueBundle\Repository\DisponibilitesRepository")
 */
class Disponibilites
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
     * @var bool
     *
     * @ORM\Column(name="Reserved", type="boolean")
     */
    private $reserved = FALSE;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide = TRUE;


    // -------------CONSTRUCTEUR-------------------
    public function __construct(){
       
    }
    //---------------------------------------------


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
     * Set reserved
     *
     * @param boolean $reserved
     *
     * @return Disponibilites
     */
    public function setReserved($reserved)
    {
        $this->reserved = $reserved;

        return $this;
    }

    /**
     * Get reserved
     *
     * @return bool
     */
    public function getReserved()
    {
        return $this->reserved;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Disponibilites
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }
}

