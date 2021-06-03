<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TodoRepository;

/**
     * @Route("/api/todo", name="todo.")
     */
class TodoController extends AbstractController
{
    /**
     * @Route("/read", name="read")
     */
    public function index(TodoRepository $todoRepository): Response
    {
		
       $todos = $todoRepository->findAll();
	   $arrayOfTodos = [];
	   foreach($todos as $todo){
		   $arrayOfTodos[] = $todo->toArray();
	   }
	   
	   return $this->json($arrayOfTodos);
    }
}
