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
}
