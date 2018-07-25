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
 * @license   CECIL-B
 *
 * @see https://github.com/Alexandre-T/casguard/blob/master/LICENSE
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
     * "All statistics" Controller.
     *
     * @Route("/api/statistics", name="statistic")
     *
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function allStatistics(EntityManagerInterface $em): JsonResponse
    {
        /** @var PassageRepository $passageRepository */
        $passageRepository = $em->getRepository('App:Passage');
        /** @var CameraRepository $cameraRepository */
        $cameraRepository = $em->getRepository('App:Camera');

        $totalPassage = $passageRepository->countAll();
        $totalCamion = $passageRepository->countCamionFiable();
        $totalCamera = $cameraRepository->countAll();
        $activeCamera = $cameraRepository->countActive();

        $response = new JsonResponse();
        $response->setData([
            'activeCameras' => $activeCamera,
            'passages' => $totalPassage,
            'camions' => $totalCamion,
            'cameras' => $totalCamera
        ]);

        return $response;
    }

    /**
     * @Route("/api/cameras/count", name="statistic_camera")
     * @Route("/api/statistics/camera", name="statistic_camera")
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