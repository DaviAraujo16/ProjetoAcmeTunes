<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);

    function conexaoMysql(){
        //essa variável recebe a conexao com o mysql
        $conexao = null;

        //essa variavel indica qual servidor está o seu db
        $server = "localhost";

        //essa variavel indica o usuário para entrar no db
        $user = "id9989130_davi";

        //essa variável indica a senha do db
        $password = "18175157";

        //essa variável indica qual é o db
        $database = "id9989130_db_acme_tunes";
        
        $conexao = mysqli_connect($server,$user,$password,$database);
        
        return $conexao;
    }
?>