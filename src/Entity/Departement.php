<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Departement
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
     * @ORM\OneToMany(targetEntity=Direction::class, mappedBy="departement", orphanRemoval=true)
     */
    private $directions;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code;

    public function __construct()
    {
        $this->directions = new ArrayCollection();
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

    /**
     * @return Collection|Direction[]
     */
    public function getDirections(): Collection
    {
        return $this->directions;
    }

    public function addDirection(Direction $direction): self
    {
        if (!$this->directions->contains($direction)) {
            $this->directions[] = $direction;
            $direction->setDepartement($this);
        }

        return $this;
    }

    public function removeDirection(Direction $direction): self
    {
        if ($this->directions->removeElement($direction)) {
            // set the owning side to null (unless already changed)
            if ($direction->getDepartement() === $this) {
                $direction->setDepartement(null);
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
