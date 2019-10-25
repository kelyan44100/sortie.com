<?php

namespace App\Controller;

use App\Entity\Etat;
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

        //GESTION DES ETATS en fonction de la date
        $today = new \DateTime('now');
        foreach ($sorties as $sortie){

           if ($sortie-> getDateCloture() < $today && $sortie-> getDateDebut()<$today){
               //cloturée
                $etat = $em ->getRepository(Etat::class)->find(3);
                dump($etat);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }

            if ($sortie->getDateDebut()<$today ){
                //passée
                $etat = $em ->getRepository(Etat::class)->find(4);
                $sortie->setEtat($etat);
                dump($etat);
                $em->persist($sortie);

            }
            if ($sortie->getDateDebut()>$today ){
                //ouvert
                $etat = $em ->getRepository(Etat::class)->find(1);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
            if ($sortie->getDateDebut()==$today){
                //En cours
                $etat = $em ->getRepository(Etat::class)->find(2);
                dump($etat);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
            $em->flush();
           // $sortie->getDateDebut()> $today->format('d/m/Y')
        }

        $em->persist($sortie);
        $em->flush();



        return $this->render("affichage_sortie/list.html.twig",
            [
                'sorties' => $sorties,
                'sites' =>$sites,
                'user' =>$user,

            ]);
    }
}
