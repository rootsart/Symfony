<?php
 
namespace GG\BoutiqueBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class IdentifiantsType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
    ->setAction('login_check')
    ->add('email',      TextType::class)
    ->add('password',      PasswordType::class);
     		
	}
 
  /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GG\BoutiqueBundle\Entity\Identifiants'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gg_boutiquebundle_identifiants';
    }
}