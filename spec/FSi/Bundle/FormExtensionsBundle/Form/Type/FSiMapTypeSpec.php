<?php

namespace spec\FSi\Bundle\FormExtensionsBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FSiMapTypeSpec extends ObjectBehavior
{
    public function it_is_form_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    public function it_has_name()
    {
        $this->getName()->shouldReturn('fsi_map');
    }

    function it_pas_parent_form()
    {
        $this->getParent()->shouldReturn('form');
    }

    public function it_set_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'inherit_data' => true,
            'translation_domain' => 'FSiFormExtensionsBundle',
            'latitude_name' => 'latitude',
            'latitude_type' => 'number',
            'latitude_options' => array(),
            'longitude_name' => 'longitude',
            'longitude_type' => 'number',
            'longitude_options' => array(),
            'zoom_name' => 'zoom',
            'zoom_type' => 'number',
            'zoom_options' => array(),
        ])->shouldBeCalled();

        $resolver->setAllowedTypes([
            'latitude_name' => 'string',
            'latitude_type' => 'string',
            'latitude_options' => 'array',
            'longitude_name' => 'string',
            'longitude_type' => 'string',
            'longitude_options' => 'array',
            'zoom_name' => 'string',
            'zoom_type' => 'string',
            'zoom_options' => 'array',
        ])->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    public function it_build_form_with_default_options(FormBuilderInterface $builder)
    {
        $builder->add('latitude', 'integer', ['label' => 'map.latitude'])->shouldBeCalled();
        $builder->add('longitude', 'text', ['label' => 'map.longitude'])->shouldBeCalled();
        $builder->add('zoom', 'textarea', ['label' => 'map.zoom'])->shouldBeCalled();

        $this->buildForm($builder, [
            'latitude_name' => 'latitude',
            'latitude_type' => 'integer',
            'latitude_options' => array(),
            'longitude_name' => 'longitude',
            'longitude_type' => 'text',
            'longitude_options' => array(),
            'zoom_name' => 'zoom',
            'zoom_type' => 'textarea',
            'zoom_options' => array(),
        ]);
    }

    public function it_build_form_with_merged_options(FormBuilderInterface $builder)
    {
        $builder->add('lat', 'integer', [
            'label' => 'xyz.lat',
            'label_attr' => ['class' => 'lorem'],
        ])->shouldBeCalled();
        $builder->add('lng', 'text', [
            'label' => 'xyz.lng',
            'label_attr' => ['class' => 'ipsum'],
        ])->shouldBeCalled();
        $builder->add('z', 'textarea', [
            'label' => 'xyz.z',
            'label_attr' => ['class' => 'dolor'],
        ])->shouldBeCalled();

        $this->buildForm($builder, [
            'latitude_name' => 'lat',
            'latitude_type' => 'integer',
            'latitude_options' => array(
                'label' => 'xyz.lat',
                'label_attr' => ['class' => 'lorem'],
            ),
            'longitude_name' => 'lng',
            'longitude_type' => 'text',
            'longitude_options' => array(
                'label' => 'xyz.lng',
                'label_attr' => ['class' => 'ipsum'],
            ),
            'zoom_name' => 'z',
            'zoom_type' => 'textarea',
            'zoom_options' => array(
                'label' => 'xyz.z',
                'label_attr' => ['class' => 'dolor'],
            ),
        ]);
    }
}
