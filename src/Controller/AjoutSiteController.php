<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjoutSiteController extends Controller
{


    /**
     * @Route("/site/ajout", name="site_ajout")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */

    public function add(Request $request, EntityManagerInterface $em){

        // Récupération des sites déja existants pour les afficher
        $repo = $em->getRepository(Site::class);
        $sites = $repo->findAll();

        //gestion du formulaire
        $site = new Site();

        $form = $this->createForm(SiteType::class, $site);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($site);
            $em->flush();
            return $this->redirectToRoute('site_ajout', array('sites'=>$sites));

        }


        return $this->render('ajout_site/ajoutSite.html.twig', [
            'sites' => $sites,
            'siteForm' => $form->createView()
        ]);

    }


    /**
     * @Route("/sites/supp/{id}", name="site_supp")
     * @param Site $site
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */

     public function delete(Site $site, EntityManagerInterface $em){

         $em->remove($site);
         $em->flush();
         $this->addFlash("success", "Le site a bien été supprimé");
         return $this->redirectToRoute('site_ajout');

     }



}