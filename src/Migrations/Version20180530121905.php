<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180530121905 extends AbstractMigration
{
    /**
     * Ajout de la vue sur les anomalies.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE VIEW data.ve_anomalie_type as select p.immatriculation, p.state as pays, count(distinct p.l) as identification, count(distinct p.id) as passage, sum(case p.l when 1 then 1 else 0 end) as nb_camion, sum(case p.l when -1 then 1 else 0 end) as nb_voiture, sum(case p.l when 0 then 1 else 0 end) as nb_inconnu, abs(sum(case p.l when 1 then 1 when - 1 then -1 else 0 end)) as ecart from data.te_passage p where p.data_fictive is false group by p.immatriculation, p.state having count(distinct p.l) > 1');
    }

    /**
     * Suppression de la vue sur les anomalies.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW data.ve_anomalie_type');
    }
}
