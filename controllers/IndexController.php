<?php
    class IndexController extends Controller {
        //Função para criar rota para index
        function index() {
            $dados = array();//criar array vazia para passar como parâmetro
            $this->view('index', $dados);//irá redirecionar para /views/index.php
        }
    }
 ?>
