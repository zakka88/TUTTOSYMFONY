<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Length;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class,[
                'label' => 'recipeForm.title'
                // 'label' => "Titre",
            ])
             ->add('slug', HiddenType::class)
             ->add('Content',TextareaType::class, [
                 'label' => 'recipeForm.content'
             ])

            

            ->add('imageName', TextareaType::class,[
                'label' => 'recipeForm.imageName'
            ])

            ->add('duration', TextareaType::class,[
                'label' => 'recipeForm.duration'
            ])

            ->add('save',SubmitType::class, [
                 'label' => 'recipeForm.save'
                // 'label' => "Salva"
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...))

        ;
    }


           public function autoSlug(PreSubmitEvent $event): void {
            $data = $event->getData();
            $slugger = new AsciiSlugger();
            if (empty($data['slug' ]) || $data['slug' ] != strtolower($slugger->slug($data['Title']))){
             $data['slug' ] = strtolower($slugger->slug($data['Title']));
            $event->setData($data);
        }
         }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
