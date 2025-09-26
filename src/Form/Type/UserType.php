<?php

namespace  App\Form\Type;

use Dom\Text;
use PhpCsFixer\Console\Report\ListSetsReport\TextReporter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', TextType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class)
            ;
    }
}

