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

use App\Exception\PassageRepositoryException;
use App\Repository\PassageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Image controller.
 */
class ImageController
{
    /**
     * "All images" Controller.
     *
     * @Route("/api/images/{immatriculation}", name="image")
     *
     * @param EntityManagerInterface $em
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function allImages(EntityManagerInterface $em, string $immatriculation): JsonResponse
    {
        /** @var PassageRepository $passageRepository */
        $passageRepository = $em->getRepository('App:Passage');

        $data = null;
        $error = false;

        try {
            $data = $passageRepository->getImage($immatriculation);
        } catch (PassageRepositoryException $e) {
            $error = $e->getMessage();
        }

        $response = new JsonResponse();
        $response->setData([
            'immatriculation' => $immatriculation,
            'data' => $data,
            'error' => $error,
        ]);

        return $response;
    }
}
