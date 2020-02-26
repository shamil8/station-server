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
 *     normalizationContext={"groups"={"station:read"}},
 *     denormalizationContext={"groups"={"station:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StationRepository")
 * @ApiFilter(BooleanFilter::class, properties={"isDelete"})
 */
class Station
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"station:read", "station:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "station:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "station:write"})
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "station:write"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CarStation", mappedBy="stations")
     */
    private $carStations;

    /**
     * @ORM\Column(type="date")
     * @Groups({"station:read", "station:write"})
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"station:write"})
     */
    private $isDelete = false;

    public function __construct()
    {
        $this->carStations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
            $carStation->setStations($this);
        }

        return $this;
    }

    public function removeCarStation(CarStation $carStation): self
    {
        if ($this->carStations->contains($carStation)) {
            $this->carStations->removeElement($carStation);
            // set the owning side to null (unless already changed)
            if ($carStation->getStations() === $this) {
                $carStation->setStations(null);
            }
        }

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

    public function getIsDelete(): ?bool
    {
        return $this->isDelete;
    }

    public function setIsDelete(bool $isDelete): self
    {
        $this->isDelete = $isDelete;

        return $this;
    }
}
