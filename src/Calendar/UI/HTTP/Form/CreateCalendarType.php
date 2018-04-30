<?php

namespace App\Calendar\UI\Form;


use App\Calendar\Application\CreateCalendarCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCalendarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('description')
            ->add('save', 'submit');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'calendar';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateCalendarCommand::class,
            'empty_class' => function(FormInterface $form){
                return new CreateCalendarCommand(
                    $form->get('name')->getData(),
                    $form->get('description')->getData()
                );
            }
        ]);
    }
}