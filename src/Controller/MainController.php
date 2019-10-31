<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function home()
    {
        return $this->render('main/creationSortie.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
