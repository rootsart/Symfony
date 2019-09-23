<?php

namespace GG\UserBundle\Form;
 
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use FOS\UserBundle\Util\LegacyFormHelper;
use GG\BoutiqueBundle\Form\AdresseType;
use GG\UserBundle\Form\PersonneType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\Date;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Common\Collections\ArrayCollection;

class RegistrationType extends BaseType{

    public function __construct(){
                parent::__construct($class = "GG\UserBundle\Entity\Usager");
            }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('statut', HiddenType::class, array('label' => 'Statut', 'translation_domain' => 'FOSUserBundle', 'data'=>'ok'))

            ->add('roles', ChoiceType::class, array(
                'choices'           =>array('client'=>'ROLE_USER','admin'=>'ROLE_ADMIN', 'artisant'=>'ROLE_ARTISANT', 'commercant'=>'ROLE_COMMERCANT'),
                'label'             =>'ROLES',
                'translation_domain'=>'FOSUserBundle',
                'multiple'          =>'true',
                'label_attr'         =>array(
                    'style'=>'border:0px solid red;width:100px;color:green;display:block;text-align:left;margin-top:10px;'),
                'attr'              =>array('style'=>'height:40px;overflow:hidden;background:; border:1px #ebebeb solid;border-radius:3px; margin-bottom:20px;margin-top:0px;'),
                //'data'              =>'asdsdd'
                ))
            ->add('adress', AdressType::class, array(
                'label'              => 'ADRESSE',
                'label_attr'         =>array(
                    'style'=>'border:0px solid red;border-bottom:none;width:100%;color:green;'),
                'translation_domain' => 'FOSUserBundle',
                'attr'=>array('style'=>'border:px solid black;border-radius:3px;display:block;margin-bottom:20px;width:100%;')))

            ->add('personne', PersonneType::class,  array(
                'label' => 'PERSONNE',
                 'translation_domain' => 'FOSUserBundle',
                 'label_attr'         =>array(
                    'style'=>'border:0px solid red;border-bottom:yellow;width:100%;color:green;'),
                'translation_domain' => 'FOSUserBundle',
                'attr'=>array('style'=>'border:px solid yellow;border-radius:3px;display:block;margin-top:0;width:100%;')))
            
            ->add('date_inscription', HiddenType::class, array('label' => 'date inscription', 'translation_domain' => 'FOSUserBundle', 'data'=>date("Y/m/d")))
            
            ;
    }

    public function getParent(){
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix(){
        return 'app_user_registration';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
          'data_class' => 'GG\UserBundle\Entity\Usager'
        ));
    }
}
