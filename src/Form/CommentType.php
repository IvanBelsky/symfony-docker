<?php
//Form for validation Comments
namespace App\Form;


use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         //   ->add('dateCreated', DateType::class, [
            ->add('calendar', DateType::class, [
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text',
            ])
         //   ->add('content', TextType::class, [
            ->add('comment', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
            ])
        ;
    }
}