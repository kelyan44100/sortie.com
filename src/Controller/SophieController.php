<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SophieController extends Controller
{
    /**
     * @Route("/sophie", name="sophie")
     */
    public function index()
    {
        return $this->render('sophie/index.html.twig', [
            'controller_name' => 'SophieController',
        ]);
    }
}
