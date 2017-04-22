<?php

/**
 * Description of BaseConroller
 *
 * @author Faisal
 */
class BaseConroller {
    
    public $view_path;
    
    public function render($view, $params) {
        extract($params);
        $view_file_path = BASE_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$this->view_path.DIRECTORY_SEPARATOR.$view.'.php';
//        var_dump(is_file($view_file_path));
        require $view_file_path;
//        echo get_class($this); // get_class returns name of the class of object.
    }
}
