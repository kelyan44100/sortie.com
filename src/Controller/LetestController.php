<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class LetestController extends Controller
{
    /**
     * @Route("/letest", name="letest")
     */
    public function index()
    {
        return $this->render('letest/index.html.twig', [
            'controller_name' => 'LetestController',
        ]);
    }
}
