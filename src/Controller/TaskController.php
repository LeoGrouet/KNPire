<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task')]
class TaskController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_task',  methods: ["GET"])]
    public function index(TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $tasks = $taskrepo->findAll();

        return $this->render('task/task.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/edit/{id}', name: 'app_task_edit',  methods: ["GET", "POST"])]
    public function edit(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            $this->addFlash('success', 'Tâche modifiée');

            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form,
            'task' => $task
        ]);
    }

    #[Route('/delete/{id}', name: 'app_task_delete',  methods: ["GET", "POST"])]
    public function delete(Task $task): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if ($task !== null) {
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_task');
    }

    #[Route('/add', name: 'app_task_add',  methods: ["GET", "POST"])]
    public function add(Request $request): Response
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
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            $this->addFlash('success', 'Nouvelle tâche créé');

            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/add.html.twig', [
            'form' => $form
        ]);
    }
}
