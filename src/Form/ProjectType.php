<?php

namespace App\Form;

use App\Entity\Discipline;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('subtitle')
            ->add('subtitleFr')
            ->add('year')
            ->add('description')
            ->add('descriptionFr', null, [
                'label'=>'Description (français)',
            ])
            ->add('link')
            ->add('github')
            ->add('discipline', EntityType::class,  [
                'choice_label'=>'name',
                'class'=>Discipline::class
            ])
            ->add('customOrder')
            ->add('imageDisplay')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
