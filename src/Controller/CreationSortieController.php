<?php

namespace App\Controller;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\CreationSortieType;
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
        return $this->render('creation_sortie/index.html.twig', [
            'controller_name' => 'CreationSortieController',
        ]);
    }

    /**
     * @Route("/Creation/add", name="Creation_add")
     */
    public function add(Request $request, EntityManagerInterface $manager)
    {
        $Sortie = new Sortie();
        $Lieu = new Lieu();
        $formSortie = $this->createForm(CreationSortieType::class, $Sortie);
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
            'formSortie' => $formSortie->createView()
        ]);
    }
}
