<?php

namespace PiupiuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'required'  => true,
                'attr'      => ['placeholder'   => 'Your username']
            ])
            ->add('password', PasswordType::class, [
                'required'  => true,
                'attr'      => ['placeholder'   => 'Your username']
            ])
//            ->add('firstLogin')
            ->add('prename', TextType::class, [
                'required'  => true,
                'label'     => 'Firstname',
                'attr'      => ['placeholder'   => 'Your firstname']
            ])
            ->add('surname', TextType::class, [
                'required'  => true,
                'label'     =>  'Name',
                'attr'      => ['placeholder'   => 'Your name']
            ])
            ->add('email', EmailType::class, [
                'required'  => true,
                'attr'      => ['placeholder'   => 'Your email']
            ])
            ->add('phone', TextType::class, [
                'attr'      => ['placeholder'   => 'Your phone number']
            ])
//            ->add('lastLoginTime')
//            ->add('account_type');
            ->add('submit', SubmitType::class, [
                'label' => 'Sign up'
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PiupiuBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'piupiubundle_user';
    }


}
