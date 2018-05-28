<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180527213704 extends AbstractMigration
{
    /**
     * Ajoute la vue des camions fiables.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE VIEW data.ve_camion_fiable as select p.immatriculation as immatriculation, p.state as pays, count(distinct camera_id) as camera, count(distinct p.id) as passage from data.te_passage p where p.fiability >= 99   and p.l = 1   and p.data_fictive is false group by p.immatriculation, p.state  having count(distinct p.id) > 1 order by count(distinct p.id) desc ');
    }

    /**
     * Supprime la vue des camions fiables.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW data.ve_camion_fiable');
    }
}
