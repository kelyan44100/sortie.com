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
     * @Route("/site/ajout/{page}", name="site_ajout", defaults={"page"=1})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */

    public function add(Request $request, EntityManagerInterface $em, $page){
        $nbArticlesParPage = 5;
        // Récupération des sites déja existants pour les afficher
        $sites = $em->getRepository(Site::class)->findAllByPage($page, $nbArticlesParPage);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($sites) / $nbArticlesParPage),
            'nomRoute' => 'site_ajout',
            'paramsRoute' => array()
        );

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
            'pagination' => $pagination,
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

         // Ne supprime pas si au moins une sortie est associée au site en question
         if(count($site->getSorties()) > 0){
             $this->addFlash('error', "Certaines sorties sont encore prévues pour ce site, impossible de le supprimer !");
             return $this->redirectToRoute('site_ajout');
         }

         $em->remove($site);
         $em->flush();
         $this->addFlash("success", "Le site a bien été supprimé");
         return $this->redirectToRoute('site_ajout');

     }


    /**
     * @param Site $site
     * @param Request $request
     * @param EntityManagerInterface $em
     * @Route("/site/update/{id}", name="site_update", requirements={"id":"\d+"})
     * @return RedirectResponse|Response
     *
     */

    public function update(Site $site, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($site);
            $em->flush();

            $this->addFlash("success", "Site modifié");
            return $this->redirectToRoute('site_ajout');

        }

        return $this->render('ajout_site/site_modif.html.twig', [
            'siteForm' => $form->createView()
        ]);
    }


}
