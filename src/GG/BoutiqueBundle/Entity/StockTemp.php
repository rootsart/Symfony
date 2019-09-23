<?php

namespace GG\BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockTemp
 *
 * @ORM\Table(name="stock_temp")
 * @ORM\Entity(repositoryClass="GG\BoutiqueBundle\Repository\StockTempRepository")
 */
class StockTemp
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
     * @ORM\Column(name="stocktemp", type="string", length=255)
     */
    private $stocktemp;

    public function __construct(){
     $this->setStocktemp("1");
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
     * Set stocktemp
     *
     * @param string $stocktemp
     *
     * @return StockTemp
     */
    public function setStocktemp($stocktemp)
    {
        $this->stocktemp = $stocktemp;

        return $this;
    }

    /**
     * Get stocktemp
     *
     * @return string
     */
    public function getStocktemp()
    {
        return $this->stocktemp;
    }
}

