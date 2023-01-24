<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124143304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_skill (offer_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_DD10999E53C674EE (offer_id), INDEX IDX_DD10999E5585C142 (skill_id), PRIMARY KEY(offer_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer_skill ADD CONSTRAINT FK_DD10999E53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_skill ADD CONSTRAINT FK_DD10999E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_skill DROP FOREIGN KEY FK_DD10999E53C674EE');
        $this->addSql('ALTER TABLE offer_skill DROP FOREIGN KEY FK_DD10999E5585C142');
        $this->addSql('DROP TABLE offer_skill');
    }
}
