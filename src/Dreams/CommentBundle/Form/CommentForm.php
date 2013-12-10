<?php

namespace Dreams\CommentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', array('label' => 'Description', 'max_length' => 500,
                'attr'=> array('rows' => 7, 'placeholder' => 'Description', 'class '=> 'form-control',
                'id' => 'description', 'maxlength' => 500), 'label_attr' => array('class' => 'col-lg-2 control-label')))
        ;
    }

    public function getName()
    {
        return 'comment';
    }
}