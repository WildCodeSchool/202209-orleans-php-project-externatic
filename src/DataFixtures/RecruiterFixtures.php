<?php

namespace App\DataFixtures;

use App\Entity\Recruiter;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\OfferFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecruiterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < UserFixtures::NB_USER_RECRUITER; $i++) {
            $recruiter = new Recruiter();
            $recruiter->setUser($this->getReference('UserRecruiter_' . $i));
            $this->addReference('Recruiter_' . $i, $recruiter);

            $manager->persist($recruiter);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
