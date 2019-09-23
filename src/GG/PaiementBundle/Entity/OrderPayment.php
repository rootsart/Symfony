<?php

namespace GG\PaiementBundle\Entity;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderPayment
 *
 * @ORM\Table(name="order_payment")
 * @ORM\Entity(repositoryClass="GG\PaiementBundle\Repository\OrderPaymentRepository")
 */
class OrderPayment{



    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**  
    * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction")
     */
    private $paymentInstruction;

    /**
     * @var decimal
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2)
     */
    private $amount;


    public function construct(){
        $this->setAmount(number_format(12, 2));
    }



    /**
     * Set id
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id= $id;
        return $this->id ;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return number_format($this->id);
    }

    /**
     * Set paymentInstruction
     *
     * @param string $paymentInstruction
     *
     * @return OrderPayment
     */
    public function setPaymentInstruction($paymentInstruction)
    {
        $this->paymentInstruction = $paymentInstruction;

        return $this;
    }

    /**
     * Get paymentInstruction
     *
     * @return string
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }


    /**
     * Set amount
     *
     * @param decimal $amount
     *
     * @return OrderPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        //return $this;
    }

    /**
     * Get amount
     *
     * @return decimal
     */
    public function getAmount()
    {
        return $this->amount;
    }

    
}