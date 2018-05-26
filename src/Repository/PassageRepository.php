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

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * The passage repository.
 */
class PassageRepository extends EntityRepository
{
    /**
     * Retourne le nombre de passages.
     *
     * @return int
     */
    public function countAll(): int
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p.id)');

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    /**
     * Retourne le nombre de passages.
     *
     * @return int
     */
    public function countCamionFiable(): int
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->where('p.fiability > 90')
            ->andWhere('p.l = 1');


        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }
}
