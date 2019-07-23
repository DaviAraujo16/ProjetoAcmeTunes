<?php 
    session_start();
    require_once("conexao.php");
    $conexao = conexaoMysql();

    $email = "";
    $senha= "";

    if(!isset($_GET['logout'])){

        if(isset($_POST['btn-login'])){
            $login = $_POST['txt-email'];
            $senha = $_POST['txt-senha'];
            $senhaCriptografada = md5($senha);

            $sqlSelect = "SELECT user.cod_usuario, user.nome_usuario, user.status, user.cod_nivel FROM tbl_usuario as user INNER JOIN tbl_nivel_usuario as nivel ON user.cod_nivel = nivel.cod_nivel WHERE user.email = '".addslashes($login)."' AND senha = '$senhaCriptografada' ";
            
            $select = mysqli_query($conexao, $sqlSelect);

            if($rs = mysqli_fetch_array($select)){
                $_SESSION['id'] = $rs['cod_usuario'];
                $_SESSION['nome_user'] = $rs['nome_usuario'];
                $_SESSION['status'] = $rs['status'];
                $_SESSION['nivel'] = $rs['cod_nivel'];

                echo($_SESSION['nivel']);
               echo("<script>window.location.href='index.php</script>");
            }else{
                session_destroy();
                echo("<script>alert('Email ou Senha Incorreto!'); window.location.href='../index.php';</script>");
            }        
        }        
    }else{
        session_destroy();
        echo("<script>window.location.href='../index.php</script>'");
    }
?>