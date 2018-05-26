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
use Doctrine\ORM\NonUniqueResultException;

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

    /**
     * Retourne le nombre total de caméras.
     *
     * @return int
     */
    public function countAll(): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('count(c.id)');

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    /**
     * Retourne le nombre de caméras actives.
     *
     * @return int
     */
    public function countActive(): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->where('c.active = true');

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }


}
