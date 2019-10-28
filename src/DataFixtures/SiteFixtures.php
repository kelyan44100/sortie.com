<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SiteFixtures extends Fixture
{
    public const SITE_REFERENCE1 = 'site-ref1';
    public const SITE_REFERENCE2 = 'site-ref2';
    public const SITE_REFERENCE3 = 'site-ref3';
    public const SITE_REFERENCE4 = 'site-ref4';
    public const SITE_REFERENCE5 = 'site-ref5';
    public const SITE_REFERENCE6 = 'site-ref6';
    public const SITE_REFERENCE7 = 'site-ref7';
    public const SITE_REFERENCE8 = 'site-ref8';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $site1 = new Site();
        $site1->setNomSite('Saint-Herblain');
        $site2 = new Site();
        $site2->setNomSite('Rennes');
        $site3 = new Site();
        $site3->setNomSite('Angers');
        $site4 = new Site();
        $site4->setNomSite('Le Mans');
        $site5 = new Site();
        $site5->setNomSite('Quimper');
        $site6 = new Site();
        $site6->setNomSite('La Roche-sur-Yon');
        $site7 = new Site();
        $site7->setNomSite('Laval');
        $site8 = new Site();
        $site8->setNomSite('Niort');

        $manager->persist($site1);
        $manager->persist($site2);
        $manager->persist($site3);
        $manager->persist($site4);
        $manager->persist($site5);
        $manager->persist($site6);
        $manager->persist($site7);
        $manager->persist($site8);
        $manager->flush();

        $this->addReference(self::SITE_REFERENCE1, $site1);
        $this->addReference(self::SITE_REFERENCE2, $site2);
        $this->addReference(self::SITE_REFERENCE3, $site3);
        $this->addReference(self::SITE_REFERENCE4, $site4);
        $this->addReference(self::SITE_REFERENCE5, $site5);
        $this->addReference(self::SITE_REFERENCE6, $site6);
        $this->addReference(self::SITE_REFERENCE7, $site7);
        $this->addReference(self::SITE_REFERENCE8, $site8);
    }
}
