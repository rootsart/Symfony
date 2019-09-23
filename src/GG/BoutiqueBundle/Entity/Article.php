<?php

namespace GG\BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GG\BoutiqueBundle\Entity\Image;
use GG\BoutiqueBundle\Entity\Disponibilites;
/**
 * Article
 *
 * @ORM\Table(name="boutique_article")
 * @ORM\Entity(repositoryClass="GG\BoutiqueBundle\Repository\ArticleRepository")
 * 
 */

class Article
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
    * @ORM\ManyToOne(targetEntity="GG\BoutiqueBundle\Entity\Categorie", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $categorie;

    /**
    * @ORM\ManyToOne(targetEntity="GG\BoutiqueBundle\Entity\Rubriques", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $rubrique;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="stock", type="string", precision=10, scale=2)
     */
    private $stock;

    /**
    * @ORM\OneToOne(targetEntity="GG\BoutiqueBundle\Entity\StockTemp", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $stocktemp;

    /**
     * @var string
     *
     * @ORM\Column(name="infos", type="text")
     */
    private $infos;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="text")
     */
    private $level;


    /**
    * @ORM\OneToOne(targetEntity="GG\BoutiqueBundle\Entity\Image", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $photo;

    private $tva;


    /**
    * @ORM\ManyToOne(targetEntity="GG\BoutiqueBundle\Entity\Disponibilites", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $dispo;

    // -------------CONSTRUCTEUR-------------------
    public function __construct(){
     // $stock = new StockTemp();
     // $this->setStocktemp($stock); 
    }


    

    //---------------------------------------------
    public function setDispo(Disponibilites $dispo){
        $this->dispo = $dispo;
    }


    public function getDispo(){
        return $this->dispo;
    }
    /*******************************************
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /*******************************************
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Article
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    

    /*******************************************
     * Set rubrique
     *
     * @param string $rubrique
     *
     * @return Article
     */
    public function setRubrique($rubrique)
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    /**
     * Get rubrique
     *
     * @return string
     */
    public function getRubrique()
    {
        return $this->rubrique;
    }

    /*******************************************
     * Set reference
     *
     * @param string $reference
     *
     * @return Article
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /*******************************************
     * Set url
     *
     * @param string $url
     *
     * @return Article
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /*******************************************
     * Set prix
     *
     * @param string $prix
     *
     * @return Article
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /*******************************************
     * Set infos
     *
     * @param string $infos
     *
     * @return Article
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /*******************************************
     * Set photo
     *
     * @param object $photo
     *
     * @return Article
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return object
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    public function __toString()
        {
            return (string) $this->getPhoto();
        }
    /***********************************************
      * Set stock
     *
     * @param object $stock
     *
     * @return Article
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return object
     */
    public function getStock()
    {
        return $this->stock;
    }

    public function Tva(){
        $this->tva = 0.06 * $this->getPrix();
        return number_format($this->tva, 2);
    }

    //***********************************************
     /**
     * Set stocktemp
     *
     * @param object $stocktemp
     *
     * @return Article
     */
    public function setStocktemp(StockTemp $stocktemp)
    {
        $this->stocktemp = $stocktemp;

        return $this;
    }

    /**
     * Get stocktemp
     *
     * @return object
     */
    public function getStocktemp()
    {
        return $this->stocktemp;
    }

    //**********************************************

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Article
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    
    
    public function hydrate(array $donnees){
        foreach ($donnees as $attribut => $valeur){
          $methode = 'set'.ucfirst($attribut);
          if (is_callable([$this, $methode])){
            $this->$methode($valeur);
          }
        }return true;
    }


}
