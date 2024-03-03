<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303101239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, time TIME DEFAULT NULL, difficulty INT DEFAULT NULL, rating INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_list (id INT AUTO_INCREMENT NOT NULL, dish_id INT DEFAULT NULL, ingredient_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_1A99488E148EB0CB (dish_id), INDEX IDX_1A99488E933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient_list ADD CONSTRAINT FK_1A99488E148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('ALTER TABLE ingredient_list ADD CONSTRAINT FK_1A99488E933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient_list DROP FOREIGN KEY FK_1A99488E148EB0CB');
        $this->addSql('ALTER TABLE ingredient_list DROP FOREIGN KEY FK_1A99488E933FE08C');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_list');
    }
}
