<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
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
    public function list(EntityManagerInterface $em, $inscription = 0){
        // récupération de toutes les sorties
        $sorties = $em->getRepository(Sortie::class)->findAll();
        // récupération des sites pour la liste déroulante(fitre)
        $sites = $em->getRepository(Site::class)->findAll();
        //récupération de l'utilisateur connecté
        $user = $this->getUser();
       // $sorties=$this->getUser()->getSorties();
        //$user =$em->getRepository(Inscription::class)->findByUser();






        return $this->render("affichage_sortie/list.html.twig",
            [
                'sorties' => $sorties,
                'sites' =>$sites,
                'user' =>$user,

            ]);
    }
}
