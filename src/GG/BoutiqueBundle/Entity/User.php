<?php

namespace GG\BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GG\BoutiqueBundle\Entity\Adresse;
use GG\BoutiqueBundle\Entity\Identifiants;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="GG\BoutiqueBundle\Repository\UserRepository")
 */
class User
{
    public function __construct(){
    $this->setDateInscription();
    $this->setStatut();
    }
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
    * @ORM\OneToOne(targetEntity="GG\BoutiqueBundle\Entity\Adresse", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $adresse;

    /**
    * @ORM\OneToOne(targetEntity="GG\BoutiqueBundle\Entity\Identifiants", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $identifiants;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $civilite;


     /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="date")
     */
    private $dateInscription;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /************************************************************
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /************************************************************
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /************************************************************
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /************************************************************
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /************************************************************
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /************************************************************
    * Set statut
    *
    *@param string statut
    *@return User
    */
    public function setStatut(){
        $this->statut = 'client';
        return $this;
    }

    /**
    * Get Statut
    * @return string
    */
    public function getStatut(){
        return $this->statut;
    }

    /************************************************************
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return User
     */
    public function setDateInscription()
    {
        $this->dateInscription = new \DateTime('now');

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }


    /************************************************************
     * Set adresse
     *
     * @param  object $adresse
     *
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return object
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /************************************************************
     * Set identifiants
     *
     * @param  object $identifiants
     *
     * @return User
     */
    public function setIdentifiants($identifiants)
    {
        $this->identifiants = $identifiants;

        return $this;
    }

    /**
     * Get identifiants
     *
     * @return object
     */
    public function getIdentifiants()
    {
        return $this->identifiants;
    }
}

