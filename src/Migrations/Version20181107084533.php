<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181107084533 extends AbstractMigration
{
    /**
     * Ajout de la colonne immatriculation avec collision.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_passage ADD immat_collision VARCHAR(64) DEFAULT NULL');
        $this->addSql('UPDATE data.te_passage SET immat_collision = immat');
        $this->addSql('CREATE INDEX ndx_passage_immat_collision ON data.te_passage (immat_collision)');
        $this->addSql('ALTER TABLE data.te_passage ALTER immat_collision SET NOT NULL');
    }

    /**
     * Suppression de la colonne immatriculation avec collision.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX data.ndx_passage_immat_collision');
        $this->addSql('ALTER TABLE data.te_passage DROP immat_collision');
    }
}
