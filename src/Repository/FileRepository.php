<?php
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

namespace App\Repository;

use App\Entity\File;
use Doctrine\ORM\EntityRepository;

/**
 * The file repository.
 */
class FileRepository extends EntityRepository
{
    /**
     * Détermine s'il existe un fichier avec cette empreinte dans la base de données.
     *
     * @param string $empreinte
     *
     * @return bool
     */
    public function existsWithEmpreinte(string $empreinte): bool
    {
        //TODO Optimize it by using a count.
        return null !== $this->findOneByEmpreinte($empreinte);
    }

    /**
     * Retourne le fichier correspondant à l'empreinte donnée.
     *
     * @param string $empreinte
     *
     * @return File|null
     */
    public function findOneByEmpreinte(string $empreinte): ?File
    {
        /** @var File $file */
        $file = $this->findOneBy(['md5sum' => $empreinte]);

        return $file;
    }
}
