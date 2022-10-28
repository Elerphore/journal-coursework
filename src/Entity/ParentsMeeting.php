<?php

namespace App\Entity;

use App\Repository\ParentsMeetingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParentsMeetingRepository::class)
 * @ORM\Table(name="parentsmeeting")
 */
class ParentsMeeting
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
     * @ORM\Column(name="Subject", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $subject;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\PositiveOrZero()
     */
    private $qty;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="parentsMeetings")
     * @ORM\JoinColumn(name="id_group", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $group;

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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): self
    {
        $this->group = $group;

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
