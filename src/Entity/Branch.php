<?php

namespace App\Entity;

use App\Repository\BranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BranchRepository::class)
 */
class Branch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Name", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $name;

    /**
     * @ORM\Column(name="Number", type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Positive()
     */
    private $number;

    /**
     * @ORM\Column(name="Supervisor", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $supervisor;

    /**
     * @ORM\OneToMany(targetEntity=Specialty::class, mappedBy="branch")
     */
    private $specialties;

    public function __construct()
    {
        $this->specialties = new ArrayCollection();
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSupervisor(): ?string
    {
        return $this->supervisor;
    }

    public function setSupervisor(string $supervisor): self
    {
        $this->supervisor = $supervisor;

        return $this;
    }

    /**
     * @return Collection<int, Specialty>
     */
    public function getSpecialties(): Collection
    {
        return $this->specialties;
    }

    public function addSpecialty(Specialty $specialty): self
    {
        if (!$this->specialties->contains($specialty)) {
            $this->specialties[] = $specialty;
            $specialty->setBranch($this);
        }

        return $this;
    }

    public function removeSpecialty(Specialty $specialty): self
    {
        if ($this->specialties->removeElement($specialty)) {
            // set the owning side to null (unless already changed)
            if ($specialty->getBranch() === $this) {
                $specialty->setBranch(null);
            }
        }

        return $this;
    }
}
