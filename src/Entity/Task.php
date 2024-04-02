<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $taskname;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $description;

    #[ORM\Column(type: 'integer')]
    private int $points;

    public function __construct(string $taskname, string $description, int $points)
    {
        $this->taskname = $taskname;
        $this->description = $description;
        $this->points = $points;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTaskname(): string
    {
        return $this->taskname;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
