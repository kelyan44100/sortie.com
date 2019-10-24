<?php

namespace App\Controller;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\CreationSortieType;
use App\Repository\LieuRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends Controller
{
    /**
     * @Route("/creation/sortie", name="creation_sortie")
     */
    public function index()
    {
        return $this->render('creation_sortie/index.html.twig', [
            'controller_name' => 'CreationSortieController',
        ]);
    }

    /**
     * @Route("/Creation/add/{id}", name="Creation_add", requirements={"id":"\d+"})
     */
    public function add(Request $request, EntityManagerInterface $manager, User $u, UserRepository $repo, VilleRepository $villeRepository)
    {

        $user = $repo->find($u);
        $Sortie = new Sortie();
        $formSortie = $this->createForm(CreationSortieType::class, $Sortie);
        $villes = $manager->getRepository(Ville::class)->findAll();
        $lieux = $manager->getRepository(Lieu::class)->findBy([], ['rue' => 'ASC']);
        $sites = $manager->getRepository(Site::class)->findAll();
        //Associe la requête et le FormType
        $formSortie->handleRequest($request);

        //Test de la validation du formulaire
        if ($formSortie->isSubmitted() && $formSortie->isValid()) {
            dump($Sortie);
            $manager->persist($Sortie);
            $manager->flush();

            //Messages gérés en session
            $this->addFlash('success', 'La série a été ajoutée');

            return $this->redirectToRoute('main');
        }
        return $this->render('creation_sortie/index.html.twig', [
            'formSortie' => $formSortie->createView(),
//            'villes' => $villes,
            'lieux' => $lieux,
            'sites' => $sites,
            'user' => $user,
            'villes' => $villeRepository->findAll(),
        ]);
    }


}