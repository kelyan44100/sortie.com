<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AffichageSortieController extends Controller
{

    /**
     * @param EntityManagerInterface $em
     *
     * @Route("/sorties/list/", name="sortie_list")
     *
     * @return Response
     */
    public function list(EntityManagerInterface $em){
        $repo = $em->getRepository(Sortie::class);

        $sorties = $repo->findAll();

        return $this->render("affichage_sortie/list.html.twig",
            [
                "sorties" => $sorties
            ]);

    }
}
