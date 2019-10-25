<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax/{id}", name="ajax")
     */
    public function index(Ville $ville, LieuRepository $lieuRepository)
    {
        $lieux = $lieuRepository->findBy([
            'ville' => $ville
        ]);

        return new JsonResponse($lieux);
    }

    /**
     * @Route("/ajax2/{id}", name="ajax2")
     */
    public function rueByLieu(Lieu $lieu, LieuRepository $lieuRepository){

        $rue = $lieuRepository->findOneBy([
            'id' => $lieu
        ]);

        return new JsonResponse($rue);

    }

    /**
     * @Route("/ajax3/{id}", name="ajax3")
     */
    public function cpByLieu(Ville $ville, VilleRepository $villeRepository){

        $cp = $villeRepository->findOneBy([
            'id' => $ville
        ]);

        return new JsonResponse($cp);

    }

}
