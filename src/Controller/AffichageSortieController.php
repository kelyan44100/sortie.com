<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\FormAnnulationType;
use App\Form\ModifierSortieType;
use App\Repository\InscriptionRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AffichageSortieController extends Controller
{

    /**
     * @param EntityManagerInterface $em
     *
     * @param Request $request
     * @param SiteRepository $siteRepository
     * @param SortieRepository $sortieRepository
     * @return Response
     * @throws \Exception
     * @Route("/sorties/list/", name="sortie_list")
     *
     */
    public function list(EntityManagerInterface $em, Request $request, SiteRepository $siteRepository, SortieRepository $sortieRepository)
    {
        // récupération de toutes les sorties
        $sorties = $em->getRepository(Sortie::class)->findAll();
        // récupération des sites pour la liste déroulante(fitre)
        $sites = $em->getRepository(Site::class)->findAll();
        //récupération de l'utilisateur connecté
        $user = $this->getUser();
        $siteSelect = $request->request->get("site-select");
        $searchBar = $request->request->get("search-bar");
        $dateEntre = $request->request->get("date-entre");
        $dateEt = $request->request->get("date-et");
        $sortOrg = $request->request->get("sortOrg");
        $sortInsc = $request->request->get("sortInsc");
        $sortPasInsc = $request->request->get("sortPasInsc");
        $sortPass = $request->request->get("sortPass");

        // Date d'archivage
        $oneMonthAgo = ((new \DateTime('now -1 month'))->setTime(0,0,0));

        //GESTION DES ETATS en fonction de la date
        $today = (new \DateTime('now'))->setTime(0, 0, 0);
        foreach ($sorties as $sortie) {
            if(($sortie->getEtat()->getLibelle() !== 'Annulée') and ($sortie->getEtat()->getLibelle() !== 'Créée')){
            if (($sortie->getDateDebut() >= $sortie->getDateCloture()) && (count($sortie->getInscriptions()) < $sortie->getNbInscription()) && ($sortie->getDateCloture() > $today)) {
                //ouvert

                $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            } elseif (($sortie->getDateDebut() == $today) && (((count($sortie->getInscriptions()) > 0)) || (count($sortie->getInscriptions()) == $sortie->getNbInscription()))) {

                //En cours
                $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'En cours']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            } elseif (($sortie->getDateDebut() !== $today) && (count($sortie->getInscriptions()) !== 0) && (($sortie->getDateCloture() <= $today) || (count($sortie->getInscriptions()) == $sortie->getNbInscription()))) {
                //cloturée

                $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Clôturée']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            } else {
                //Passée
                $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Passée']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
            }
            $em->flush();
        }
        }
        //Récupération des toutes les filtres
        if($request->request->get("site-select") or $request->request->get("search-bar") or $request->request->get("date-entre") or $request->request->get("date-et")
        or $request->request->get("sortOrg") or $request->request->get("sortInsc") or $request->request->get("sortPasInsc") or $request->request->get("sortPass")){
        dump($dateEntre);
        /* Filtres sur les sorties*/
            $sorties = $sortieRepository->findSortieByCriteria($siteSelect, $searchBar, $dateEntre, $dateEt, $sortOrg, $sortInsc,$user, $sortPasInsc, $sortPass);
           /* if ($sortOrg or $sortInsc or $sortPasInsc or $sortPass ){
                $sorties = $sortieRepository->findSortieByCheckbox();
            }*/

        }

        return $this->render("affichage_sortie/list.html.twig",
            [
                'sorties' => $sorties,
                'sites' => $sites,
                'user' => $user,
                'select' => $siteSelect,
                'searchBar' => $searchBar,
                'dateEntre' => $dateEntre,
                'dateEt' => $dateEt,
                'sortOrg' => $sortOrg,
                'sortInsc' => $sortInsc,
                'sortPasInsc' => $sortPasInsc,
                'sortPass' =>$sortPass,
                'oneMonthAgo' => $oneMonthAgo

            ]);
    }

    /**
     * @Route("/sorties/{id}", name="sortie_detail", requirements={"id": "\d+"})
     */

    public function detail(int $id, InscriptionRepository $InscriptionRepository, EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Sortie::class);
        $sortie = $repo->find($id);

        $inscriptions = $InscriptionRepository->findBy([
            'sortie' => $sortie,
        ]);

        dump($inscriptions);

        return $this->render("affichage_sortie/detail.html.twig", [
            "sortie" => $sortie,
            'inscriptions' => $inscriptions
        ]);
    }

    /**
     * @Route("/modifierSortie/{id}", name="modifier_Sortie", requirements={"id":"\d+"})
     * @param Sortie $Sortie
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserRepository $repo
     * @param VilleRepository $villeRepository
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function modifierSortie(Sortie $Sortie, Request $request, EntityManagerInterface $manager, UserRepository $repo, VilleRepository $villeRepository)
    {
        $user = $this->getUser();



        $formSortie = $this->createForm(ModifierSortieType::class, $Sortie);
        $lieux = $manager->getRepository(Lieu::class)->findBy([], ['rue' => 'ASC']);
        $sites = $manager->getRepository(Site::class)->findAll();
        //Associe la requête et le FormType
        $formSortie->handleRequest($request);
        //Test de la validation du formulaire
        if ($formSortie->isSubmitted() && $formSortie->isValid()) {
            dump($Sortie);
            dump($Sortie->getOrganisateur());
            $user = $this->getUser();
            $Site = $Sortie->getOrganisateur()->getSite();
            $Sortie->setSite($Site);

            $manager->persist($Sortie);
            $manager->flush();

            //Messages gérés en session
            $this->addFlash('success', 'La sortie à bien été modifiée');

            return $this->redirectToRoute('sortie_list');
        }
        return $this->render('affichage_sortie/modifierSortie.html.twig', [
            'formSortie' => $formSortie->createView(),
            'lieux' => $lieux,
            'sites' => $sites,
            'user' => $user,
            'villes' => $villeRepository->findAll(),


        ]);
    }

    /**
     * @Route("/annulerSortie/{id}", name="annuler_sortie", requirements={"\d+"})
     * @param Sortie $sortie
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */

    public function annulerSortie( Sortie $sortie, Request $request, EntityManagerInterface $em){
        $etat = $em->getRepository(Etat::class)->find(6);
        $formAnnulation = $this->createForm(FormAnnulationType::class, $sortie);
        $formAnnulation->handleRequest($request);
        if($formAnnulation->isSubmitted() && $formAnnulation->isValid()){
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'La sortie a été annulée');
            return $this->redirectToRoute('sortie_list');
        }

        return $this->render('affichage_sortie/annulerSortie.html.twig', [
            'formAnnulation' => $formAnnulation->createView()
        ]);
    }

    /**
     * @Route("/sorties/publier/{id}", name="publier_sortie", requirements={"id": "\d+"})
     */

    public function publierSortie(Sortie $sortie, EntityManagerInterface $em){
        $etat = $em->getRepository(Etat::class)->find(2);
        $sortie->setEtat($etat);
        $em->persist($sortie);
        $em->flush();
        $this->addFlash('success', 'Sortie publiée');
        return $this->redirectToRoute('sortie_list');
    }
}
