<?php
    session_start();
    if(isset($_SESSION['id'])){
        if($_SESSION['status'] != 1){
            session_destroy();
            header('location: ../index.php');
        }elseif(empty($_SESSION['id'])){
            session_destroy();
            header('location: ../index.php');
        }
    }else{
        session_destroy();
        header('location: ../index.php');
    }

?>