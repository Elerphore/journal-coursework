<?php

namespace App\Entity;

use App\Repository\HealthgroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HealthgroupRepository::class)
 */
class Healthgroup
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
     * @ORM\Column(name="Description", type="string", length=1000)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=1000)
     */
    private $description;

    /**
     * @ORM\Column(name="Recommendations", type="string", length=1000)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=1000)
     */
    private $recommendations;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRecommendations(): ?string
    {
        return $this->recommendations;
    }

    public function setRecommendations(string $recommendations): self
    {
        $this->recommendations = $recommendations;

        return $this;
    }
}
