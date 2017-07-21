<?php
namespace AppBundle\Form;

use AppBundle\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('categories', EntityType::class, [
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'category_name',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('city', EntityType::class, [
                'class' => 'AppBundle\Entity\City',
                'choice_label' => 'cityName',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('website', TextType::class)
            ->add('street', TextType::class)
            ->add('houseNo', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Restaurant::class,
        ));
    }
}