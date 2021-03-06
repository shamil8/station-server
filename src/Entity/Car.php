<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"car:read"}},
 *     denormalizationContext={"groups"={"car:write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 * @ApiFilter(BooleanFilter::class, properties={"isDelete"})
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"car:read", "car:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"car:read", "car:write"})
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"car:read", "car:write"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"car:read", "car:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"car:write"})
     */
    private $isDelete = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CarStation", mappedBy="cars")
     */
    private $carStations;

    public function __construct()
    {
        $this->carStations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIsDelete(): ?bool
    {
        return $this->isDelete;
    }

    public function setIsDelete(bool $isDelete): self
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * @return Collection|CarStation[]
     */
    public function getCarStations(): Collection
    {
        return $this->carStations;
    }

    public function addCarStation(CarStation $carStation): self
    {
        if (!$this->carStations->contains($carStation)) {
            $this->carStations[] = $carStation;
            $carStation->setCars($this);
        }

        return $this;
    }

    public function removeCarStation(CarStation $carStation): self
    {
        if ($this->carStations->contains($carStation)) {
            $this->carStations->removeElement($carStation);
            // set the owning side to null (unless already changed)
            if ($carStation->getCars() === $this) {
                $carStation->setCars(null);
            }
        }

        return $this;
    }
}
