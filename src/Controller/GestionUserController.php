<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class GestionUserController extends Controller
{
    /**
     * @Route("/admin/listUser/{page}", name="list_users", defaults={"page"=1})
     */
    public function listUsers(EntityManagerInterface $em, $page){
        $nbArticlesParPage = 5;
        $users =$em->getRepository(User::class)->findAllByPage($page, $nbArticlesParPage);
        //$users = $repo->findAll();
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($users) / $nbArticlesParPage),
            'nomRoute' => 'list_users',
            'paramsRoute' => array()
        );
        return $this->render('gestion_user/listUsers.html.twig', [
            'pagination' => $pagination,
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
    public function deactivateUser(User $u, EntityManagerInterface $em){
        $user = $em->getRepository(User::class)->find($u);
        $user->setActif(false);
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'Désactivation réussie!');
        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/admin/activateUser/{id}", name="activate_user", requirements={"id":"\d+"})
     */
    public function activateUser(User $u, EntityManagerInterface $em){
        $user = $em->getRepository(User::class)->find($u);
        $user->setActif(true);
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'Activation réussie!');
        return $this->redirectToRoute('list_users');
    }
}
