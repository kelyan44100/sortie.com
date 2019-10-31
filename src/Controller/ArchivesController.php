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

        $user = $this->getUser();

        if(!$this->isGranted("ROLE_ADMIN")){
            return $this->redirectToRoute('sortie_list');
        }

        //récupération des sorties archivées
        $sorties = $em->getRepository(Sortie::class)->findByDateArchive();

        return $this->render("affichage_archives/listArchives.html.twig",
            [
                'sorties' => $sorties
            ]);

    }
}
