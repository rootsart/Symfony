<?php
namespace GG\PaiementBundle\Form;
use Symfony\Component\Form\AbstractType;
use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class CreditCardType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('holder', TextType::class, array(
                'required' => false,
                'label_attr'=>array(
                    'style'=>'width:200px;background:;display:inline-block;text-align:left;margin:0;'),
                'label'=>'Nom propriétaire carte'))
            ->add('number', TextType::class, array('required' => false,
                'label_attr'=>array(
                    'style'=>'width:200px;background:;display:inline-block;text-align:left;margin:0;'),
                'label'=>'Numero carte'))
            ->add('expires', DateType::class, array('required' => false))
            ->add('code', TextType::class, array('required' => false,
                'label_attr'=>array(
                    'style'=>'width:200px;background:;display:inline-block;text-align:left;margin:0;'),
                'label'=>'Code(3 chiffres)'))
        ;
    }

    public function getName(){
        return 'credit_card';
    }
    
}