<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task', name: "app_task_")]
class TaskController extends AbstractController
{
    #[Route('/', name: 'home',  methods: ["GET"])]
    public function index(TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $tasks = $taskrepo->findAll();

        return $this->render('task/task.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/edit/{id}', name: 'edit',  methods: ["GET", "POST"])]
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

    #[Route('/delete/{id}', name: 'delete',  methods: ["GET", "POST"])]
    public function delete(Task $task, TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if ($task !== null) {
            $taskrepo->delete($task);
        }

        return $this->redirectToRoute('app_task_home');
    }

    #[Route('/add', name: 'add',  methods: ["GET", "POST"])]
    public function add(Request $request, TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $form = $this->createForm(TaskType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task = new Task(
                $data["name"],
                $data["description"],
                $data["points"],
            );
            $taskrepo->upsert($task);
            $this->addFlash('success', 'Nouvelle tâche créé');

            return $this->redirectToRoute('app_task_home');
        }

        return $this->render('task/add.html.twig', [
            'form' => $form
        ]);
    }
}
