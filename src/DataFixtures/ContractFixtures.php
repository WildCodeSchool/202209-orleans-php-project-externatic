<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ContractFixtures extends Fixture
{
    public const CONTRACTS = [
        0 => 'CDI',
        1 => 'CDD',
        2 => 'STAGE',
        3 => 'ALTERNANCE',
    ];

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < count(self::CONTRACTS); $i++) {
            $contract = new Contract();

            $contract->setName(self::CONTRACTS[$i]);
            $this->addReference(self::CONTRACTS[$i], $contract);
            $manager->persist($contract);
        }

        $manager->flush();
    }
}
