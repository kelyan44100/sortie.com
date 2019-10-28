<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LieuFixtures extends Fixture
{
    public const LIEU_REFERENCE1 = 'lieu-ref1';
    public const LIEU_REFERENCE2 = 'lieu-ref2';
    public const LIEU_REFERENCE3 = 'lieu-ref3';
    public const LIEU_REFERENCE4 = 'lieu-ref4';
    public const LIEU_REFERENCE5 = 'lieu-ref5';
    public const LIEU_REFERENCE6 = 'lieu-ref6';
    public const LIEU_REFERENCE7 = 'lieu-ref7';
    public const LIEU_REFERENCE8 = 'lieu-ref8';
    public const LIEU_REFERENCE9 = 'lieu-ref9';
    public const LIEU_REFERENCE10 = 'lieu-ref10';
    public const LIEU_REFERENCE11 = 'lieu-ref11';
    public const LIEU_REFERENCE12 = 'lieu-ref12';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lieu1 = new Lieu();
        $lieu1->setNomLieu('Centre ville');
        $lieu1->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE1);
        $lieu1->setVille($ville);
        $lieu1->setLatitude(48.4333);
        $lieu1->setLongitude(0.0833);
        $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNomLieu('Centre ville');
        $lieu2->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE2);
        $lieu2->setVille($ville);
        $lieu2->setLatitude(47.4667);
        $lieu2->setLongitude(-0.55);
        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNomLieu('Centre ville');
        $lieu3->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE3);
        $lieu3->setVille($ville);
        $lieu3->setLatitude(47.4667);
        $lieu3->setLongitude(-0.55);
        $manager->persist($lieu3);

        $lieu4 = new Lieu();
        $lieu4->setNomLieu('Centre ville');
        $lieu4->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE4);
        $lieu4->setVille($ville);
        $lieu4->setLatitude(49.1811);
        $lieu4->setLongitude(-0.3712);
        $manager->persist($lieu4);

        $lieu5 = new Lieu();
        $lieu5->setNomLieu('Centre ville');
        $lieu5->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE5);
        $lieu5->setVille($ville);
        $lieu5->setLatitude(46.6667);
        $lieu5->setLongitude(-1.4333);
        $manager->persist($lieu5);

        $lieu6 = new Lieu();
        $lieu6->setNomLieu('Centre ville');
        $lieu6->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE6);
        $lieu6->setVille($ville);
        $lieu6->setLatitude(46.6667);
        $lieu6->setLongitude(-1.4333);
        $manager->persist($lieu6);

        $lieu7 = new Lieu();
        $lieu7->setNomLieu('Centre ville');
        $lieu7->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE7);
        $lieu7->setVille($ville);
        $lieu7->setLatitude(46.6667);
        $lieu7->setLongitude(-1.4333);
        $manager->persist($lieu7);

        $lieu8 = new Lieu();
        $lieu8->setNomLieu('Centre ville');
        $lieu8->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE8);
        $lieu8->setVille($ville);
        $lieu8->setLatitude(46.6667);
        $lieu8->setLongitude(-1.4333);
        $manager->persist($lieu8);

        $lieu9 = new Lieu();
        $lieu9->setNomLieu('Centre ville');
        $lieu9->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE9);
        $lieu9->setVille($ville);
        $lieu9->setLatitude(46.6667);
        $lieu9->setLongitude(-1.4333);
        $manager->persist($lieu9);

        $lieu10 = new Lieu();
        $lieu10->setNomLieu('Centre ville');
        $lieu10->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE10);
        $lieu10->setVille($ville);
        $lieu10->setLatitude(46.6667);
        $lieu10->setLongitude(-1.4333);
        $manager->persist($lieu10);

        $lieu11 = new Lieu();
        $lieu11->setNomLieu('Centre ville');
        $lieu11->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE11);
        $lieu11->setVille($ville);
        $lieu11->setLatitude(46.6667);
        $lieu11->setLongitude(-1.4333);
        $manager->persist($lieu11);

        $lieu12 = new Lieu();
        $lieu12->setNomLieu('Centre ville');
        $lieu12->setRue('rue du Lieu');
        $ville = $this->getReference(VilleFixtures::VILLE_REFERENCE12);
        $lieu12->setVille($ville);
        $lieu12->setLatitude(46.6667);
        $lieu12->setLongitude(-1.4333);
        $manager->persist($lieu12);

        $manager->flush();


        $this->addReference(self::LIEU_REFERENCE1, $lieu1);
        $this->addReference(self::LIEU_REFERENCE2, $lieu2);
        $this->addReference(self::LIEU_REFERENCE3, $lieu3);
        $this->addReference(self::LIEU_REFERENCE4, $lieu4);
        $this->addReference(self::LIEU_REFERENCE5, $lieu5);
        $this->addReference(self::LIEU_REFERENCE6, $lieu6);
        $this->addReference(self::LIEU_REFERENCE7, $lieu7);
        $this->addReference(self::LIEU_REFERENCE8, $lieu8);
        $this->addReference(self::LIEU_REFERENCE9, $lieu9);
        $this->addReference(self::LIEU_REFERENCE10, $lieu10);
        $this->addReference(self::LIEU_REFERENCE11, $lieu11);
        $this->addReference(self::LIEU_REFERENCE12, $lieu12);
    }
}
