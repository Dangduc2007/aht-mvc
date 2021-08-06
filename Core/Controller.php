<?php
namespace mvc\Core;

use mvc\Core\Model;

    class Controller
    {
        var $vars = [];
        var $layout = "default";

        public function set($d)
        {
            $this->vars = array_merge($this->vars, $d);
            print_r($this->vars);
            
        }

        public function render($filename)
        {
            extract($this->vars);
     
            ob_start();
            
            require(ROOT . "Views/" . ucfirst(str_replace("mvc\\s\\","",str_replace('Controller', '', get_class($this)))) . '/' . $filename . '.php');
           
            $content_for_layout = ob_get_clean();
     
            if ($this->layout == false)
            {
                $content_for_layout;
            }
            
            else
            {
               require(ROOT . "Views/Layouts/" . $this->layout . '.php');
            }
        }

        

    }
?>