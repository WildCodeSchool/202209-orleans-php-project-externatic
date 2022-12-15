<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable('now');

        $candidate = new User();
        $candidate->setEmail('candidate@exemple.com');
        $candidate->setRoles(['ROLE_CANDIDATE']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $candidate,
            'candidate'
        );
        $candidate->setPassword($hashedPassword);
        $candidate->setFirstname('John');
        $candidate->setLastname('Doe');
        $candidate->setPhoneNumber('0622222222');
        $candidate->setUpdatedAt($date);
        $this->addReference('UserCandidate', $candidate);

        $manager->persist($candidate);

        $admin = new User();
        $admin->setEmail('admin@exemple.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );
        $admin->setPassword($hashedPassword);
        $admin->setFirstname('Jane');
        $admin->setLastname('Doe');
        $admin->setPhoneNumber('0633333333');
        $admin->setUpdatedAt($date);
        $this->addReference('UserAdmin', $admin);

        $manager->persist($admin);

        $manager->flush();
    }
}
