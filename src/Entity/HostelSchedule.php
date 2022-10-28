<?php

namespace App\Entity;

use App\Repository\HostelScheduleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HostelScheduleRepository::class)
 * @ORM\Table(name="hostelschedule")
 */
class HostelSchedule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\Column(name="Note", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="hostelSchedules")
     * @ORM\JoinColumn(name="id_student", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $student;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

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
