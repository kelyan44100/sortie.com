<?php

namespace App\Controller;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\CreationSortieType;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends Controller
{
    /**
     * @Route("/creation/sortie", name="creation_sortie")
     */
    public function index()
    {
        return $this->render('creation_sortie/creationSortie.html.twig', [
            'controller_name' => 'CreationSortieController',
        ]);
    }

    /**
     * @Route("/Creation/add", name="Creation_add")
     */
    public function add(Request $request, EntityManagerInterface $manager, UserRepository $repo, VilleRepository $villeRepository)
    {

        $user = $this->getUser();
        $Sortie = new Sortie();
        $etat = $manager->getRepository(Etat::class)->find(1);
        $formSortie = $this->createForm(CreationSortieType::class, $Sortie);
        $lieux = $manager->getRepository(Lieu::class)->findBy([], ['rue' => 'ASC']);
        $sites = $manager->getRepository(Site::class)->findAll();
        //Associe la requête et le FormType
        $formSortie->handleRequest($request);

        //Test de la validation du formulaire
        if ($formSortie->isSubmitted() && $formSortie->isValid()) {
            $user = $this->getUser();
            $Sortie->setOrganisateur($user);
            $Site = $Sortie->getOrganisateur()->getSite();
            $Sortie->setSite($Site);
            $Sortie->setEtat($etat);
        
            $manager->persist($Sortie);
            $manager->flush();

            //Messages gérés en session
            $this->addFlash('success', 'La sortie a été ajoutée');

            return $this->redirectToRoute('sortie_list');
        }
        return $this->render('creation_sortie/creationSortie.html.twig', [
            'formSortie' => $formSortie->createView(),
            'lieux' => $lieux,
            'sites' => $sites,
            'user' => $user,
            'villes' => $villeRepository->findAll(),
        ]);
    }


}