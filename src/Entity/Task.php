<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $description;

    #[ORM\Column(type: 'integer')]
    private int $points;

    #[OneToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User|null $user = null;

    public function __construct(string $name, string $description, int $points)
    {
        $this->name = $name;
        $this->description = $description;
        $this->points = $points;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getname(): string
    {
        return $this->name;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getUser(): User
    {
        return $this->user;
    }
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
