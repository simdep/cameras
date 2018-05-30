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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Nombre de passages de camions identifiés par leur plaque et leur pays.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PassageRepository")
 * @ORM\Table(
 *     name="ve_camion_fiable",
 *     schema="data",
 * )
 *
 * @ApiResource(
 *     collectionOperations={"get"},
 *     attributes={"order"={"passage":"DESC"}}
 * )
 */
class CamionFiable
{
    /**
     * Plaque d'immatriculation.
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $immatriculation;

    /**
     * Pays d'immatriculation.
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $pays;

    /**
     * Nombre de caméras distinctes devant lesquelles le camion est passé.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $camera;

    /**
     * Nombre de passages repérés.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $passage;

    /**
     * Immatriculation cryptée lue sur le camion.
     *
     * @return string
     */
    public function getImmatriculation(): string
    {
        return $this->immatriculation;
    }

    /**
     * Pays lu sur la plaque.
     *
     * @return string
     */
    public function getPays(): string
    {
        return $this->pays;
    }

    /**
     * Récupère le nombre de caméras.
     *
     * @return int
     */
    public function getCamera(): int
    {
        return $this->camera;
    }

    /**
     * Récupère le nombre de passages.
     *
     * @return int
     */
    public function getPassage(): int
    {
        return $this->passage;
    }
}
