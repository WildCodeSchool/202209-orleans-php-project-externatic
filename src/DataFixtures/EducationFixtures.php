<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Education;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EducationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($j = 0; $j < UserFixtures::NB_USER_CANDIDATE; $j++) {
            $randomEducationCount = rand(1, 5);

            for ($i = 0; $i < $randomEducationCount; $i++) {
                $education = new Education();

                $education->setSchool($faker->company());
                $education->setStartDate($faker->dateTime());
                $education->setEndDate($faker->dateTime());
                $education->setTitle($faker->sentence(random_int(3, 6)));
                $education->setLevel($faker->numberBetween(0, 8));
                $education->setDescription($faker->realTextBetween());
                $targetedCandidate = $this->getReference('Candidate_' . rand(0, UserFixtures::NB_USER_CANDIDATE - 1));
                $education->setCandidate($targetedCandidate);

                $manager->persist($education);
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
