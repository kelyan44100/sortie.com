<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(EntityManagerInterface $em, Request $request, SiteRepository $siteRepository, SortieRepository $sortieRepository){
        // récupération de toutes les sorties
        $sorties = $em->getRepository(Sortie::class)->findAll();
        // récupération des sites pour la liste déroulante(fitre)
        $sites = $em->getRepository(Site::class)->findAll();
        //récupération de l'utilisateur connecté
        $user = $this->getUser();

        //GESTION DES ETATS en fonction de la date
        $today = (new \DateTime('now'))->setTime(0,0,0);
        foreach ($sorties as $sortie){

            if (($sortie->getDateDebut()>= $sortie-> getDateCloture()) && (count($sortie->getInscriptions()) < $sortie->getNbInscription()) && ($sortie-> getDateCloture()>$today)){
                //ouvert

                $etat = $em ->getRepository(Etat::class)->findOneBy(['libelle'=>'Ouverte']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
            elseif (($sortie->getDateDebut()==$today) && (((count($sortie->getInscriptions()) > 0)) || (count($sortie->getInscriptions()) == $sortie->getNbInscription()))) {

                //En cours
                $etat = $em ->getRepository(Etat::class)->findOneBy(['libelle'=>'En cours']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
           elseif (($sortie->getDateDebut()!==$today) && (count($sortie->getInscriptions()) !== 0) && (($sortie-> getDateCloture() < $today) || (count($sortie->getInscriptions()) == $sortie->getNbInscription()))){
               //cloturée

                $etat = $em ->getRepository(Etat::class)->findOneBy(['libelle'=>'Clôturée']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
            else{
                //Passée
                $etat = $em ->getRepository(Etat::class)->findOneBy(['libelle'=>'Passée']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
        }

        return $this->render("affichage_sortie/list.html.twig",
            [
                'sorties' => $sorties,
                'sites' =>$sites,
                'user' =>$user,

            ]);
    }
}
