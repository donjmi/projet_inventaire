<?php

namespace App\Entity;

use App\Repository\DirectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DirectionRepository::class)
 */
class Direction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="directions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Pole::class, mappedBy="direction", orphanRemoval=true)
     */
    private $poles;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code;

    public function __construct()
    {
        $this->poles = new ArrayCollection();
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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|Pole[]
     */
    public function getPoles(): Collection
    {
        return $this->poles;
    }

    public function addPole(Pole $pole): self
    {
        if (!$this->poles->contains($pole)) {
            $this->poles[] = $pole;
            $pole->setDirection($this);
        }

        return $this;
    }

    public function removePole(Pole $pole): self
    {
        if ($this->poles->removeElement($pole)) {
            // set the owning side to null (unless already changed)
            if ($pole->getDirection() === $this) {
                $pole->setDirection(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
