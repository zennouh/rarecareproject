<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\Table(name: 'patients')]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $sexe = null;

    #[ORM\Column]
    private ?DateTimeImmutable $birthday = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255, name: "seek_name")]
    private ?string $seekName = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(int $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getBirthday(): ?DateTimeImmutable
    {
        return $this->birthday;
    }

   
    public function getAge(): ?int

    {
        if (!$this->birthday) {
            return null;
        }

        $now = new DateTimeImmutable();
        $age = $now->diff($this->birthday)->y;

        return $age;
    }

    public function setBirthday(string $birthday): static
    {
        $this->birthday = new DateTimeImmutable($birthday);

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSeekName(): ?string
    {
        return $this->seekName;
    }

    public function setSeekName(string $seekName): static
    {
        $this->seekName = $seekName;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }
}
