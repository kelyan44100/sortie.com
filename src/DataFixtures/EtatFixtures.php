<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public const ETAT_REFERENCE1 = 'etat-ref1';
    public const ETAT_REFERENCE2 = 'etat-ref2';
    public const ETAT_REFERENCE3 = 'etat-ref3';
    public const ETAT_REFERENCE4 = 'etat-ref4';
    public const ETAT_REFERENCE5 = 'etat-ref5';
    public const ETAT_REFERENCE6 = 'etat-ref6';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $etat1 = new Etat();
        $etat1->setLibelle('Créée');
        $etat2 = new Etat();
        $etat2->setLibelle('Ouverte');
        $etat3 = new Etat();
        $etat3->setLibelle('Clôturée');
        $etat4 = new Etat();
        $etat4->setLibelle('En cours');
        $etat5 = new Etat();
        $etat5->setLibelle('Passée');
        $etat6 = new Etat();
        $etat6->setLibelle('Annulée');

        $manager->persist($etat1);
        $manager->persist($etat2);
        $manager->persist($etat3);
        $manager->persist($etat4);
        $manager->persist($etat5);
        $manager->persist($etat6);

        $manager->flush();
        $this->addReference(self::ETAT_REFERENCE1, $etat1);
        $this->addReference(self::ETAT_REFERENCE2, $etat2);
        $this->addReference(self::ETAT_REFERENCE3, $etat3);
        $this->addReference(self::ETAT_REFERENCE4, $etat4);
        $this->addReference(self::ETAT_REFERENCE5, $etat5);
        $this->addReference(self::ETAT_REFERENCE6, $etat6);

    }
}
