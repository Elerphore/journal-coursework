<?php

namespace App\Entity;

use App\Repository\AcademicYearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AcademicYearRepository::class)
 * @UniqueEntity("id")
 */
class AcademicYear
{
    public const MODE_OPENED = 'Открыт';
    public const MODE_CLOSED = 'Закрыт';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Range(min="1900", max="2099")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Choice({self::MODE_OPENED, self::MODE_CLOSED})
     */
    private $mode;

    /**
     * @ORM\OneToMany(targetEntity=Classhour::class, mappedBy="academicYear")
     */
    private $classhours;

    public function __construct()
    {
        $this->classhours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return Collection<int, Classhour>
     */
    public function getClasshours(): Collection
    {
        return $this->classhours;
    }

    public function addClasshour(Classhour $classhour): self
    {
        if (!$this->classhours->contains($classhour)) {
            $this->classhours[] = $classhour;
            $classhour->setAcademicYear($this);
        }

        return $this;
    }

    public function removeClasshour(Classhour $classhour): self
    {
        if ($this->classhours->removeElement($classhour)) {
            // set the owning side to null (unless already changed)
            if ($classhour->getAcademicYear() === $this) {
                $classhour->setAcademicYear(null);
            }
        }

        return $this;
    }
}
