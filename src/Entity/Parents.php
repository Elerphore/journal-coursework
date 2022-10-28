<?php

namespace App\Entity;

use App\Repository\ParentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParentsRepository::class)
 * @ORM\Table(name="parent")
 */
class Parents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Surname", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $surname;

    /**
     * @ORM\Column(name="Name", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $name;

    /**
     * @ORM\Column(name="Patronymic", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $patronymic;

    /**
     * @ORM\Column(name="Phone", type="string", length=30)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $phone;

    /**
     * @ORM\Column(name="Address", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=StudentParent::class, mappedBy="parent")
     */
    private $studentParents;

    public function __construct()
    {
        $this->studentParents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
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

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getFio(): ?string
    {
        $fioParts = [
            $this->getSurname(),
            $this->getName(),
            $this->getPatronymic(),
        ];

        return implode(' ', array_filter($fioParts, static fn($string) => $string !== null && $string !== ''));
    }

    /**
     * @return Collection<int, StudentParent>
     */
    public function getStudentParents(): Collection
    {
        return $this->studentParents;
    }

    public function addStudentParent(StudentParent $studentParent): self
    {
        if (!$this->studentParents->contains($studentParent)) {
            $this->studentParents[] = $studentParent;
            $studentParent->setParent($this);
        }

        return $this;
    }

    public function removeStudentParent(StudentParent $studentParent): self
    {
        if ($this->studentParents->removeElement($studentParent)) {
            // set the owning side to null (unless already changed)
            if ($studentParent->getParent() === $this) {
                $studentParent->setParent(null);
            }
        }

        return $this;
    }
}
