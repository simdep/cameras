<?php
/*
 * This file is part of the LAPI Application.
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@cerema.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Passage;
use App\Repository\PassageRepository;
use Doctrine\ORM\EntityManagerInterface;

class UniqueCarCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var PassageRepository
     */
    private $repository;

    /**
     * UniqueCarCollectionDataProvider constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository('App:Passage');
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        return $this->repository->uniqueCars();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return 'get_unique_cars' === $operationName && Passage::class === $resourceClass;
    }
}