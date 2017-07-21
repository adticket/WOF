<?php
namespace AppBundle\Form;

use AppBundle\Entity\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ratingValue', RadioType::class, array(
                'first' => '1',
                'first' => '2',
                'first' => '3',
                'first' => '4',
                'first' => '5',
            ))

            ->add('ratingValue', RangeType::class, array(
                'attr' => ['min' => 1, 'max' => 5]
            ))
            ->add('comment', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Rating::class,
        ));
    }
}