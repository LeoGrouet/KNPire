<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task', name: "app_task_")]
class TaskController extends AbstractController
{
    #[Route('/', name: 'home',  methods: ["GET"])]
    public function index(TaskRepository $taskrepo, Security $security): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $security->getUser();
        $tasks = $taskrepo->findAll();

        return $this->render('task/task.html.twig', [
            'tasks' => $tasks,
            'user' => $user
        ]);
    }

    #[Route('/{team}', name: 'team',  methods: ["GET"])]
    public function teamTask(TaskRepository $taskrepo, Security $security): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $security->getUser();

        if ($user instanceof User) {
            $userTeam = $user->getTeam();
        }

        $tasks = $taskrepo->findByUserteam($userTeam);

        return $this->render('task/task.html.twig', [
            'tasks' => $tasks,
            'user' => $user
        ]);
    }

    #[Route('/{team}/{username}', name: 'self',  methods: ["GET"])]
    public function userTask(TaskRepository $taskrepo, Security $security): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $security->getUser();

        if ($user instanceof User) {
            $userId = $user->getId();
        }

        $tasks = $taskrepo->findByUserId($userId);

        return $this->render('task/task.html.twig', [
            'tasks' => $tasks,
            'user' => $user

        ]);
    }



    #[Route('/edit/{id}', name: 'edit',  methods: ["GET", "POST"], priority: 1)]
    public function edit(Task $task, Request $request, TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $taskrepo->upsert($task);
            $this->addFlash('success', 'Tâche modifiée');
            return $this->redirectToRoute('app_task_home');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form,
            'task' => $task
        ]);
    }

    #[Route('/delete/{id}', name: 'delete',  methods: ["GET", "POST"], priority: 2)]
    public function delete(Task $task, TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        if ($task !== null) {
            $taskrepo->delete($task);
        }
        $this->addFlash('success', 'Tâche supprimée');
        return $this->redirectToRoute('app_task_home');
    }

    #[Route('/add', name: 'add',  methods: ["GET", "POST"], priority: 1)]
    public function add(Request $request, TaskRepository $taskrepo, Security $security): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $user = $security->getUser();

        $form = $this->createForm(TaskType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task = new Task(
                $data["name"],
                $data["description"],
                $data["points"],
            );
            $task->setUser($user);
            $taskrepo->upsert($task);
            $this->addFlash('success', 'Nouvelle tâche créé');

            return $this->redirectToRoute('app_task_home');
        }

        return $this->render('task/add.html.twig', [
            'form' => $form
        ]);
    }
}
