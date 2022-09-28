<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Service;
use App\Entity\Structure;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Admin
        $admin = new User();

        $admin
            ->setFullName('Philippe Marye')
            ->setEmail('mp@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('ecf1');

        $manager->persist($admin);
        $manager->flush();

        // Users
        $users = [];

        $user1 = new User();
        $user1
            ->setFullName('Pierric Marye')
            ->setEmail('pm@gmail.com')
            ->setRoles(['ROLE_PARTNER'])
            ->setPlainPassword('ecf');

        $users[] = $user1;
        $manager->persist($user1);

        $user2 = new User();
        $user2
            ->setFullName('Ghislaine Marye')
            ->setEmail('gm@gmail.com')
            ->setRoles(['ROLE_STRUCTURE'])
            ->setPlainPassword('ecf');

        $users[] = $user2;
        $manager->persist($user2);

        $user3 = new User();
        $user3
            ->setFullName('Emma Marye')
            ->setEmail('em@gmail.com')
            ->setRoles(['ROLE_STRUCTURE'])
            ->setPlainPassword('ecf');

        $users[] = $user3;
        $manager->persist($user3);

        $manager->flush();
    }
}
