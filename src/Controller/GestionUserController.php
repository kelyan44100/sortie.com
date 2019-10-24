<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class GestionUserController extends Controller
{
    /**
     * @Route("/admin/listUser", name="list_users")
     */
    public function listUsers(UserRepository $repo){
        $users = $repo->findAll();
        return $this->render('gestion_user/listUsers.html.twig', [
            'users' =>$users
        ]);
    }

    /**
     * @Route("/admin/deleteUser/{id}", name="delete_user", requirements={"id":"\d+"})
     */
    public function deleteUser(ObjectManager $manager, UserRepository $repo, User $u){
        if (sizeof($u->getInscriptions())==0 && sizeof($u->getSorties())==0){
            $user = $repo->find($u);
            $manager ->remove($user);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès!' );

        }else{
            $this->addFlash('warning', 'cet utilisateur est encore inscrit à une sortie ou il a une sortie en cours!' );

        }
        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/admin/deactivateUser/{id}", name="deactivate_user", requirements={"id":"\d+"})
     */
    public function deactivateUser(ObjectManager $manager, UserRepository $repo, User $u){

    }
}
