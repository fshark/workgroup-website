<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203210222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, category VARCHAR(255) NOT NULL, hidden TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, role_id INT NOT NULL, production_id INT NOT NULL, INDEX IDX_DA6F97937597D3FE (member_id), INDEX IDX_DA6F9793D60322AC (role_id), INDEX IDX_DA6F9793ECC6147F (production_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, production_id INT NOT NULL, datetime DATETIME NOT NULL, title VARCHAR(255) NOT NULL, price SMALLINT NOT NULL, maximum_contingent SMALLINT NOT NULL, contingent SMALLINT NOT NULL, is_bookable TINYINT(1) NOT NULL, INDEX IDX_3BAE0AA7ECC6147F (production_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, production_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(511) DEFAULT NULL, INDEX IDX_C53D045FECC6147F (production_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, main_image_id INT DEFAULT NULL, firstname VARCHAR(127) NOT NULL, lastname VARCHAR(127) NOT NULL, since SMALLINT DEFAULT NULL, birthday DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_70E4FA78E4873418 (main_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_image (member_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_A71C91AC7597D3FE (member_id), INDEX IDX_A71C91AC3DA5256D (image_id), PRIMARY KEY(member_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paragraph (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, image_id INT DEFAULT NULL, content LONGTEXT NOT NULL, image_position VARCHAR(127) DEFAULT NULL, INDEX IDX_7DD398627294869C (article_id), INDEX IDX_7DD398623DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(127) NOT NULL, author VARCHAR(127) NOT NULL, description VARCHAR(255) NOT NULL, synopsis LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production (id INT AUTO_INCREMENT NOT NULL, play_id INT NOT NULL, main_image_id INT DEFAULT NULL, year SMALLINT NOT NULL, is_visible TINYINT(1) NOT NULL, INDEX IDX_D3EDB1E025576DBD (play_id), UNIQUE INDEX UNIQ_D3EDB1E0E4873418 (main_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(127) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_request (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, amount SMALLINT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, housenumber VARCHAR(255) NOT NULL, zipcode INT NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_375BD6CD71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F97937597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793ECC6147F FOREIGN KEY (production_id) REFERENCES production (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7ECC6147F FOREIGN KEY (production_id) REFERENCES production (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FECC6147F FOREIGN KEY (production_id) REFERENCES production (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78E4873418 FOREIGN KEY (main_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE member_image ADD CONSTRAINT FK_A71C91AC7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_image ADD CONSTRAINT FK_A71C91AC3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD398627294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD398623DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E025576DBD FOREIGN KEY (play_id) REFERENCES play (id)');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E0E4873418 FOREIGN KEY (main_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE ticket_request ADD CONSTRAINT FK_375BD6CD71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD398627294869C');
        $this->addSql('ALTER TABLE ticket_request DROP FOREIGN KEY FK_375BD6CD71F7E88B');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78E4873418');
        $this->addSql('ALTER TABLE member_image DROP FOREIGN KEY FK_A71C91AC3DA5256D');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD398623DA5256D');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E0E4873418');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F97937597D3FE');
        $this->addSql('ALTER TABLE member_image DROP FOREIGN KEY FK_A71C91AC7597D3FE');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E025576DBD');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793ECC6147F');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7ECC6147F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FECC6147F');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793D60322AC');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_image');
        $this->addSql('DROP TABLE paragraph');
        $this->addSql('DROP TABLE play');
        $this->addSql('DROP TABLE production');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE ticket_request');
    }
}
