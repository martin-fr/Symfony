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

    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre', 'max_length' => 50))
            ->add('description', 'text', array('label' => 'Description', 'max_length' => 500))
            ->add('category', 'choice', array('label' => 'Titre'), array('choices' => array('R'=>'Rêve','C'=>'Cauchemar')))
        ;
    }

    public function getName()
    {
        return 'dream';
    }

} 