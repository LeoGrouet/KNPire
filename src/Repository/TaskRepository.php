<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByUserId(int $id)
    {
        return $this->createQueryBuilder('task')
            ->join('task.user', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findByUserteam(string $team)
    {
        return $this->createQueryBuilder('task')
            ->join('task.user', 'u')
            ->where('u.team = :team')
            ->setParameter('team', $team)
            ->getQuery()
            ->getResult();
    }

    public function upsert(Task $task)
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();
    }

    public function delete(Task $task)
    {
        $this->getEntityManager()->remove($task);
        $this->getEntityManager()->flush();
    }
}
