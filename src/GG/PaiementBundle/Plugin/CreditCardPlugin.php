<?php
namespace GG\PaiementBundle\Plugin;

use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;
use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;
use JMS\Payment\CoreBundle\Plugin\ErrorBuilder;
use Doctrine\ORM\EntityManager;

class CreditCardPlugin extends AbstractPlugin{

    protected $responseCode = parent::RESPONSE_CODE_SUCCESS;
    public function checkPaymentInstruction(PaymentInstructionInterface $instruction)
    {

        $errorBuilder = new ErrorBuilder();
        $data = $instruction->getExtendedData();

        if (!$data->get('holder')) {
            $errorBuilder->addDataError('holder', 'form.error.required');
        }
        if (!$data->get('number')) {
            $errorBuilder->addDataError('number', 'form.error.required');
        }

        if ($instruction->getAmount() > 10000) {
            $errorBuilder->addGlobalError('form.error.credit_card_max_limit_exceeded');
        }

        // more checks here ...

        if ($errorBuilder->hasErrors()) {
            throw $errorBuilder->getException();
        }
    }

    public function approveAndDeposit(\JMS\Payment\CoreBundle\Model\FinancialTransactionInterface $transaction, $retry=true){
        //var_dump($transaction->getExtendedData());
        $transaction->setResponseCode($this->responseCode);
        $transaction->setExtendedData($transaction->getExtendedData());
        echo "ResponseCode : " . $transaction->getResponseCode();
        return;
    }


    public function processes($method){
        return 'credit_card' === $method;
    }


}