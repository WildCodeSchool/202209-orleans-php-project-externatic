<?php

namespace App\DataFixtures;

use App\Entity\Candidate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CandidateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $candidate = new Candidate();
        $candidate->setUser($this->getReference('UserCandidate'));
        $candidate->setNationality($faker->countryCode());
        $candidate->setCity($faker->city());
        $candidate->setPostalCode(((string) $faker->randomNumber(5, true)));
        $candidate->setHobby($faker->sentence(5, true));
        $candidate->setAboutMe($faker->paragraph(8));
        $candidate->setAddress($faker->address());
        $candidate->setGithub('https://fakerphp.github.io/formatters/');
        $candidate->setLinkedin('https://fakerphp.github.io/formatters/');
        $candidate->setPortfolio('https://fakerphp.github.io/formatters/');
        $this->addReference('Candidate_1', $candidate);

        $manager->persist($candidate);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
