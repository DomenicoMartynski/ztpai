<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414154235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE games_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE games (id INT NOT NULL, game_name VARCHAR(255) NOT NULL, release_date DATE NOT NULL, game_cover VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE games_genres (games_id INT NOT NULL, genres_id INT NOT NULL, PRIMARY KEY(games_id, genres_id))');
        $this->addSql('CREATE INDEX IDX_6AC30AA397FFC673 ON games_genres (games_id)');
        $this->addSql('CREATE INDEX IDX_6AC30AA36A3B2603 ON games_genres (genres_id)');
        $this->addSql('CREATE TABLE games_platforms (games_id INT NOT NULL, platforms_id INT NOT NULL, PRIMARY KEY(games_id, platforms_id))');
        $this->addSql('CREATE INDEX IDX_3847FD0397FFC673 ON games_platforms (games_id)');
        $this->addSql('CREATE INDEX IDX_3847FD033A8327A5 ON games_platforms (platforms_id)');
        $this->addSql('ALTER TABLE games_genres ADD CONSTRAINT FK_6AC30AA397FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE games_genres ADD CONSTRAINT FK_6AC30AA36A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE games_platforms ADD CONSTRAINT FK_3847FD0397FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE games_platforms ADD CONSTRAINT FK_3847FD033A8327A5 FOREIGN KEY (platforms_id) REFERENCES platforms (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE games_id_seq CASCADE');
        $this->addSql('ALTER TABLE games_genres DROP CONSTRAINT FK_6AC30AA397FFC673');
        $this->addSql('ALTER TABLE games_genres DROP CONSTRAINT FK_6AC30AA36A3B2603');
        $this->addSql('ALTER TABLE games_platforms DROP CONSTRAINT FK_3847FD0397FFC673');
        $this->addSql('ALTER TABLE games_platforms DROP CONSTRAINT FK_3847FD033A8327A5');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE games_genres');
        $this->addSql('DROP TABLE games_platforms');
    }
}
