<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Experience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExperienceFixtures extends Fixture implements DependentFixtureInterface
{
    public const NUMBER_OF_EXPERIENCE = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        $numberOfExperience = self::NUMBER_OF_EXPERIENCE;
        for ($i = 1; $i <= $numberOfExperience; $i++) {
            $experience = new Experience();
            $experience->setCompany($faker->company());
            $experience->setStartDate($faker->dateTime());
            $experience->setEndDate($faker->dateTime());
            $experience->setIsCurrentPosition(false);
            $experience->setJobTitle($faker->jobTitle());
            $experience->setJobDescription($faker->realTextBetween());
            $experience->setCandidate($this->getReference('Candidate_1'));
            $manager->persist($experience);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CandidateFixtures::class,
        ];
    }
}
