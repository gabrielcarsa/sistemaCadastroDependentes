<?php
    class Controller{
        //função que irá direcionar para sua devida view
        public function redirect($view){
            header('location: '.APP.$view);
        }
        //função que irá incluir uma view
        public function view($view, $data){
            extract($data);
            $arquivo_visao = "views/$view.php";
            include_once "views/template.php";
        }
    }
?>