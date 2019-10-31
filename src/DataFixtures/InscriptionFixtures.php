<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InscriptionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $ins1 = new Inscription();
        $ins1->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE1);
        $ins1->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE1);
        $ins1->setParticipant($participant);
        $manager->persist($ins1);

        $ins2 = new Inscription();
        $ins2->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE1);
        $ins2->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE2);
        $ins2->setParticipant($participant);
        $manager->persist($ins2);

        $ins3 = new Inscription();
        $ins3->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE2);
        $ins3->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE1);
        $ins3->setParticipant($participant);
        $manager->persist($ins3);

        $ins3 = new Inscription();
        $ins3->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE2);
        $ins3->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE3);
        $ins3->setParticipant($participant);
        $manager->persist($ins3);

        $ins3 = new Inscription();
        $ins3->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE2);
        $ins3->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE4);
        $ins3->setParticipant($participant);
        $manager->persist($ins3);

        $ins4 = new Inscription();
        $ins4->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE3);
        $ins4->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE1);
        $ins4->setParticipant($participant);
        $manager->persist($ins4);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE1);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE3);
        $ins5->setParticipant($participant);
        $manager->persist($ins1);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE5);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE1);
        $ins5->setParticipant($participant);
        $manager->persist($ins1);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE5);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE2);
        $ins5->setParticipant($participant);
        $manager->persist($ins1);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE5);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE3);
        $ins5->setParticipant($participant);
        $manager->persist($ins1);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE8);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE1);
        $ins5->setParticipant($participant);
        $manager->persist($ins5);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE8);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE2);
        $ins5->setParticipant($participant);
        $manager->persist($ins5);

        $ins5 = new Inscription();
        $ins5->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE8);
        $ins5->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE3);
        $ins5->setParticipant($participant);
        $manager->persist($ins5);

        $ins6 = new Inscription();
        $ins6->setDateInscription((new \DateTime('now'))->setTime(0,0,0));
        $sortie=$this->getReference(SortieFixtures::SORTIE_REFERENCE8);
        $ins6->setSortie($sortie);
        $participant=$this->getReference(UserFixtures::USER_REFERENCE4);
        $ins6->setParticipant($participant);
        $manager->persist($ins6);

        $manager->flush();

    }
}
