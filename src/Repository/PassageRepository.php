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

use \DateTime;
use App\Entity\Passage;
use App\Exception\PassageRepositoryException;
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

    /**
     * Retourne l'encodage d'une image en fonction de l'immatriculation.
     *
     * @param string $immatriculation
     *
     * @return string
     *
     * @throws PassageRepositoryException
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function getImage(string $immatriculation): string
    {
        $passages = $this->findByImmatriculation($immatriculation);

        if (0 === count($passages)) {
            throw new PassageRepositoryException('Aucun passage ne correspond à l’immatriculation fournie.');
        }

        foreach ($passages as $passage) {
            /** @var Passage $passage */
            $path = __DIR__ . "/../../data/downloaded/camera-{$passage->getCamera()->getCode()}/images/{$passage->getImage()}";

            $info = new \SplFileInfo($path);

            if ($info->isReadable()) {
                $type = pathinfo($path, PATHINFO_EXTENSION);

                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                return $base64;
            }
        }

        throw new PassageRepositoryException('Aucune image n’existe pour l’immatriculation fournie');
    }

    /**
     * Liste les passages uniques de véhicules détectés comme voiture.
     *
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @param int $start start hour
     * @param int $end end hour
     * @param int $offset
     * @param int $limit nb of element retrieved
     *
     * @return Passage[]
     */
    public function uniqueCars(DateTime $startDate = null, DateTime $endDate = null, int $start = 9, int $end = 15, int $offset = 0, int $limit = 32)
    {
        $passagesId = array_map('array_pop', $this->searchUniquePassages(Passage::CAR, $startDate, $endDate, $start, $end, $offset, $limit));

        return $this->findBy(['id' => $passagesId]);
    }

    /**
     * Liste les passages uniques de véhicules détectés comme camions.
     *
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @param int $start start hour
     * @param int $end end hour
     * @param int $offset
     * @param int $limit nb of element retrieved
     *
     * @return Passage[]
     */
    public function uniqueTrucks(DateTime $startDate = null, DateTime $endDate = null, int $start = 9, int $end = 15, int $offset = 0, int $limit = 32)
    {
        $passagesId = array_map('array_pop', $this->searchUniquePassages(Passage::TRUCK, $startDate, $endDate, $start, $end, $offset, $limit));

        return $this->findBy(['id' => $passagesId]);
    }

    /**
     * Liste les passages uniques de véhicules détectés comme inconnus.
     *
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @param int $start start hour
     * @param int $end end hour
     * @param int $offset
     * @param int $limit nb of element retrieved
     *
     * @return Passage[]
     */
    public function uniqueUnknown(DateTime $startDate = null, DateTime $endDate = null, int $start = 9, int $end = 15, int $offset = 0, int $limit = 32)
    {
        $passagesId = array_map('array_pop', $this->searchUniquePassages(Passage::UNKNOWN, $startDate, $endDate, $start, $end, $offset, $limit));

        return $this->findBy(['id' => $passagesId]);
    }

    /**
     * Retourne le nombre de passages.
     *
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @param int $start start hour
     * @param int $end end hour
     * @param int $offset
     * @param int $limit nb of element retrieved
     *
     * @return array
     */
    protected function searchUniquePassages(int $kind, DateTime $startDate = null, DateTime $endDate = null, int $start = 9, int $end = 15, int $offset = 0, int $limit = 32): array
    {
        $start = sprintf('%02d', max(0,min(24, $start)));
        $end = sprintf('%02d', max(0,min(24, $end)));

        $subquery = $this->createQueryBuilder('c')
            ->select('1')
            ->where('c.immatriculation = p.immatriculation')
            ->groupBy('c.immatriculation')
            ->having('count(c.id) = 1');

        $qb = $this->createQueryBuilder('p')
            ->select('p.id')
            ->where('p.l = :kind')
            ->andWhere("date_format(p.created, 'HH24') >= :start")
            ->andWhere("date_format(p.created, 'HH24') <= :end")
            ->setParameter('kind', $kind)
            ->setParameter('start', $start)
            ->setParameter('end', $end);


        if (null !== $startDate && null !== $endDate) {
           $qb
               ->andWhere("p.created >= :startDate")
               ->andWhere("p.created <= :endDate")
               ->setParameter('startDate', $startDate)
               ->setParameter('endDate', $endDate);
        }

        $qb->setFirstResult($offset)
           ->setMaxResults($limit)
            ->orderBy('p.created','ASC');


        $qb->andWhere($qb->expr()->exists($subquery->getDQL()));

        return $qb->getQuery()->getArrayResult();
    }
}
