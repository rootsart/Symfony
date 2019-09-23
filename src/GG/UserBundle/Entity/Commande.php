<?php

namespace GG\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use GG\PaiementBundle\Entity\OrderPayment;
/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="GG\UserBundle\Repository\CommandeRepository")
 */
class Commande
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
    * @ORM\ManyToOne(targetEntity="GG\UserBundle\Entity\Usager", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $client;

    /**
    * @ORM\Column(name="liste_articles", type="array")
    */
    private $liste_articles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=2)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="montantTTC", type="decimal", precision=10, scale=2)
     */
    private $montantTTC;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
    * @ORM\ManyToOne(targetEntity="GG\PaiementBundle\Entity\OrderPayment", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $order;

    public function __construct(Usager $client, \GG\BoutiqueBundle\Entity\Panier $panier){
        $this->liste_articles = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->setList_articles($articleslist);
        $this->setClient($client);
        $this->setDate(new \DateTime('now'));
        $this->add_Article($panier->getArticles());
        $this->setMontant($panier->getMontant());
        $this->setMontantTTC($panier->getMontantTTC());
        $this->setEtat('en cours');
    }

    
    public function setOrder(OrderPayment $order){
        $this->order = $order;
    }

    public function getOrder(){
        return $this->order;
    }

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
     * Set client
     *
     * @param \stdClass $client
     *
     * @return Commande
     */
    public function setClient(Usager $client)
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
     * Get articles
     *
     * @return array
     */
    public function getList_articles()
    {
        return $this->liste_articles;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
     */
    public function setDate(\DateTime $date)
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
     * Set montant
     *
     * @param string $montant
     *
     * @return Commande
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }
   

    /**
     * Add article
     *
     * @param \GG\BoutiqueBundle\Entity\Article $article
     *
     * @return Commande
     */
    public function add_Article(\Doctrine\Common\Collections\ArrayCollection $listarticle){
        foreach ($listarticle as $key => $article) {
               $this->liste_articles[]=$article;
        }
        

        //return $this;
    }

    /**
     * Remove article
     *
     * @param \GG\BoutiqueBundle\Entity\Article $article
     */
    public function removeArticle(\GG\BoutiqueBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Set montantTTC
     *
     * @param string $montantTTC
     *
     * @return Commande
     */
    public function setMontantTTC($montantTTC)
    {
        $this->montantTTC = $montantTTC;

        return $this;
    }

    /**
     * Get montantTTC
     *
     * @return string
     */
    public function getMontantTTC()
    {
        return $this->montantTTC;
    }

    /**
     * Add listArticle
     *
     * @param \GG\BoutiqueBundle\Entity\Article $listArticle
     *
     * @return Commande
     */
    public function addListArticle(\GG\BoutiqueBundle\Entity\Article $listArticle)
    {
        $this->liste_articles[] = $listArticle;

        return $this;
    }

    /**
     * Remove listArticle
     *
     * @param \GG\BoutiqueBundle\Entity\Article $listArticle
     */
    public function removeListArticle(\GG\BoutiqueBundle\Entity\Article $listArticle)
    {
        $this->liste_articles->removeElement($listArticle);
    }

    /**
     * Get listArticles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListArticles()
    {
        return $this->liste_articles;
    }
}
