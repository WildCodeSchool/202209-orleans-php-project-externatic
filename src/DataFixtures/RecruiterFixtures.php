<?php

namespace App\DataFixtures;

use App\Entity\Recruiter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecruiterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $recuiter = new Recruiter();
        $recuiter->setUser($this->getReference('UserRecruiter'));

        $manager->persist($recuiter);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
