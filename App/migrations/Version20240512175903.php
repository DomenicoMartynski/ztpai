<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512175102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO \"user_profile\" (id, username, profile_picture) VALUES 
        (1, 'User', 'profile.png'),
        (2, 'Admin', 'profile.png')");
        $this->addSql("INSERT INTO \"users\" (id, email, password, user_profile_id) VALUES 
        (1, 'user@user.com', 'user', 1),
        (2, 'admin@admin.com', 'admin', 2)");
        $this->addSql("INSERT INTO \"users_roles\" (users_id, roles_id) VALUES 
        (1, 1),
        (2, 2)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DELETE FROM users WHERE id = 1');
        $this->addSql('DELETE FROM users WHERE id = 2');
    }
}