<?php
 
namespace GG\UserBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class Identifiants_UType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
   // ->setAction('login_check')
    ->add('username',      TextType::class, array('label' => 'Login', 'translation_domain' => 'FOSUserBundle'))
    ->add('password',      PasswordType::class, array('label' => 'MDP', 'translation_domain' => 'FOSUserBundle'));
     	
	}
 
  /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GG\UserBundle\Entity\Identifiants_U'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gg_userbundle_identifiants_u';
    }
}