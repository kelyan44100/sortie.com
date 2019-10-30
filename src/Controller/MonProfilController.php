<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MonProfilType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class MonProfilController extends Controller
{
    /**
     * @Route("/profil/monProfil", name="profil")
     */
    public function monProfil(){
        $user = $this->getUser();
        return $this->render('profil/monProfil.html.twig', ['user'=>$user] );
    }

    /**
     * @Route("/profil/{id}", name="profil_user", requirements={"id":"\d+"} )
     */
    public function profil(EntityManagerInterface $em, User $u){
        $repo = $em->getRepository(User::class);
        $user = $repo->find($u);
        return $this->render('profil/profil.html.twig', ['user'=>$user] );
    }

    /**
     * @Route("/profil/monProfil/update/", name="mon_profil_update")
     */
    public function updateMonProfil(Request $request, ObjectManager $manager, UserRepository $repo, UserPasswordEncoderInterface $passwordEncoder){

        $user = $this->getUser();

        $formMonProfil = $this->createForm(MonProfilType::class,$user);
        $formMonProfil->handleRequest($request);

        if ($formMonProfil->isSubmitted() && $formMonProfil->isValid()){
            $error=false;
            $photo = $formMonProfil->get('fileTemp')->getData();


            $oldPassword = $formMonProfil->get('oldPassword')->getData();


            dump($oldPassword);
            if (!$passwordEncoder->isPasswordValid($user, $oldPassword)) {

                $error = true;
                $formMonProfil->get('oldPassword')->addError(new FormError('Ancien mot de passe incorrect'));
            }

            if($photo != null && !in_array(strtolower($photo->getClientOriginalExtension()),
                    $this->getParameter('media_extension_photo'))){
                $formMonProfil->get('fileTemp')->addError(
                    new FormError('La photo n\'est pas au bon format : '. implode(', ', $this->getParameter('media_extension_photo'))));
                $error = true;
            }

            if(!$error){
                if(!empty($formMonProfil->get('passwordPlain')->getData())) {
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $formMonProfil->get('passwordPlain')->getData()
                        )
                    );
                }

                if(!is_null($photo)) {
                    $filePhoto = sprintf('photo_%s.%s', md5(uniqid(mt_rand(), true)), strtolower($photo->getClientOriginalExtension()));
                    $photo->move($this->getParameter('web_photo'), $filePhoto);

                    $user->setFile($filePhoto);
                    $manager->flush();
                }

                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Your profile successfully updated!' );
                //return $this->redirectToRoute('profil');
            }else{
                $this->addFlash('warning', 'Une erreur est arriver' );
            }
        }
        return $this->render('profil/updateMonProfil.html.twig', [
            'user'=>$user,
            'formMonProfil'=>$formMonProfil->createView()
        ]);
    }


    /*/**
     * @Route("/monProfil/file/{id}", name="mon_profil_file")
     */
   /* public function fichier(User $u){
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

    }*/
}
