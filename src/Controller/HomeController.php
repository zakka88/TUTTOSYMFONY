<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarDumper\Cloner\AbstractCloner;

 class HomeController extends AbstractController
{
   #[Route(path :"/", name : "home" )]
   public function index(Request $request): Response{
      //var_dump($request);
      //dump($request);
      //die;
      //dd($request);
   //  return new Response("Hello ".$request->query->get('nom','world !!'));
    return $this->render('home/index.html.twig');
   }
}
