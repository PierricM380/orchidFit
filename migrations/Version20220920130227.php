<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920130227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner_user (partner_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_DDA7E5519393F8FE (partner_id), INDEX IDX_DDA7E551A76ED395 (user_id), PRIMARY KEY(partner_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partner_user ADD CONSTRAINT FK_DDA7E5519393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partner_user ADD CONSTRAINT FK_DDA7E551A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner_user DROP FOREIGN KEY FK_DDA7E5519393F8FE');
        $this->addSql('ALTER TABLE partner_user DROP FOREIGN KEY FK_DDA7E551A76ED395');
        $this->addSql('DROP TABLE partner_user');
    }
}
