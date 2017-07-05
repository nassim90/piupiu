<?php

namespace PiupiuBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ChangeProfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('submit', SubmitType::class, [
                'label' => 'Modify'
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
