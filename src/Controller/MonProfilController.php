<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MonProfilType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MonProfilController extends Controller
{
    /**
     * @Route("/monProfil", name="mon_profil")
     */
    public function monProfil(){
        $user = $this->getUser();
        return $this->render('mon_profil/monProfil.html.twig', ['user'=>$user] );
    }


    /**
     * @Route("/monProfil/update/{id}", name="mon_profil_update", requirements={"id":"\d+"})
     */
    public function updateMonProfil(Request $request, ObjectManager $manager, UserRepository $repo, User $u,UserPasswordEncoderInterface $passwordEncoder){

        $user = $repo->find($u);
        //$nom_site->setNomSite($user->getSite());
        $formMonProfil = $this->createForm(MonProfilType::class,$user);
        $formMonProfil->handleRequest($request);
        if ($formMonProfil->isSubmitted() && $formMonProfil->isValid()){
            $error=false;
            if(!$error){
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $formMonProfil->get('password')->getData()
                    )
                );
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Your profile successfully updated!' );
                return $this->redirectToRoute('mon_profil');
            }else{
                $this->addFlash('warning', 'One errors occurred, on profile update!' );
            }
        }
        return $this->render('mon_profil/updateMonProfil.html.twig', [
            'formMonProfil'=>$formMonProfil->createView()
        ]);
    }

    /**
     * @Route("/monProfil/file/{id}", name="mon_profil_file")
     */
    public function fichier(User $u){
        $dir = $this->getParameter('download_dir');
        if(strlen(trim($u->getFile())) > 0 && file_exists($dir . $u->getFile())) {

            // this is needed to safely include the file name as part of the URL
            $safeFilename = \transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $idea->getTitle());

            $f = explode('.', $u->getFile());
            $extension = strtolower($f[count($f) - 1]);

            $nameFile = $safeFilename.'.'.$extension;

            $file = new File($dir . $u->getFile());

            return $this->file($file, $nameFile);
        }
        else{
            throw $this->createNotFoundException("File not found");
        }

    }
}