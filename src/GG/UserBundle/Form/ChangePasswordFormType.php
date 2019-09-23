<?php

namespace GG\UserBundle\Form;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordFormType extends BaseType{
	public function __construct()
            {
                parent::__construct($class = "GG\UserBundle\Entity\Usager");
            
        
            }
}