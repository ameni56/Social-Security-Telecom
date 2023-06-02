<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\DemandeAide;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('somme',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('piece', ChoiceType::class, [
                'choices'  => [
                    'Cin' => 'Cin',
                    'Yes' => 'yes',
                    'No' => 'yes'
                 ] ],
                 TextType::class,[
                    'attr'=>[
                        'class'=>'form-control'
                    ]])

            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Crédit' => 'Crédit',
                    'Indemnité sociale' => 'Indemnité sociale',
                    'Aide sociale' => 'aide sociale',
                    'Activité socio-culturelle' => 'Activité socio-culturelle'
                 ] ],
                 TextType::class,[
                    'attr'=>[
                        'class'=>'form-control'
                    ]])
            ->add('Envoyer',SubmitType::class, [
                'attr' => ['class' => 'Envoyer'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeAide::class,
        ]);
    }

    
}
