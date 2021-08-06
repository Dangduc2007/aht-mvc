<?php
namespace mvc\Controllers;

use mvc\Models\Task;
use mvc\Core\Controller;
use mvc\Models\TaskRepository;


class TasksController extends Controller
{
 
    public function index() 
    {
        $tasks = new Task();
        $taskRespository = new TaskRepository();
        
        $d['tasks'] = $taskRespository->getAll($tasks);
        $this->set($d);
        $this->render("index");     
    }

    public function create()
    {
        if(isset($_POST['title']) ){
            $tasks = new Task();
            $taskRespository = new TaskRepository();

            $tasks->setTitle($_POST['title']);
            $tasks->setDes($_POST['description']); 
                   
            if($taskRespository->add($tasks)){
                header("location: " . WEBROOT . "Tasks/index");
            }
        }
        $this->render("add");
    }


    public function edit($id)
    {
        $taskRespository = new TaskRepository();

        $d['tasks'] = $taskRespository->get($id);  

        if(isset($_POST['title'])){    

            $tasks = new Task();

            // $tasks->setId($id);   
            $tasks->setTitle($_POST['title']);
            $tasks->setDes($_POST['description']);
            
            if($taskRespository->edit($tasks)){
                header("location:" . WEBROOT . "tasks/index");
                
            }
        }
        $this->set($d);
        $this->render("edit");
    }

    public function delete($id)
    {
        $tasks = new Task();
        $tasks->setId($id);
        $taskRespository = new TaskRepository();
        

        if($taskRespository->delete($tasks)){
            header("location:" . WEBROOT . "tasks/index");
        }  
    }
    
}
