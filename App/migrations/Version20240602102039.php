<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602102039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (1,'PC')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (2,'PSX & PS2')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (3,'PS3')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (4,'PS4')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (5,'PS5')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (6,'XBOX')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (7,'PSVita & PSP')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (8,'XBOX360')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (9,'XBOXONE')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (10,'XBOX SERIES S/X')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (11,'NES & SNES')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (12,'GB/GBC')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (13,'GB Advance')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (14,'Nintendo 64')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (15,'GameCube')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (16,'Wii')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (17,'WiiU')");
        $this->addSql("INSERT INTO \"platforms\" (id, platform_name) VALUES (18,'Nintendo Switch')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
