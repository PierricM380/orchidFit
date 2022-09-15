<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915081557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, postal_address VARCHAR(100) NOT NULL, phone_number INT NOT NULL, description LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner_structure (partner_id INT NOT NULL, structure_id INT NOT NULL, INDEX IDX_44D6ACFE9393F8FE (partner_id), INDEX IDX_44D6ACFE2534008B (structure_id), PRIMARY KEY(partner_id, structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partner_structure ADD CONSTRAINT FK_44D6ACFE9393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partner_structure ADD CONSTRAINT FK_44D6ACFE2534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner_structure DROP FOREIGN KEY FK_44D6ACFE9393F8FE');
        $this->addSql('ALTER TABLE partner_structure DROP FOREIGN KEY FK_44D6ACFE2534008B');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE partner_structure');
    }
}
