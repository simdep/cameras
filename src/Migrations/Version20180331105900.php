<?php

declare(strict_types=1);
/**
 * This file is part of the LAPI application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license   MIT
 *
 * @see https://github.com/Alexandre-T/casguard/blob/master/LICENSE
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * First migration.
 */
class Version20180331105900 extends AbstractMigration
{
    /**
     * Database installation.
     *
     * @param Schema $schema
     *
     * @throws AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA data');
        $this->addSql('CREATE SEQUENCE data.te_camera_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE data.te_file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE data.te_passage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.te_camera (id INT NOT NULL, type VARCHAR(8) DEFAULT NULL, serial_number VARCHAR(32) DEFAULT NULL, name VARCHAR(64) DEFAULT NULL, active BOOLEAN DEFAULT \'true\' NOT NULL, code VARCHAR(16) NOT NULL, ip_router VARCHAR(15) NOT NULL, ip_camera VARCHAR(15) DEFAULT NULL, masque SMALLINT DEFAULT 29 NOT NULL, test BOOLEAN DEFAULT false, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX ndx_camera_active ON data.te_camera (active)');
        $this->addSql('CREATE TABLE data.te_file (id INT NOT NULL, directory VARCHAR(255) DEFAULT \'.\' NOT NULL, filename VARCHAR(16) NOT NULL, md5sum VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX ndx_file_md5_sum ON data.te_file (md5sum)');
        $this->addSql('CREATE UNIQUE INDEX ndx_file_name ON data.te_file (directory, filename)');
        $this->addSql('CREATE TABLE data.te_passage (id INT NOT NULL, camera_id INT NOT NULL, file_id INT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, increment INT NOT NULL, s INT DEFAULT 0 NOT NULL, immatriculation VARCHAR(32) NOT NULL, immat VARCHAR(32) NOT NULL, r INT NOT NULL, fiability SMALLINT NOT NULL, coord VARCHAR(255) DEFAULT NULL, h SMALLINT NOT NULL, state VARCHAR(8) DEFAULT NULL, data_fictive BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX ndx_passage_primary ON data.te_passage (camera_id)');
        $this->addSql('CREATE INDEX ndx_file_primary ON data.te_passage (file_id)');
        $this->addSql('CREATE INDEX ndx_passage_immatriculation ON data.te_passage (immatriculation)');
        $this->addSql('CREATE INDEX ndx_passage_immat ON data.te_passage (immat)');
        $this->addSql('CREATE INDEX ndx_passage_fiability ON data.te_passage (fiability)');
        $this->addSql('CREATE INDEX ndx_passage_fictive ON data.te_passage (data_fictive)');
        $this->addSql('ALTER TABLE data.te_passage ADD CONSTRAINT fk_passage_camera FOREIGN KEY (camera_id) REFERENCES data.te_camera (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_passage ADD CONSTRAINT fk_passage_file FOREIGN KEY (file_id) REFERENCES data.te_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * Database purged.
     *
     * @param Schema $schema
     *
     * @throws AbortMigrationException
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_passage DROP CONSTRAINT fk_passage_camera');
        $this->addSql('ALTER TABLE data.te_passage DROP CONSTRAINT fk_passage_file');
        $this->addSql('DROP SEQUENCE data.te_camera_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE data.te_file_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE data.te_passage_id_seq CASCADE');
        $this->addSql('DROP TABLE data.te_camera');
        $this->addSql('DROP TABLE data.te_file');
        $this->addSql('DROP TABLE data.te_passage');
        $this->addSql('DROP SCHEMA data');
    }
}
