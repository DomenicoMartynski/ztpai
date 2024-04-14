<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414155001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE reviews_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reviews (id INT NOT NULL, reviewed_game_id INT NOT NULL, reviewer_id INT NOT NULL, rating_given SMALLINT NOT NULL, user_comment TEXT NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6970EB0FFA43AAE7 ON reviews (reviewed_game_id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F70574616 ON reviews (reviewer_id)');
        $this->addSql('COMMENT ON COLUMN reviews.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FFA43AAE7 FOREIGN KEY (reviewed_game_id) REFERENCES games (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F70574616 FOREIGN KEY (reviewer_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE reviews_id_seq CASCADE');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0FFA43AAE7');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0F70574616');
        $this->addSql('DROP TABLE reviews');
    }
}
