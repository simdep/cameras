<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509150230 extends AbstractMigration
{
    /**
     * Upgrade database schema.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_camera ALTER test SET NOT NULL');
        $this->addSql('ALTER TABLE data.te_file ALTER filename TYPE VARCHAR(32)');
        $this->addSql('ALTER TABLE data.te_passage ALTER immatriculation TYPE VARCHAR(64)');
        $this->addSql('ALTER TABLE data.te_passage ALTER immat TYPE VARCHAR(64)');
        $this->addSql('ALTER TABLE data.te_passage ALTER r TYPE BIGINT');
        $this->addSql('ALTER TABLE data.te_passage ALTER state TYPE VARCHAR(32)');
    }

    /**
     * Downgrade database schema.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_camera ALTER test DROP NOT NULL');
        $this->addSql('ALTER TABLE data.te_file ALTER filename TYPE VARCHAR(16)');
        $this->addSql('ALTER TABLE data.te_passage ALTER state TYPE VARCHAR(8)');
        $this->addSql('ALTER TABLE data.te_passage ALTER r TYPE INT');
        $this->addSql('ALTER TABLE data.te_passage ALTER immatriculation TYPE VARCHAR(32)');
        $this->addSql('ALTER TABLE data.te_passage ALTER immat TYPE VARCHAR(32)');
    }
}
