<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchivesController extends Controller
{


    /**
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/sorties/archives/", name="sortie_archives")
     */
    public function list(EntityManagerInterface $em){
        //récupération des sorties archivées
        $sorties = $em->getRepository(Sortie::class)->findByDateArchive();



        return $this->render("affichage_archives/list.html.twig",
            [
                'sorties' => $sorties
            ]);

    }
}
