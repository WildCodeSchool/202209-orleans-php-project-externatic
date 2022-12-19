<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Education;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EducationFixtures extends Fixture implements DependentFixtureInterface
{
    public const NUMBER_OF_EDUCATION = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i = 0; $i < self::NUMBER_OF_EDUCATION; $i++) {
            $education = new Education();

            $education->setSchool($faker->company());
            $education->setStartDate($faker->dateTime());
            $education->setEndDate($faker->dateTime());
            $education->setTitle($faker->sentence(random_int(3, 6)));
            $education->setLevel($faker->numberBetween(0, 12));
            $education->setDescription($faker->realTextBetween());
            $education->setCandidate($this->getReference('Candidate_1'));

            $manager->persist($education);
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
