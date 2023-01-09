<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public const NB_USER_CANDIDATE = 20;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $date = new DateTimeImmutable('now');

        for ($i = 0; $i < self::NB_USER_CANDIDATE; $i++) {
            $candidate = new User();
            $candidate->setEmail('candidate_' . $i . '@exemple.com');
            $candidate->setRoles(['ROLE_CANDIDATE']);
            $hashedPassword = $this->passwordHasher->hashPassword($candidate, 'candidate_' . $i);
            $candidate->setPassword($hashedPassword);
            $candidate->setFirstname($faker->firstName());
            $candidate->setLastname($faker->lastName());
            $candidate->setPhoneNumber('0622222222');
            $candidate->setUpdatedAt($date);
            $this->addReference('UserCandidate_' . $i, $candidate);
            $manager->persist($candidate);
        }


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

        $recruiter = new User();
        $recruiter->setEmail('recruiter@exemple.com');
        $recruiter->setRoles(['ROLE_RECRUITER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $recruiter,
            'recruiter'
        );
        $recruiter->setPassword($hashedPassword);
        $recruiter->setFirstname('Tom');
        $recruiter->setLastname('Jerry');
        $recruiter->setPhoneNumber('0633333333');
        $recruiter->setUpdatedAt($date);
        $this->addReference('UserRecruiter', $recruiter);

        $manager->persist($recruiter);

        $manager->flush();

        $recruiter = new User();
        $recruiter->setEmail('bilbo@externatic.com');
        $recruiter->setRoles(['ROLE_RECRUITER']);
        $recruiter->setFirstname('Bilbo');
        $recruiter->setLastname('Baggins');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $recruiter,
            'hobbit'
        );
        $recruiter->setPassword($hashedPassword);
        $recruiter->setPhoneNumber('0633333333');
        $recruiter->setUpdatedAt($date);
        $this->addReference('UserRecruter', $recruiter);

        $manager->persist($recruiter);

        $manager->flush();
    }
}
