<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Vehicle1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('purpose')
            ->add('telephone')
            ->add('tripdays',HiddenType::class,['label'=>'Days'])
            ->add('timedisparture', DateType::class, ['widget' => 'single_text' ,'attr'=>['class'=>'form-control js1-datepicker'],'label'=>'Time To Leave'])
            ->add('arrivaltime', DateType::class, ['widget' => 'single_text','attr'=>['class'=>'form-control js2-datepicker'],'label'=>'Time To come back'])
            ->add('staff')
            ->add('position')
            ->add('destination')
            ->add('travelmode',ChoiceType::class,['choices'=>[''=>'','Individual'=>'individual','More'=>'more'],])
            ->add('travellerquantity',TextType::class,['label'=>'Nmber'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
