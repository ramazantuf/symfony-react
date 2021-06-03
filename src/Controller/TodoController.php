<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\TodoRepository;
use App\Entity\Todo;

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
	
	/**
     * @Route("/create", name="create")
	 * @param Request $request
	 * @return JsonResponse
     */
    public function create(Request $request): Response
    {
		
       $content = json_decode($request->getContent());
	   $todo = new Todo();
	   $todo->setName($content->name);
	   try{
		   $em = $this->getDoctrine()->getManager();
		   $em->persist($todo);
		   $em->flush();
		   
	   }catch(Exception $exception){
		    return $this->json([
                'message' => ['text' => ['Could not submit To-Do to the database.'], 'level' => 'error']
            ]);

	   }
	   return $this->json([
				'todo' => $todo->toArray(),
				'message' => ['text'=>['To-do has been created!','Task:'.$content->name],'level'=>'success'],
		   ]);
    }
	
	/**
     * @Route("/update/{id}", name="update", methods={"PUT"})
     */
    public function update(Request $request, Todo $todo): Response
    {
		
       $content = json_decode($request->getContent());
	   
	   $todo->setName($content->name);
	   try{
		   $em = $this->getDoctrine()->getManager();
		   $em->persist($todo);
		   $em->flush();
		   return $this->json([
				'message' => 'todo has been updated',
		   ]);
	   }catch(Exception $exception){
		   //return 
	   }
    }
	/**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Todo $todo): Response
    {
	   try{
		   $em = $this->getDoctrine()->getManager();
		   $em->remove($todo);
		   $em->flush();
		   return $this->json([
				'message' => 'todo has been deleted',
		   ]);
	   }catch(Exception $exception){
		   //return 
	   }
    }
}
