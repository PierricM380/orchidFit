<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
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
            ->setPlainPassword('ecf');

        $manager->persist($admin);
        $manager->flush();
    }
}
