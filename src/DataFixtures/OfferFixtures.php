<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Offer;
use App\Services\Geolocalisation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_OFFER = 50;

    private const TITLE_OFFERS = [
        'Développeur C++ Oracle Full Remote H/F',
        'Développeur fullstack PHP/JS H/F',
        'Stage Master 2 (4 à 6 mois) – Développeur fullstack Java / JS @Fintech H/F',
        'Développeur Back-End Java Spring Full remote H/F',
        'Développeur Java – Angular H/F #éditeur agricole',
        'Développeur fullstack Spring Vue.js Full Remote H/F/X',
    ];

    private const CITY_OFFERS = [
        ["city" => 'Orléans', "postalCode" => '45000'],
        ["city" => 'Lacanau', "postalCode" => '33680'],
        ["city" => 'Soulac', "postalCode" => '33780'],
        ["city" => 'Nantes', "postalCode" => '45000'],
        ["city" => 'Pornic', "postalCode" => '44210'],
        ["city" => 'La Roche sur Yon', "postalCode" => '45000'],
        ["city" => 'Angers', "postalCode" => '49000'],
        ["city" => 'Tarbes', "postalCode" => '65000'],
        ["city" => 'Caen', "postalCode" => '14000'],
        ["city" => 'Mondeville', "postalCode" => '14120'],
        ["city" => 'Bordeaux', "postalCode" => '33000'],
        ["city" => 'Toulouse', "postalCode" => '31000'],
        ["city" => 'Roubaix', "postalCode" => '59100'],
    ];

    public function __construct(private Geolocalisation $geolocalisation)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_OFFER; $i++) {
            $offer = new Offer();
            $cityCount = rand(0, count(self::CITY_OFFERS) - 1);
            $location = self::CITY_OFFERS[$cityCount];
            $offer->setTitle(self::TITLE_OFFERS[array_rand(self::TITLE_OFFERS)]);
            $offer->setDescription($faker->sentence(50));
            $offer->setPostalCode($location["postalCode"]);
            $offer->setCity($location["city"]);

            $position = $this->geolocalisation->find($location["city"], $location["postalCode"]);
            $offer->setLongitude($position['lng']);
            $offer->setLatitude($position['lat']);

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
