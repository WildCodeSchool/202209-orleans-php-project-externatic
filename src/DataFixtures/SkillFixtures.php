<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SkillFixtures extends Fixture
{
    public const SKILLS = [
        'PHP',
        'C#',
        'JavaScript',
        'Java',
        'GO',
        'Python',
        'C++',
    ];
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < count(self::SKILLS); $i++) {
            $skill = new Skill();
            $skill->setName((self::SKILLS[$i]));
            $this->addReference('skill_' . $i, $skill);
            $manager->persist($skill);
        }

        $manager->flush();
    }
}
