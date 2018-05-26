<?php
/**
 * Created by PhpStorm.
 * User: alexandre.tranchant
 * Date: 25/05/2018
 * Time: 18:23
 */

namespace App\Controller;


use App\Repository\CameraRepository;
use App\Repository\PassageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Statistic controller
 *
 * @package App\Controller
 */
class StatisticController
{

    /**
     * @Route("/api/cameras/count", name="statistic_camera")
     *
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function cameraCount(EntityManagerInterface $em): JsonResponse
    {
        /** @var CameraRepository $repository */
        $repository = $em->getRepository('App:Camera');
        $total = $repository->countAll();
        $active = $repository->countActive();

        $response = new JsonResponse();
        $response->setData([
            'total' => $total,
            'active' => $active,
        ]);

       return $response;
    }

    /**
     * @Route("/api/passages/count", name="statistic_passage")
     *
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function passageCount(EntityManagerInterface $em): JsonResponse
    {
        /** @var PassageRepository $repository */
        $repository = $em->getRepository('App:Passage');
        $total = $repository->countAll();

        $response = new JsonResponse();
        $response->setData([
            'total' => $total,
        ]);

       return $response;
    }

    /**
     * @Route("/api/passages/countCamion", name="statistic_camion")
     *
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function camionCount(EntityManagerInterface $em): JsonResponse
    {
        /** @var PassageRepository $repository */
        $repository = $em->getRepository('App:Passage');
        $total = $repository->countCamionFiable();

        $response = new JsonResponse();
        $response->setData([
            'total' => $total,
        ]);

       return $response;
    }

}