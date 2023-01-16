<?php

namespace App\DataFixtures;

use App\Entity\Sponsor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SponsorsFixtures extends Fixture
{
    public const SPONSOR_DATA = [
        'lucca' => 'https://www.externatic.fr/wp-content/uploads/2022/10/lucca-copie.png',
        'akaneo' => 'https://www.externatic.fr/wp-content/uploads/2021/03/akeneo-2.png',
        'allovoisin' => 'https://www.externatic.fr/wp-content/uploads/2021/03/allovoisins-1.png',
        'Decath tech' => 'https://www.externatic.fr/wp-content/uploads/2022/10/Decath-tech.png',
        'nickel' => 'https://www.externatic.fr/wp-content/uploads/2021/03/nickel-1.png',
        'iris' => 'https://www.externatic.fr/wp-content/uploads/2022/03/GIE-iris.png',
        'Maison du Monde' => 'https://www.externatic.fr/wp-content/uploads/2021/03/mdm-1.png',
        'Show room privé' => 'https://www.externatic.fr/wp-content/uploads/2021/03/showroom-1.png',
        'Manitou' => 'https://www.externatic.fr/wp-content/uploads/2021/03/manitou.png',
        'iAdvise' => 'https://www.externatic.fr/wp-content/uploads/2021/03/iadvize.png',
        'iKKS' => 'https://www.externatic.fr/wp-content/uploads/2021/03/IKKS-1.png',
        'lengow' => 'https://www.externatic.fr/wp-content/uploads/2021/03/lengow-1.png',
        'maincare' => 'https://www.externatic.fr/wp-content/uploads/2022/08/maincare.jpg',
        'acc' => 'https://www.externatic.fr/wp-content/uploads/2022/08/acc.jpg',
        'klaxoon' => 'https://www.externatic.fr/wp-content/uploads/2022/08/klaxoon-.jpg',
        'groupama' => 'https://www.externatic.fr/wp-content/uploads/2022/08/groupama.jpg',
        'lumiplan' => 'https://www.externatic.fr/wp-content/uploads/2022/08/lumiplan.jpg'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SPONSOR_DATA as $name => $logo) {
            $sponsors = new Sponsor();
            $sponsors->setName($name);
            $sponsors->setLogo($logo);

            $manager->persist($sponsors);
            $manager->flush();
        }
    }
}
