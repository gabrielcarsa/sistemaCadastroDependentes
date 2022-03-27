<?php
    include_once "autoload.php";

    //diretório do projeto
    define ("APP", "http://localhost/teste-quality/");

    //Se já existir uma URL definida irá para o Index senão...
    $url = !isset($_GET['url']) ? "index/index" : $_GET['url'];

    //Tirar ocorrência de '/' da URL e cria um array
    $parametros = explode('/', $url);

    //Converte para maiúscula a primeira letra
    $nomeControlador = ucfirst($parametros[0])."Controller";//parâmetro 0 é o nome do Controller

    $acao = $parametros[1];//parâmetro 1 é a ação do Controller


    if (count($parametros) > 2) {
        $id = $parametros[2];
        $controller = new $nomeControlador();
        $controller->$acao($id);
    } else {
        $controller = new $nomeControlador();
        $controller->$acao();
    }


 ?>