<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class VersionFinalProduction extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sponsors = [
            "lucca" => "https://www.externatic.fr/wp-content/uploads/2022/10/lucca-copie.png",
            "akaneo" => "https://www.externatic.fr/wp-content/uploads/2021/03/akeneo-2.png",
            "allovoisin" => "https://www.externatic.fr/wp-content/uploads/2021/03/allovoisins-1.png",
            "Decath tech" => "https://www.externatic.fr/wp-content/uploads/2022/10/Decath-tech.png",
            "nickel" => "https://www.externatic.fr/wp-content/uploads/2021/03/nickel-1.png",
            "iris" => "https://www.externatic.fr/wp-content/uploads/2022/03/GIE-iris.png",
            "Maison du Monde" => "https://www.externatic.fr/wp-content/uploads/2021/03/mdm-1.png",
            "Show room privé" => "https://www.externatic.fr/wp-content/uploads/2021/03/showroom-1.png",
            "Manitou" => "https://www.externatic.fr/wp-content/uploads/2021/03/manitou.png",
            "iAdvise" => "https://www.externatic.fr/wp-content/uploads/2021/03/iadvize.png",
            "iKKS" => "https://www.externatic.fr/wp-content/uploads/2021/03/IKKS-1.png",
            "lengow" => "https://www.externatic.fr/wp-content/uploads/2021/03/lengow-1.png",
            "maincare" => "https://www.externatic.fr/wp-content/uploads/2022/08/maincare.jpg",
            "acc" => "https://www.externatic.fr/wp-content/uploads/2022/08/acc.jpg",
            "klaxoon" => "https://www.externatic.fr/wp-content/uploads/2022/08/klaxoon-.jpg",
            "groupama" => "https://www.externatic.fr/wp-content/uploads/2022/08/groupama.jpg",
            "lumiplan" => "https://www.externatic.fr/wp-content/uploads/2022/08/lumiplan.jpg"
        ];

        $contracts = [
            'CDI',
            'CDD',
            'STAGE',
            'ALTERNANCE',
        ];

        $skills = [
            'PHP',
            'C#',
            'JavaScript',
            'Java',
            'GO',
            'Python',
            'C++',
        ];

        foreach ($sponsors as $name => $logo) {
            $this->addSql('INSERT INTO sponsor (`name`, logo) VALUES ("' . $name . '","' . $logo . '")');
        }

        foreach ($contracts as $contract) {
            $this->addSql('INSERT INTO contract (`name`) VALUES ("' . $contract . '")');
        }

        foreach ($skills as $skill) {
            $this->addSql('INSERT INTO skill (`name`) VALUES ("' . $skill . '")');
        }


    }
    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE sponsor');
        $this->addSql('TRUNCATE TABLE contract');
        $this->addSql('TRUNCATE TABLE skill');
    }
}
