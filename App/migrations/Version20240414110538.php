<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414110538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE game_genres_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE game_genres (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE game_genres_games (game_genres_id INT NOT NULL, games_id INT NOT NULL, PRIMARY KEY(game_genres_id, games_id))');
        $this->addSql('CREATE INDEX IDX_7865900BB89DE701 ON game_genres_games (game_genres_id)');
        $this->addSql('CREATE INDEX IDX_7865900B97FFC673 ON game_genres_games (games_id)');
        $this->addSql('CREATE TABLE game_genres_genres (game_genres_id INT NOT NULL, genres_id INT NOT NULL, PRIMARY KEY(game_genres_id, genres_id))');
        $this->addSql('CREATE INDEX IDX_6E607A1FB89DE701 ON game_genres_genres (game_genres_id)');
        $this->addSql('CREATE INDEX IDX_6E607A1F6A3B2603 ON game_genres_genres (genres_id)');
        $this->addSql('ALTER TABLE game_genres_games ADD CONSTRAINT FK_7865900BB89DE701 FOREIGN KEY (game_genres_id) REFERENCES game_genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_genres_games ADD CONSTRAINT FK_7865900B97FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_genres_genres ADD CONSTRAINT FK_6E607A1FB89DE701 FOREIGN KEY (game_genres_id) REFERENCES game_genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_genres_genres ADD CONSTRAINT FK_6E607A1F6A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE game_genres_id_seq CASCADE');
        $this->addSql('ALTER TABLE game_genres_games DROP CONSTRAINT FK_7865900BB89DE701');
        $this->addSql('ALTER TABLE game_genres_games DROP CONSTRAINT FK_7865900B97FFC673');
        $this->addSql('ALTER TABLE game_genres_genres DROP CONSTRAINT FK_6E607A1FB89DE701');
        $this->addSql('ALTER TABLE game_genres_genres DROP CONSTRAINT FK_6E607A1F6A3B2603');
        $this->addSql('DROP TABLE game_genres');
        $this->addSql('DROP TABLE game_genres_games');
        $this->addSql('DROP TABLE game_genres_genres');
    }
}
