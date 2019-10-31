<?php

namespace App\Controller;


use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjoutVilleController extends Controller
{

    /**
     * @Route("/ville/ajout/{page}", name="ville_ajout",defaults={"page"=1})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */

    public function add(Request $request, EntityManagerInterface $em, $page)
    {
        $nbArticlesParPage = 5;
        // Récupération des villes déjà existantes pour les afficher
        $villes = $em->getRepository(Ville::class)->findAllByPage($page, $nbArticlesParPage);
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($villes) / $nbArticlesParPage),
            'nomRoute' => 'ville_ajout',
            'paramsRoute' => array()
        );

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
            'pagination' => $pagination,
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

    /**
     * @param Ville $ville
     * @param Request $request
     * @param EntityManagerInterface $em
     * @Route("/ville/update/{id}", name="ville_update", requirements={"id":"\d+"})
     * @return RedirectResponse|Response
     *
     */

    public function update(Ville $ville, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "Ville modifiée");
            return $this->redirectToRoute('ville_ajout');
        }

        return $this->render('ajout_ville/villeModif.html.twig', [
        'villeForm' => $form->createView()
        ]);
    }
}