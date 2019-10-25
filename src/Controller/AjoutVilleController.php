<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjoutVilleController extends Controller
{

    /**
     * @Route("/ville/ajout", name="ville_ajout")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */

    public function add(Request $request, EntityManagerInterface $em)
    {

        // Récupération des villes déjà existantes pour les afficher
        $repo = $em->getRepository(Ville::class);
        $villes = $repo->findAll();

        // Gestion du formulaire
        $ville = new Ville();

        $form = $this->createForm(VilleType::class, $ville);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($ville);
            $em->flush();
            return $this->redirectToRoute('ville_ajout', array('villes' => $villes));

        }


        return $this->render('ajout_ville/ajoutVille.html.twig', [
            'villes' => $villes,
            'villeForm' => $form->createView()
        ]);


    }

    /**
     * @Route("/ville/supp/{id}", name="ville_supp")
     * @param Ville $ville
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */

    public function delete(Ville $ville, EntityManagerInterface $em)
    {

        // Ne supprime pas si au moins un lieu est associé à la ville en question
        if (count($ville->getLieux()) > 0) {
            $this->addFlash('error', "Des lieux sont associés à cette ville, supprimez-les d'abord !");
            return $this->redirectToRoute('ville_ajout');
        }

        $em->remove($ville);
        $em->flush();
        $this->addFlash("success", "La ville a bien été supprimée de notre base");
        return $this->redirectToRoute('ville_ajout');

    }


    public function update(Ville $ville, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "Ville modifiée");


        }

        return $this->redirectToRoute("ajout_ville/ville_modif.html.twig");
    }
}