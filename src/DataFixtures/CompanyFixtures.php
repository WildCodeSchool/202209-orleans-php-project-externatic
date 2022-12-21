<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Faker\Factory;
use Faker\Provider\fr_FR\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompanyFixtures extends Fixture
{
    public const COMPANY_NUMBER = 20;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= self::COMPANY_NUMBER; $i++) {
            $company = new Company();
            $company->setName($faker->sentence(5));
            $company->setEmail($faker->companyEmail());
            $company->setPostalCode((int)$faker->postcode());
            $company->setCity($faker->city());
            $company->setDescription($faker->paragraph(20));
            $this->addReference('company_' . $i, $company);
            $manager->persist($company);
        }

        $manager->flush();
    }
}
