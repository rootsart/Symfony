<?php
namespace GG\PaiementBundle\Form;
use Symfony\Component\Form\AbstractType;
use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class CreditCardNumberType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		 $builder
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
    $resolver->setDefaults(array(
      'data_class' => 'GG\UserBundle\Entity\Personne'
    ));
	}


	/**
	* {@inheritdoc}
	*/
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'GG\UserBundle\Entity\Personne'
        ));
    }

    
	/**
	* {@inheritdoc}
	*/
    public function getBlockPrefix(){
        return 'gg_userbundle_personne';
    }

}