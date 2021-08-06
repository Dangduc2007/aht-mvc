<?php 
namespace mvc\Models;

use mvc\Models\Task;
use mvc\Core\ResaurceModel;

class TaskResaurceModel extends ResaurceModel
{
    function __construct()
    {
        parent::_init('tasks', 'id', new Task);
    }
}   
?>