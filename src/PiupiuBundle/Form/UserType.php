<?php

namespace PiupiuBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

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
                'attr'      => ['placeholder'   => 'Your password']
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
            ->add('accountType', EntityType::class, [
                'class'         => 'PiupiuBundle:AccountType',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('at')
                        ->where('at.designation != ?1')
                        ->setParameter(1, 'admin')
                        ->orderBy('at.designation', 'DESC');
                },
                'choice_label'  => 'designation',
                'multiple'      => false,
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
