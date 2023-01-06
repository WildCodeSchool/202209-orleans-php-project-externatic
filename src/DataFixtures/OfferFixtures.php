<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Offer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_OFFER = 50;

    private const TITLE_OFFERS = [
        'Développeur C++ Oracle Full Remote H/F',
        'Développeur fullstack PHP/JS H/F (Nantes Nord)',
        'Stage Master 2 (4 à 6 mois) – Développeur fullstack Java / JS @Fintech H/F',
        'Développeur Back-End Java Spring Full remote H/F',
        'Développeur Java – Angular H/F #éditeur agricole',
        'Développeur fullstack Spring Vue.js Full Remote H/F/X',
    ];

    private const CITY_OFFERS = [
        ['Orléans', '45000'],
        ['Lacanau', '33680'],
        ['Soulac', '33780'],
        ['Nantes', '45000'],
        ['Pornic', '44210'],
        ['La Roche sur Yon', '45000'],
        ['Angers', '49000'],
        ['Tarbes', '65000'],
        ['Caen', '14000'],
        ['Mondeville', '14120'],
        ['Bordeaux', '33000'],
        ['Toulouse', '31000'],
        ['Roubaix', '59100'],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_OFFER; $i++) {
            $offer = new Offer();
            $offer->setTitle(self::TITLE_OFFERS[array_rand(self::TITLE_OFFERS)]);
            $offer->setDescription($faker->sentence(50));
            $randomCity = array_rand(self::CITY_OFFERS);
            $offer->setPostalCode(self::CITY_OFFERS[$randomCity][1]);
            $offer->setCity(self::CITY_OFFERS[$randomCity][0]);

            $offer->setAnnualWage($faker->numberBetween(35, 70) * 1000);
            $offer->setCompany($this->getReference('company_' . rand(1, CompanyFixtures::COMPANY_NUMBER)));
            $offer->setIsImportant($faker->boolean());

            $this->addReference('offer_' . $i, $offer);


            $manager->persist($offer);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CompanyFixtures::class
        ];
    }
}
