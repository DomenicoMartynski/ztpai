<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512210800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE games_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genres_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE platforms_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reviews_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE games (id INT NOT NULL, game_name VARCHAR(255) NOT NULL, release_date DATE NOT NULL, game_cover VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE games_genres (games_id INT NOT NULL, genres_id INT NOT NULL, PRIMARY KEY(games_id, genres_id))');
        $this->addSql('CREATE INDEX IDX_6AC30AA397FFC673 ON games_genres (games_id)');
        $this->addSql('CREATE INDEX IDX_6AC30AA36A3B2603 ON games_genres (genres_id)');
        $this->addSql('CREATE TABLE games_platforms (games_id INT NOT NULL, platforms_id INT NOT NULL, PRIMARY KEY(games_id, platforms_id))');
        $this->addSql('CREATE INDEX IDX_3847FD0397FFC673 ON games_platforms (games_id)');
        $this->addSql('CREATE INDEX IDX_3847FD033A8327A5 ON games_platforms (platforms_id)');
        $this->addSql('CREATE TABLE genres (id INT NOT NULL, genre_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE platforms (id INT NOT NULL, platform_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reviews (id INT NOT NULL, reviewed_game_id INT NOT NULL, reviewer_id INT NOT NULL, rating_given SMALLINT NOT NULL, user_comment TEXT NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6970EB0FFA43AAE7 ON reviews (reviewed_game_id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F70574616 ON reviews (reviewer_id)');
        $this->addSql('COMMENT ON COLUMN reviews.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, user_profile_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B9DD454 ON "user" (user_profile_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_profile (id INT NOT NULL, username VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE games_genres ADD CONSTRAINT FK_6AC30AA397FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE games_genres ADD CONSTRAINT FK_6AC30AA36A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE games_platforms ADD CONSTRAINT FK_3847FD0397FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE games_platforms ADD CONSTRAINT FK_3847FD033A8327A5 FOREIGN KEY (platforms_id) REFERENCES platforms (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FFA43AAE7 FOREIGN KEY (reviewed_game_id) REFERENCES games (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F70574616 FOREIGN KEY (reviewer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6496B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE games_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genres_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE platforms_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reviews_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_profile_id_seq CASCADE');
        $this->addSql('ALTER TABLE games_genres DROP CONSTRAINT FK_6AC30AA397FFC673');
        $this->addSql('ALTER TABLE games_genres DROP CONSTRAINT FK_6AC30AA36A3B2603');
        $this->addSql('ALTER TABLE games_platforms DROP CONSTRAINT FK_3847FD0397FFC673');
        $this->addSql('ALTER TABLE games_platforms DROP CONSTRAINT FK_3847FD033A8327A5');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0FFA43AAE7');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0F70574616');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6496B9DD454');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE games_genres');
        $this->addSql('DROP TABLE games_platforms');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE platforms');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_profile');
    }
}
