<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Name", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $name;

    /**
     * @ORM\Column(name="Month", type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Choice({"Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"})
     */
    private $month;

    /**
     * @ORM\Column(name="Date", type="date")
     *
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfEvent::class)
     * @ORM\JoinColumn(name="id_typeofevent", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $typeOfEvent;

    /**
     * @ORM\ManyToOne(targetEntity=AcademicYear::class)
     * @ORM\JoinColumn(name="id_academicYear", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $academicYear;

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

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

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

    public function getTypeOfEvent(): ?TypeOfEvent
    {
        return $this->typeOfEvent;
    }

    public function setTypeOfEvent(?TypeOfEvent $typeOfEvent): self
    {
        $this->typeOfEvent = $typeOfEvent;

        return $this;
    }

    public function getAcademicYear(): ?AcademicYear
    {
        return $this->academicYear;
    }

    public function setAcademicYear(?AcademicYear $academicYear): self
    {
        $this->academicYear = $academicYear;

        return $this;
    }
}
