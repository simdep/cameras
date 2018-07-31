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

    private $filters = [];

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
        //FIXME initialization can't be here
        $start = 9;
        $end = 16;
        $offset = 0;
        $limit = 32;
        $startDate = null;
        $endDate = null;

        //FIXME Transform this manual filters into a dynamic time filters
        if (key_exists('time', $this->filters)) {
            list($start, $end) = explode("..", $this->filters['time']);
            $start = min(24,max(0,(int)$start));
            $end = min(24,max(0,(int)$end));
        }

        //FIXME Transform this manual filters into a dynamic time filters
        if (key_exists('dates', $this->filters)) {
            list($startDateString, $endDateString) = explode("..", $this->filters['dates']);
            $startDate = new \DateTime();
            $endDate = new \DateTime();
            $startDate->setDate(
                substr($startDateString,0,4),
                substr($startDateString,4,2),
                substr($startDateString,6,2)
                );
            $endDate->setDate(
                substr($endDateString,0,4),
                substr($endDateString,4,2),
                substr($endDateString,6,2)
                );
        }

        //FIXME Transform this manual filters into a dynamic integer filters
        if (key_exists('limit', $this->filters)) {
            $limit = max(1,min(128, (int)($this->filters['limit'])));
        }

        return $this->repository->uniqueCars($startDate, $endDate, $start, $end, $offset, $limit);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if (key_exists('filters', $context)) {
            $this->filters = $context['filters'];
        }

        return 'get_unique_cars' === $operationName && Passage::class === $resourceClass;
    }
}