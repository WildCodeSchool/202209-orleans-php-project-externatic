<?php

namespace App\DataFixtures;

use App\Entity\Candidate;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CandidateFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_CANDIDATE = UserFixtures::NB_USER_CANDIDATE;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_CANDIDATE; $i++) {
            $candidate = new Candidate();
            $candidate->setUser($this->getReference('UserCandidate_' . $i));
            $candidate->setNationality($faker->countryCode());
            $candidate->setCity($faker->city());
            $candidate->setPostalCode(((string) $faker->randomNumber(5, true)));
            $candidate->setHobby($faker->sentence(5, true));
            $candidate->setAboutMe($faker->paragraph(8));
            $candidate->setAddress($faker->address());
            $candidate->setGithub('https://fakerphp.github.io/formatters/');
            $candidate->setLinkedin('https://fakerphp.github.io/formatters/');
            $candidate->setPortfolio('https://fakerphp.github.io/formatters/');
            $candidate->addOffer($this->getReference('offer_' . rand(0, OfferFixtures::NB_OFFER - 1)));
            $this->addReference('Candidate_' . $i, $candidate);

            $manager->persist($candidate);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OfferFixtures::class,
            UserFixtures::class,
        ];
    }
}
