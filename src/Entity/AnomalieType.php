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
 * Plaques et statistiques qui rencontrent des problèmes sur le type de véhicule identifié.
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="ve_anomalie_type",
 *     schema="data",
 * )
 *
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     attributes={"order"={"nbCamion":"ASC","identification":"DESC","ecart":"DESC","passage":"DESC"}}
 * )
 */
class AnomalieType
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
     * Nombre de types distincts. (1, 2 ou 3).
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $identification;

    /**
     * Nombre de passages totaux repérés.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $passage;

    /**
     * Nombre de passages où le véhicule a été repéré comme un camion.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $nbCamion;

    /**
     * Nombre de passages où le véhicule a été repéré comme un véhicule léger.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $nbVoiture;

    /**
     * Nombre de passages où le véhicule n'a pas pu être identifié.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $nbInconnu;

    /**
     * Ecart entre le nombre d'identification VL/PL.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $ecart;

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
     * Récupère le nombre de passages.
     *
     * @return int
     */
    public function getPassage(): int
    {
        return $this->passage;
    }

    /**
     * @return int
     */
    public function getIdentification(): int
    {
        return $this->identification;
    }

    /**
     * @return int
     */
    public function getNbCamion(): int
    {
        return $this->nbCamion;
    }

    /**
     * @return int
     */
    public function getNbVoiture(): int
    {
        return $this->nbVoiture;
    }

    /**
     * @return int
     */
    public function getNbInconnu(): int
    {
        return $this->nbInconnu;
    }

    /**
     * @return int
     */
    public function getEcart(): int
    {
        return $this->ecart;
    }
}
