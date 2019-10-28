<?php

namespace App\DataFixtures;

use App\Entity\Sortie;

use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class SortieFixtures extends Fixture
{
    public const SORTIE_REFERENCE1 = 'sortie-ref1';
    public const SORTIE_REFERENCE2 = 'sortie-ref2';
    public const SORTIE_REFERENCE3 = 'sortie-ref3';
    public const SORTIE_REFERENCE4 = 'sortie-ref4';
    public const SORTIE_REFERENCE5 = 'sortie-ref5';
    public const SORTIE_REFERENCE6 = 'sortie-ref6';
    public const SORTIE_REFERENCE7 = 'sortie-ref7';
    public const SORTIE_REFERENCE8 = 'sortie-ref8';

    public function load(ObjectManager $manager)
    {
        $sortie1 = new Sortie();
        $sortie1->setNom('Bar bar');
        $sortie1->setDateDebut((new \DateTime('now +3 days'))->setTime(0,0,0));
        $sortie1->setDuree(3);
        $sortie1->setDateCloture((new \DateTime('now +1 day'))->setTime(0,0,0));
        $sortie1->setNbInscription(2);
        $sortie1->setDescription('Boire un coup dans un bar');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE3);
        $sortie1->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE1);
        $sortie1->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE1);
        $sortie1->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE1);
        $sortie1->setOrganisateur($organisateur);

        $sortie2 = new Sortie();
        $sortie2->setNom('Parc Astérix');
        $sortie2->setDateDebut((new \DateTime('now +13 days'))->setTime(0,0,0));
        $sortie2->setDuree(2);
        $sortie2->setDateCloture((new \DateTime('now +5 days'))->setTime(0,0,0));
        $sortie2->setNbInscription(3);
        $sortie2->setDescription('Parc d\'attraction');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE2);
        $sortie2->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE2);
        $sortie2->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE3);
        $sortie2->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE2);
        $sortie2->setOrganisateur($organisateur);

        $sortie3 = new Sortie();
        $sortie3->setNom('24h du mans');
        $sortie3->setDateDebut((new \DateTime('now +5 days'))->setTime(0,0,0));
        $sortie3->setDuree(72);
        $sortie3->setDateCloture((new \DateTime('now -2 days'))->setTime(0,0,0));
        $sortie3->setNbInscription(4);
        $sortie3->setDescription('Course de moto avec hôtel');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE3);
        $sortie3->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE3);
        $sortie3->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE4);
        $sortie3->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE3);
        $sortie3->setOrganisateur($organisateur);

        $sortie4 = new Sortie();
        $sortie4->setNom('Gagner à l\'euro Millions');
        $sortie4->setDateDebut((new \DateTime('now'))->setTime(0,0,0));
        $sortie4->setDuree(30);
        $sortie4->setDateCloture((new \DateTime('now -4 days'))->setTime(0,0,0));
        $sortie4->setNbInscription(3);
        $sortie4->setDescription('190 millions €');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE3);
        $sortie4->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE2);
        $sortie4->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE3);
        $sortie4->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE3);
        $sortie4->setOrganisateur($organisateur);

        $sortie5 = new Sortie();
        $sortie5->setNom('Voyage Dubai');
        $sortie5->setDateDebut((new \DateTime('now'))->setTime(0,0,0));
        $sortie5->setDuree(480);
        $sortie5->setDateCloture((new \DateTime('now -7 days'))->setTime(0,0,0));
        $sortie5->setNbInscription(10);
        $sortie5->setDescription('Course de moto avec hôtel');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE4);
        $sortie5->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE1);
        $sortie5->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE1);
        $sortie5->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE2);
        $sortie5->setOrganisateur($organisateur);

        $sortie6 = new Sortie();
        $sortie6->setNom('Concert');
        $sortie6->setDateDebut((new \DateTime('now +8 days'))->setTime(0,0,0));
        $sortie6->setDuree(72);
        $sortie6->setDateCloture((new \DateTime('now +1 days'))->setTime(0,0,0));
        $sortie6->setNbInscription(25);
        $sortie6->setDescription('Au zenith de Nantes');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE2);
        $sortie6->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE2);
        $sortie6->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE2);
        $sortie6->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE3);
        $sortie6->setOrganisateur($organisateur);

        $sortie7 = new Sortie();
        $sortie7->setNom('Sortie ');
        $sortie7->setDateDebut((new \DateTime('now -9 days'))->setTime(0,0,0));
        $sortie7->setDuree(56);
        $sortie7->setDateCloture((new \DateTime('now -19 days'))->setTime(0,0,0));
        $sortie7->setNbInscription(5);
        $sortie7->setDescription('Au zenith de Nantes');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE3);
        $sortie7->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE2);
        $sortie7->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE2);
        $sortie7->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE1);
        $sortie7->setOrganisateur($organisateur);

        $sortie8 = new Sortie();
        $sortie8->setNom('Pizza');
        $sortie8->setDateDebut((new \DateTime('now +13 days'))->setTime(0,0,0));
        $sortie8->setDuree(48);
        $sortie8->setDateCloture((new \DateTime('now +5 days'))->setTime(0,0,0));
        $sortie8->setNbInscription(4);
        $sortie8->setDescription('Soirée Pizza');
        $etat = $this->getReference(EtatFixtures::ETAT_REFERENCE2);
        $sortie8->setEtat($etat);
        $lieu = $this->getReference(LieuFixtures::LIEU_REFERENCE2);
        $sortie8->setLieu($lieu);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE3);
        $sortie8->setSite($site);
        $organisateur = $this->getReference(userFixtures::USER_REFERENCE2);
        $sortie8->setOrganisateur($organisateur);

        $manager->persist($sortie1);
        $manager->persist($sortie2);
        $manager->persist($sortie3);
        $manager->persist($sortie4);
        $manager->persist($sortie5);
        $manager->persist($sortie6);
        $manager->persist($sortie7);
        $manager->persist($sortie8);
        $manager->flush();

        $this->addReference(self::SORTIE_REFERENCE1, $sortie1);
        $this->addReference(self::SORTIE_REFERENCE2, $sortie2);
        $this->addReference(self::SORTIE_REFERENCE3, $sortie3);
        $this->addReference(self::SORTIE_REFERENCE4, $sortie4);
        $this->addReference(self::SORTIE_REFERENCE5, $sortie5);
        $this->addReference(self::SORTIE_REFERENCE6, $sortie6);
        $this->addReference(self::SORTIE_REFERENCE7, $sortie7);
        $this->addReference(self::SORTIE_REFERENCE8, $sortie8);
    }
}
