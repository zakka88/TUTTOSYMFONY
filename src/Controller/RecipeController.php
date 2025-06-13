<?php

namespace App\Controller;


use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


//  class RecipeController extends AbstractController
// {
//    #[Route(path :"/recette/{slug}-{id}", name : "app_recipe_show", requirements: ['id'=> '\d+', 'slug'=> '[a-z0-9-]+'] )]
//    public function show(Request $request): Response{
//        dump($request->attributes->getInt("id"));
//        dd($request->attributes->get("slug"));
//     return new Response("Bienvenue sur la page ".$request->query->get('recette','recette !!'));
//    }
// }

class RecipeController extends AbstractController

{
     #[Route(path :"/recette", name : "app_recipe_index" )]
     public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em ): Response
     {
      //comment récuperer nos recettes sans appeler le RecipeRepository o usi quello line 34 o 35 uno dei 2
        //$recipes = $em->getRepository(Recipe::class)->findAll();
      $recipes = $repository->findAll();
      //$recipes = $repository->findRecipeDurationLowerThan(10);
      //dump($recipes);
    // return new Response("Bienvenue sur la page recette");

    //----------------------------------come creare una ricetta
   //  $recipe = new Recipe();
   //  $recipe->setTitle('pure')
   //  ->setSlug('pure')
   //  ->setContent('Rosola cipolla, carota e sedano tritati in olio, aggiungi la carne a cubetti, sfuma con vino, unisci brodo e aromi, cuoci a fuoco lento per oltre un’ora e servi con purè fatto schiacciando patate lesse e mescolandole con burro e latte caldo.')
   //  ->setDuration(90)
   //  ->setCreatedAt(new DateTimeImmutable())
   //  ->setUpdatedAt(new DateTimeImmutable());
   //   $em->persist($recipe); 
        //$em->flush(); 
    

   //-----------------------------------------come modificare una ricetta  
   

   // $recipes[5]->setTitle("patatos")
   // ->setSlug("patatos")
   // ->setContent("patatos");

   //$em->flush(); 


   //--------------------------------------------come eliminare una ricetta 
   //ricordati che da errore una volta fatto devi commentaare la linea 65 e 66 

   // $em->remove($recipes[4]);
   // $em->flush(); 

   return $this->render('recipe/index.html.twig',[
       'recipes' => $recipes
    ]);
 }
 
    

   #[Route(path :"/recette/{slug}-{id}", name : "app_recipe_show", requirements: ['id'=> '\d+', 'slug'=> '[a-z0-9-]+'] )]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response{
    //     dump($slug);
    //    dump($id);
       //die;
    //return new Response("Recette numero ". $id.":". $slug);
    $recipe = $repository->find($id);
    if($recipe->getSlug() !== $slug){
      return $this->redirectToRoute('app_recipe_show',['slug' => $recipe->getSlug(), 'id' => $recipe->getId()]);
    }
    return $this->render('recipe/show.html.twig',[
    
      'recipe'=>$recipe,
      
   

       'user'=> [
          "firstname"=>"Zakaria",
          "lastname"=>"Benamar"
       ]

    ]);
   
   }



    #[Route(path :"/recette/{id}/edit", name : "app_recipe_edit" )]
     public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em ): Response {
      
          $form = $this->createForm(RecipeType::class,$recipe);
          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()){
            $recipe->setUpdatedAt(new DateTimeImmutable());
            $em->flush();
             //return $this->redirectToRoute('app_recipe_index');
             $this->addFlash('success', 'la ricetta é stata modificata');
             return $this->redirectToRoute('app_recipe_show', ['id' => $recipe->getId() , 'slug' => $recipe->getSlug()]);
          }
          return $this->render('recipe/edit.html.twig',[
    
      'recipe'=>$recipe,
      'monForm'=>$form
    ]);
   
     }





     #[Route(path :"/recette/create", name : "app_recipe_create" )]
     public function create( Request $request, EntityManagerInterface $em ): Response {
           $recipe = new Recipe;
          $form = $this->createForm(RecipeType::class,$recipe);
          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()){
            $recipe->setCreatedAt(new DateTimeImmutable());
             $recipe->setUpdatedAt(new DateTimeImmutable());
            $em->persist($recipe);
            $em->flush();
             //return $this->redirectToRoute('app_recipe_index');
             $this->addFlash('success','la recette '. $recipe->getTitle() . ' a bien été créée');
             return $this->redirectToRoute('app_recipe_index');
          }
          return $this->render('recipe/create.html.twig',[
           'monForm'=>$form
    ]);
   
     }




               #[Route(path : '/recette/{id}/delete', name : 'app_recipe_delete' ) ]
                public function delete(Recipe $recipe, EntityManagerInterface $em) : Response {
                 $titre = $recipe->getTitle();
                $em->remove($recipe);
                $em->flush();
                $this->addFlash('info', 'La recette '. $titre . ' a bien été supprimée' ) ;
                return $this->redirectToRoute('app_recipe_index');

}
}