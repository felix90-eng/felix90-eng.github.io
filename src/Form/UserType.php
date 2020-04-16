<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('staff')
            ->add('roles',ChoiceType::class,[
                'mapped' => true,
                'expanded' => true,
                'multiple' => true,
                'choices'=>[
                    'Staff'=>'ROLE_USER','Admin '=>'ROLE_ADMIN',
                    'Director General'=>'ROLE_DG','Accountant'=>'ROLE_ACCOUNTANT',
                    'Division Manager'=>'ROLE_DM','Supervisor'=>'ROLE_SUPERVISOR',
                    'DAF'=>'ROLE_DAF','Corporate'=>'ROLE_CORPORATE']
                    ,'label_attr'=>array('class'=>' form-check-label')
                    ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
