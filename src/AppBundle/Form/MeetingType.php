<?php
namespace AppBundle\Form;

use AppBundle\Entity\Meeting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $meeting = $options['data'];
        $group = $meeting->getGroup();

        $builder
            ->add('restaurant', EntityType::class, [
                'class' => 'AppBundle\Entity\Restaurant',
                'choices' => $group->getRestaurants(),
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('visitAt', DatetimeType::class, [ 'pickerOptions' => [
                //'format' => 'mm/dd/yyyy',
                'format' => 'yyyy-mm-dd hh:ii',
                //'weekStart' => 0,
                'startDate' => date('Y/m/d H:i'),
                //'endDate' => date('Y/m/d H:i'),
                //'daysOfWeekDisabled' => '0,6',
                'autoclose' => true,
                'startView' => 'month',
                'minView' => 'hour',
                'maxView' => 'month',
                'todayBtn' => true,
                'todayHighlight' => true,
                'keyboardNavigation' => true,
                'language' => 'de',
                'forceParse' => true,
                'minuteStep' => 15,
                //'pickerReferer ' => 'default', //deprecated
                'pickerPosition' => 'bottom-right',
                'viewSelect' => 'hour',
                'showMeridian' => false,
                //'initialDate' => date('m/d/Y'),
                ]]); ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Meeting::class,
        ));
    }
}