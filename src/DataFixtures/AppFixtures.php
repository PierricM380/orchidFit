<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Service;
use App\Entity\Structure;
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
        // Services
        $services = [];
        for ($o = 0; $o < 10; $o++) {
            $service = new Service();
            $service
                ->setName($this->faker->word())
                ->setisActive(mt_rand(0, 1) == 1 ? true : false);

            $services[] = $service;
            $manager->persist($service);
        }

        //Structures
        $structures = [];
        for ($s = 0; $s < 5; $s++) {
            $structure = new Structure();
            $structure
            ->setName($this->faker->word())
            ->setPostalAddress($this->faker->address())
            ->setPhoneNumber($this->faker->numberBetween($min = 0, $max = 1000))
            ->setDescription($this->faker->text(50))
            ->setIsActive(mt_rand(0, 1) == 1 ? true : false);

            for ($d = 0; $d < mt_rand(1, 5); $d++) {
                $structure->addService($services[mt_rand(0, count($services) - 1)]);
            }

            $structures[] = $structure;
            $manager->persist($structure);
        }

        // Partners
        $partners = [];
        for ($p = 0; $p < 5; $p++) {
            $partner = new Partner();
            $partner
            ->setName($this->faker->word())
            ->setPostalAddress($this->faker->address())
            ->setPhoneNumber($this->faker->numberBetween($min = 0, $max = 1000))
            ->setDescription($this->faker->text(50))
            ->setIsActive(mt_rand(0, 1) == 1 ? true : false);

            for ($d = 0; $d < mt_rand(1, 5); $d++) {
                $partner->addStructure($structures[mt_rand(0, count($structures) - 1)]);
            }

            $partners[] = $partner;
            $manager->persist($partner);
        }

        $manager->flush();
    }
}
