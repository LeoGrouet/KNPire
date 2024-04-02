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

class TaskController extends AbstractController
{

    #[Route('/task', name: 'app_task',  methods: ["GET"])]
    public function index(TaskRepository $taskrepo): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $tasks = $taskrepo->findAll();

        return $this->render('task/task.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/task/edit/{id}', name: 'app_task_edit',  methods: ["GET", "POST"])]
    public function edit(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task->setTaskname($data->getTaskname());
            $task->setDescription($data->getDescription());
            $task->setPoints($data->getPoints());
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'Tâche modifiée');
            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form,
            'task' => $task
        ]);
    }

    #[Route('/task/delete/{id}', name: 'app_task_delete',  methods: ["GET", "POST"])]
    public function delete(TaskRepository $taskrepo, int $id, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $task = $taskrepo->find($id);
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('app_task');
    }

    #[Route('/task/add', name: 'app_task_add',  methods: ["GET", "POST"])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $form = $this->createForm(TaskType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task = new Task(
                $data["taskname"],
                $data["description"],
                $data["points"],
            );
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'Nouvelle tâche créé');
            return $this->redirectToRoute('app_task');
        }
        return $this->render('task/add.html.twig', [
            'form' => $form
        ]);
    }
}
