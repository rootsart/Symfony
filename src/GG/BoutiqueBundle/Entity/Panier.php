<?php

namespace GG\BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="GG\BoutiqueBundle\Repository\PanierRepository")
 */
class Panier
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
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=0)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="montantTTC", type="decimal", precision=10, scale=0)
     */
    private $montantTTC;

    /**
     * @var string
     *
     * @ORM\Column(name="Nb_articles", type="string")
     */
    private $Nb_articles=0;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
    * @ORM\OneToOne(targetEntity="GG\BoutiqueBundle\Entity\User", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="decimal", precision=10, scale=0)
     */
    private $tva;

    /**
    * @ORM\Column(name="liste_articles", type="array")
    */
    private $articles;



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
     * Set montant
     *
     * @param string $montant
     *
     * @return Panier
     */
    public function setMontant()
    {
        
        $this->montant =0;
        foreach ($this->articles as $key => $article) {
          $this->montant += $article->getPrix(); 
          $this->Nb_articles += 1;
         
        }
    }

    /**
     * Set montantTTC
     *
     * @return string
     */
    public function setMontantTTC(){
        $this->montantTTC = $this->montant + $this->tva;
        
    }

    /**
     * Get montantTTC
     *
     * @return string
     */
    public function getMontantTTC(){
        return number_format($this->montantTTC,2);
    }

    /**
     * Get montant
     *
     * @return string
     */

    public function getMontant()
    {
        return number_format($this->montant,2);
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Panier
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set client
     *
     * @param \stdClass $client
     *
     * @return Panier
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \stdClass
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return Panier
     */
    public function setTVA()
    {
        $this->tva=0;
        foreach ($this->articles as $key => $article) {
           $this->tva += $article->Tva();
        }
        

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTVA()
    {
        return number_format($this->tva,2) ;
    }

    
    /**
     * Constructor
     */
    public function __construct(){
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add article
     *
     * @param \GG\BoutiqueBundle\Entity\Article $article
     *
     * @return Panier
     */
    public function addArticle(\GG\BoutiqueBundle\Entity\Article $article)
    {
        $this->articles[] = $article;
        $this->setMontant();
        $this->setTVA();
        $this->setMontantTTC();
        return $this;
    }

    /**
     * Remove article
     *
     * @param \GG\BoutiqueBundle\Entity\Article $article
     */
    public function removeArticle(\GG\BoutiqueBundle\Entity\Article $articleAsupprimer)
    {
        //$this->articles->removeElement($article);
        //array_splice($this->articles, $article->getId(), 1);
       foreach ($this->articles as $key => $article) {
           if($articleAsupprimer->getId() == $article->getId()){
                unset($this->articles[$key]);
                $this->setTVA();
                $this->setMontant();
                $this->setMontantTTC();
                return;
                

           }
       }
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }


    /**
     * Get articles
     *
     * @return string
     */
    public function getNb_articles()
    {
        if(count($this->articles) != null){
            return count($this->articles);
        }else{
            return 0;
        }
    }

    public function vider(){
        $this->articles = Array();
        $this->setTVA();
        $this->setMontant();
        $this->setMontantTTC();  
        return;                
       
    }
}
