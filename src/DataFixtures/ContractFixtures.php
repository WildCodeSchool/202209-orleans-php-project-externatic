<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ContractFixtures extends Fixture
{
    public const CONTRACTS = [
        'CDI',
        'CDD',
        'STAGE',
        'ALTERNANCE',
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
