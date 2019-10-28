<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public const USER_REFERENCE1 = 'user-ref1';
    public const USER_REFERENCE2 = 'user-ref2';
    public const USER_REFERENCE3 = 'user-ref3';
    public const USER_REFERENCE4 = 'user-ref4';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setNom('PORTMAN');
        $user1->setPrenom('Natalie');
        $user1->setPseudo('Pnatalie');
        $user1->setTelephone('0'.mt_rand(100000000, 999999999));
        $user1->setEmail('Pnatalie'.mt_rand(0,20).'@gmail.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setActif(true);
        $password = $this->encoder->encodePassword($user1, 'Pass_1234');
        $user1->setPassword($password);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE1);
        $user1->setSite($site);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setNom('DISNEY');
        $user2->setPrenom('Land');
        $user2->setPseudo('Dland');
        $user2->setTelephone('0'.mt_rand(100000000, 999999999));
        $user2->setEmail('Dland'.mt_rand(0,20).'@gmail.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setActif(true);
        $password = $this->encoder->encodePassword($user2, 'Pass_1234');
        $user2->setPassword($password);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE1);
        $user2->setSite($site);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setNom('ADMIN');
        $user3->setPrenom('First');
        $user3->setPseudo('admin');
        $user3->setTelephone('0'.mt_rand(100000000, 999999999));
        $user3->setEmail('admin'.mt_rand(0,20).'@gmail.com');
        $user3->setRoles(['ROLE_ADMIN']);
        $user3->setActif(true);
        $password = $this->encoder->encodePassword($user3, 'Pass_1234');
        $user3->setPassword($password);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE1);
        $user3->setSite($site);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setNom('CAKE');
        $user4->setPrenom('Gateaau');
        $user4->setPseudo('cake');
        $user4->setTelephone('0'.mt_rand(100000000, 999999999));
        $user4->setEmail('cake'.mt_rand(0,20).'@gmail.com');
        $user4->setRoles(['ROLE_USER']);
        $user4->setActif(true);
        $password = $this->encoder->encodePassword($user4, 'Pass_1234');
        $user4->setPassword($password);
        $site = $this->getReference(SiteFixtures::SITE_REFERENCE2);
        $user4->setSite($site);
        $manager->persist($user4);
        $manager->flush();


        $this->addReference(self::USER_REFERENCE1, $user1);
        $this->addReference(self::USER_REFERENCE2, $user2);
        $this->addReference(self::USER_REFERENCE3, $user3);
        $this->addReference(self::USER_REFERENCE4, $user4);
    }
}
