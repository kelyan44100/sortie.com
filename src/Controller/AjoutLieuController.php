<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AjoutLieuController extends Controller
{
    /**
     * @Route("/lieu/ajout", name="ajout_lieu")
     */
    public function add(Request $request, EntityManagerInterface $em, VilleRepository $villeRepository)
    {
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class,$lieu);
        $form->handleRequest($request);
        $user = $this->getUser();
        $villes = $villeRepository->findAll();

        if($form->isSubmitted() && $form->isValid()){
            $ville = $form->get('ville')->getData();
            $lieu->setVille($ville);
            $em->persist($lieu);
            $em->flush();

            $this->addFlash('success', 'Le lieu a été enregistré!');
            return $this->redirectToRoute('ajout_lieu');
        }

        return $this->render('ajout_lieu/ajoutLieu.html.twig', [
            'lieuForm'=>$form->createView(),
            'villes' => $villes,
            'user'=>$user,
        ]);
    }


}
