<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602102839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (1,'Adventure')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (2,'Puzzle')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (3,'Horror')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (4,'Platformer')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (5,'Roguelite')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (6,'Rogue-like')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (7,'Souls-like')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (8,'Action')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (9,'Fighting')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (10,'RPG')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (11,'Metroidvania')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (12,'Simulation')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (13,'Racing')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (14,'Party')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (15,'Shooter')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (16,'Competetive')");
        $this->addSql("INSERT INTO \"genres\" (id, genre_name) VALUES (17,'MMO')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
