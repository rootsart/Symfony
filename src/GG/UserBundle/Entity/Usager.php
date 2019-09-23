<?php

namespace GG\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * Usager
 *
 * @ORM\Table(name="usager")
 * @ORM\Entity(repositoryClass="GG\UserBundle\Repository\UsagerRepository")
 */
class Usager extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    

    /**
    * @ORM\OneToOne(targetEntity="GG\UserBundle\Entity\Personne", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $personne;
    
   
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
    * @ORM\OneToOne(targetEntity="GG\UserBundle\Entity\Adress", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $adress;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Usager
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

    

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Usager
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return Usager
     */
    public function setDateInscription($date)
    {
        $this->dateInscription = new \DateTime('now');

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription(){
        //var_dump($this->dateInscription);
        return $this->dateInscription;
    }


   

   
    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Usager
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

    /**
     * Set adress
     *
     * @param \GG\UserBundle\Entity\Adress $adress
     *
     * @return Usager
     */
    public function setAdress(\GG\UserBundle\Entity\Adress $adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return \GG\UserBundle\Entity\Adress
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set personne
     *
     * @param \GG\UserBundle\Entity\Personne $personne
     *
     * @return Usager
     */
    public function setPersonne(\GG\UserBundle\Entity\Personne $personne)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \GG\UserBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set commande
     *
     * @param \GG\UserBundle\Entity\Commande $commande
     *
     * @return Usager
     */
    public function setCommande(\GG\UserBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \GG\UserBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
