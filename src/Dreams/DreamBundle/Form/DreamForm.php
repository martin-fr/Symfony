<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19/11/13
 * Time: 15:09
 */

namespace Dreams\DreamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class DreamForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre', 'max_length' => 50,
                'attr'=> array('placeholder' => 'Titre', 'class '=> 'form-control',
                'id' => 'title', 'type' => 'text'), 'label_attr' => array('class' => 'col-lg-2 control-label')))
            ->add('description', 'textarea', array('label' => 'Description', 'max_length' => 500,
                'attr'=> array('rows' => 7, 'placeholder' => 'Description', 'class '=> 'form-control',
                    'id' => 'description', 'maxlength' => 500), 'label_attr' => array('class' => 'col-lg-2 control-label')))
            ->add('category', 'choice', array('label' => 'Catégorie',
                'attr'=> array('class' => 'form-control', 'id' => 'category'), 'label_attr' => array('class' => 'col-lg-2 control-label'),
                'choices' => array('Rêve'=>'Rêve', 'Cauchemar'=>'Cauchemar')))
        ;
    }

    public function getName()
    {
        return 'dream';
    }

} 