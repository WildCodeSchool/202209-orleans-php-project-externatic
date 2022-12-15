<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Faker\Factory;
use Faker\Provider\fr_FR\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompanyFixtures extends Fixture
{
    public const COMPANY_NUMBER = 50;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::COMPANY_NUMBER; $i++) {
            $compagny = new Company();
            $compagny->setName($faker->sentence(5));
            $compagny->setEmail($faker->companyEmail());
            $compagny->setPostalCode((int)$faker->postcode());
            $compagny->setCity($faker->city());
            $compagny->setDescription($faker->paragraph(20));

            $manager->persist($compagny);
        }

        $manager->flush();
    }
}
