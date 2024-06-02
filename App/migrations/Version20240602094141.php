<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602094141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql("INSERT INTO \"user_profile\"(id, username, profile_picture) VALUES (1, 'admin', 'profile.png')");
        $this->addSql("INSERT INTO \"user_profile\"(id, username, profile_picture) VALUES (2, 'user', 'profile.png')");
        $admin_password = password_hash('admin', PASSWORD_BCRYPT);
        $user_password = password_hash('user', PASSWORD_BCRYPT);

        $this->addSql("INSERT INTO \"user\" (id, user_profile_id, email, roles, password) VALUES (1,1, 'admin@admin.com', '[\"ROLE_ADMIN\"]', '$admin_password')");
        $this->addSql("INSERT INTO \"user\" (id, user_profile_id, email, roles, password) VALUES (2,2, 'user@user.com', '[\"ROLE_USER\"]', '$user_password')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM \"user\" WHERE email IN ('user@user.com', 'admin@admin.com')");
        $this->addSql("DELETE FROM \"user_profile\" WHERE id IN ('1', '2')");
    }
}
