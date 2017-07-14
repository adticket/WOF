<?php
namespace AppBundle\Form;

use AppBundle\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locationName', TextType::class)
            ->add('website', TextType::class)
            ->add('street', TextType::class)
            ->add('house_no', TextType::class)
            ->add('postcode', TextType::class)
            ->add('city', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Location::class,
        ));
    }
}