<?php
 
namespace GG\UserBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use GG\BoutiqueBundle\Form\IdentifiantsType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use GG\BoutiqueBundle\Form\AdresseType;




class UsagerType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
				->add('username',                  TextType::class)
				->add('password',     	        TextType::class)
				//->add('nom',                  TextType::class)
				
				->add('roles',     	        TextType::class)
				
				//->add('adresse',              AdresseType::class)
        	/*	
				->add('civilite', 			      ChoiceType::class, array(
          'choices'   => array(
          'Mr' => 'Male', 
          'Mme' => 'Female'
          ),
          ))*/
				->add('save',      		SubmitType::class)
				;
	}
 
  public function setDefaultOptions(OptionsResolverInterface $resolver){
    $resolver->setDefaults(array(
      'data_class' => 'GG\UserBundle\Entity\Usager'
    ));
  }
 
  public function getName(){
    return 'gg_userbundle_usager';
  }
}