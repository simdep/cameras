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

use App\Entity\Camera;
use Doctrine\ORM\EntityRepository;

/**
 * The camera repository.
 */
class CameraRepository extends EntityRepository
{
    /**
     * Retourne les caméras actives.
     *
     * @return Camera[]
     */
    public function searchActive(): array
    {
        return $this->findBy(['active' => true]);
    }

    /**
     * Retourne les caméras inactives.
     *
     * @return Camera[]
     */
    public function searchInactive(): array
    {
        return $this->findBy(['active' => false]);
    }
}
