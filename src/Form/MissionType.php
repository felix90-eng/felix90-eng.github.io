<?php

namespace App\Form;

use App\Entity\Mission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('staff',EntityType::class,['class'=>'App\Entity\Staff','attr'=>['class'=>'form-control']])
            ->add('mis_purpose',TextareaType::class,['attr'=>['class'=>'form-control']])
            ->add('mis_category',ChoiceType::class,['choices'=>['night'=>'Night','day'=>'Day'],'attr'=>['class'=>'form-control']])
            ->add('leavedAt',DateType::class,['required' => true,'widget' => 'single_text','attr'=>['class'=>'form-control js0-datepicker']])
            ->add('returnedAt',DateType::class,['required' => true,'widget' => 'single_text','attr'=>['class'=>'form-control js00-datepicker']])
            ->add('mean_trans',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('d1IdNumDay',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('d2IdNumDay',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('d3IdNumDay',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('d4IdNumDay',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('numDays',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('destination1',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('destination2',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('destination3',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('destination4',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('loc1Hosted',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('loc2Hosted',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('loc3Hosted',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            ->add('loc4Hosted',EntityType::class,['class'=>'App\Entity\Location','attr'=>['class'=>'form-control']])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
