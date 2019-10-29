<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Sortie;
use App\Form\FormAnnulationType;
use App\Form\ModifierSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends Controller
{


    /**
     * @Route("/sorties/inscription/{id}", name="sortie_inscription", requirements={"id": "\d+"})
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return RedirectResponse
     * @throws Exception
     */
    public function subscribe(Sortie $sortie,EntityManagerInterface $em ){

        $inscription = new Inscription();
        //participant (utilisateur courant)
        $participant = $this->getUser();
        //date d'inscription (aujourd'hui)
        $today = (new \DateTime('now'))->setTime(0,0,0);


        $inscription->setSortie($sortie);
        $inscription->setParticipant($participant);
        $inscription->setDateInscription($today);

        //update de la sortie
        $nbInscriptions = $sortie->getNbInscription();
        $sortie->setNbInscription($nbInscriptions+1);

        $em->persist($inscription);
        $em->flush();

        $this->addFlash("success", "Inscription réussie !");

        return $this->redirectToRoute('sortie_list');

    }

    /**
     * @Route("/sorties/desinscription/{id}", name="sortie_desinscription", requirements={"id": "\d+"})
     * @param Sortie $sortie
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */

    public function unsubscribe(Sortie $sortie, EntityManagerInterface $em){
        //participant (utilisateur courant)
        $participant = $this->getUser();
        foreach ($sortie->getInscriptions() as $inscription){
            if($participant == $inscription->getParticipant()){
                $em->remove($inscription);
                $em->flush();
            }
        }

        $this->addFlash("success", "Désistement réussi");
        return $this->redirectToRoute('sortie_list');
    }



}
