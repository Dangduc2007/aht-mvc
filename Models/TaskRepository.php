<?php 
namespace mvc\Models;
use mvc\Models\TaskResaurceModel;
class TaskRepository{
    private $taskResaurceModel;

    // khởi tạo và truyền vào giá trị 
    public function __construct()
    {
        $this->taskResaurceModel = new TaskResaurceModel();
    }
    public function add($model) 
    {
        return  $this->taskResaurceModel->save($model);
    }

    public function edit($model)
    {
        return $this->taskResaurceModel->save($model);
    }

    public function delete(\mvc\Models\Task $model)
    {
    
        return $this->taskResaurceModel->delete($model);     
    }

    public function get(int $id)
    {
        return $this->taskResaurceModel->find($id);
    }

    public function getAll($model)
    {
        return $this->taskResaurceModel->all($model);
    }
}

?>

