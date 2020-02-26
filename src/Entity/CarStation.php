<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     attributes={
 *          "pagination_items_per_page"=2
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CarStationRepository")
 */
class CarStation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="carStations")
     */
    private $cars;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="carStations")
     */
    private $stations;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCars(): ?Car
    {
        return $this->cars;
    }

    public function setCars(?Car $cars): self
    {
        $this->cars = $cars;

        return $this;
    }

    public function getStations(): ?Station
    {
        return $this->stations;
    }

    public function setStations(?Station $stations): self
    {
        $this->stations = $stations;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
