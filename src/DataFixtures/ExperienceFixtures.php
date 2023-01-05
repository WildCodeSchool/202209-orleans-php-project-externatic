<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Experience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExperienceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($j = 0; $j < UserFixtures::NB_USER_CANDIDATE; $j++) {
            $randomJobCount = rand(1, 5);

            for ($i = 1; $i <= $randomJobCount; $i++) {
                $experience = new Experience();
                $experience->setCompany($faker->company());
                $experience->setStartDate($faker->dateTime());
                $experience->setEndDate($faker->dateTime());
                $experience->setIsCurrentPosition(false);
                $experience->setJobTitle($faker->jobTitle());
                $experience->setJobDescription($faker->realTextBetween());
                $experience->setCandidate($this->getReference('Candidate_' . $j));
                $manager->persist($experience);
            }
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
