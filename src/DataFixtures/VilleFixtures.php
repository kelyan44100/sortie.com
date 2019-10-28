<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public const VILLE_REFERENCE1 = 'ville-ref1';
    public const VILLE_REFERENCE2 = 'ville-ref2';
    public const VILLE_REFERENCE3 = 'ville-ref3';
    public const VILLE_REFERENCE4 = 'ville-ref4';
    public const VILLE_REFERENCE5 = 'ville-ref5';
    public const VILLE_REFERENCE6 = 'ville-ref6';
    public const VILLE_REFERENCE7 = 'ville-ref7';
    public const VILLE_REFERENCE8 = 'ville-ref8';
    public const VILLE_REFERENCE9 = 'ville-ref9';
    public const VILLE_REFERENCE10 = 'ville-ref10';
    public const VILLE_REFERENCE11 = 'ville-ref11';
    public const VILLE_REFERENCE12 = 'ville-ref12';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ville1 = new Ville();
        $ville1->setNomVille('Alençon');
        $ville1->setCodePostal('61000');
        $manager->persist($ville1);

        $ville2 = new Ville();
        $ville2->setNomVille('Angers');
        $ville2->setCodePostal('49000');
        $manager->persist($ville2);

        $ville3 = new Ville();
        $ville3->setNomVille('Brest');
        $ville3->setCodePostal('29200');
        $manager->persist($ville3);

        $ville4 = new Ville();
        $ville4->setNomVille('Caen');
        $ville4->setCodePostal('14000');
        $manager->persist($ville4);

        $ville5 = new Ville();
        $ville5->setNomVille('La Roche-Sur-Yon');
        $ville5->setCodePostal('85000');
        $manager->persist($ville5);

        $ville6 = new Ville();
        $ville6->setNomVille('Lorient');
        $ville6->setCodePostal('56100');
        $manager->persist($ville6);

        $ville7 = new Ville();
        $ville7->setNomVille('Nantes');
        $ville7->setCodePostal('44000');
        $manager->persist($ville7);

        $ville8 = new Ville();
        $ville8->setNomVille('Saint-Brieuc');
        $ville8->setCodePostal('22000');
        $manager->persist($ville8);

        $ville9 = new Ville();
        $ville9->setNomVille('Vannes');
        $ville9->setCodePostal('56000');
        $manager->persist($ville9);

        $ville10= new Ville();
        $ville10->setNomVille('Concarneau');
        $ville10->setCodePostal('29900');
        $manager->persist($ville10);

        $ville11= new Ville();
        $ville11->setNomVille('Saumur');
        $ville11->setCodePostal('49400');
        $manager->persist($ville11);

        $ville12= new Ville();
        $ville12->setNomVille('Mont-St-Michel');
        $ville12->setCodePostal('50170');
        $manager->persist($ville12);

        $manager->flush();

        $this->addReference(self::VILLE_REFERENCE1, $ville1);
        $this->addReference(self::VILLE_REFERENCE2, $ville2);
        $this->addReference(self::VILLE_REFERENCE3, $ville3);
        $this->addReference(self::VILLE_REFERENCE4, $ville4);
        $this->addReference(self::VILLE_REFERENCE5, $ville5);
        $this->addReference(self::VILLE_REFERENCE6, $ville6);
        $this->addReference(self::VILLE_REFERENCE7, $ville7);
        $this->addReference(self::VILLE_REFERENCE8, $ville8);
        $this->addReference(self::VILLE_REFERENCE9, $ville9);
        $this->addReference(self::VILLE_REFERENCE10, $ville10);
        $this->addReference(self::VILLE_REFERENCE11, $ville11);
        $this->addReference(self::VILLE_REFERENCE12, $ville12);
    }
}
