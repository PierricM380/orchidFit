<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Service;
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
        for ($s = 0; $s < 10; $s++) {
            $service = new Service();
            $service
                ->setServiceName($this->faker->word())
                ->setisActive($this->faker->boolean());

            $manager->persist($service);
        }

        $manager->flush();
    }
}
