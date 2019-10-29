<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\ModifierSortieType;
use App\Repository\InscriptionRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
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

        //GESTION DES ETATS en fonction de la date
        $today = (new \DateTime('now'))->setTime(0, 0, 0);
        foreach ($sorties as $sortie) {
            if($sortie->getEtat()->getLibelle() !== 'Annulée'){
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
            } elseif (($sortie->getDateDebut() !== $today) && (count($sortie->getInscriptions()) !== 0) && (($sortie->getDateCloture() < $today) || (count($sortie->getInscriptions()) == $sortie->getNbInscription()))) {
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
            $sorties = $sortieRepository->findSortieByCriteria($siteSelect, $searchBar, $dateEntre, $dateEt);
            if ($sortOrg or $sortInsc or $sortPasInsc or $sortPass ){
                $sorties = $sortieRepository->findSortieByCheckbox($sortOrg, $sortInsc,$user, $sortPasInsc, $sortPass);
            }
            if ($sortInsc and $sortPasInsc){
                $sorties = $sortieRepository->findSortieByCheckbox($sortOrg, $sortInsc,$user, $sortPasInsc, $sortPass);
            }
            //($sortOrg and $sortInsc) or ($sortInsc and $sortPasInsc)
            //            or ($sortPasInsc and $sortPass) or ($sortOrg and $sortPass) or ($sortOrg and $sortPasInsc) or ($sortInsc and $sortPass)
            //            or ($sortOrg and $sortInsc and $sortPasInsc) or ($sortOrg and $sortInsc and $sortPass) or ($sortOrg and $sortInsc and $sortPasInsc and $sortPass)
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
     */
    public function modifierSortie(Sortie $Sortie, Request $request, EntityManagerInterface $manager, User $u, UserRepository $repo, VilleRepository $villeRepository)
    {
        $user = $repo->find($u);

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
            $Sortie->setOrganisateur($user);
            $Site = $Sortie->getOrganisateur()->getSite();
            $Sortie->setSite($Site);


            $today = (new \DateTime('now'))->setTime(0, 0, 0);

            if ($Sortie->getDateDebut() <= $Sortie->getDateCloture() || (count($Sortie->getInscriptions()) < $Sortie->getNbInscription())) {
                //ouvert
                $etat = $manager->getRepository(Etat::class)->find(1);
                $Sortie->setEtat($etat);
                $manager->persist($Sortie);
            }
            if ($Sortie->getDateDebut() == $today) {
                //En cours
                $etat = $manager->getRepository(Etat::class)->find(2);
                $Sortie->setEtat($etat);
                $manager->persist($Sortie);
            }
            if ($Sortie->getDateCloture() < $today || (count($Sortie->getInscriptions()) == $Sortie->getNbInscription())) {
                //cloturée
                $etat = $manager->getRepository(Etat::class)->find(3);
                $Sortie->setEtat($etat);
                $manager->persist($Sortie);
            }
            if (($Sortie->getDateDebut() < $today) && ($Sortie->getDateCloture() < $today)) {
                //passée
                $etat = $manager->getRepository(Etat::class)->find(4);
                $Sortie->setEtat($etat);
                $manager->persist($Sortie);
            }


            $manager->persist($Sortie);
            $manager->flush();

            //Messages gérés en session
            $this->addFlash('success', 'La sortie à bien été modifié');

            return $this->redirectToRoute('main');
        }
        return $this->render('affichage_sortie/modifierSortie.html.twig', [
            'formSortie' => $formSortie->createView(),
            'lieux' => $lieux,
            'sites' => $sites,
            'user' => $user,
            'villes' => $villeRepository->findAll(),

        ]);
    }
}
