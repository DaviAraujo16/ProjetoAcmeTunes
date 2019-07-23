<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    $conexao = conexaoMysql();

    $codCategoria = "";
    $dados = "";

    if(isset($_GET['categoria'])){
        $codCategoria = $_GET['categoria'];

        $sqlSelect = "SELECT nome_sub_categoria, cod_sub_categoria FROM tbl_sub_categoria WHERE status = 1 AND cod_categoria = ".$codCategoria;
        $select = mysqli_query($conexao, $sqlSelect);

        while($rs = mysqli_fetch_array($select)){
            $codSubCategoria = $rs['cod_sub_categoria'];
            $valorOption = $rs['cod_sub_categoria'] . " - " . $rs['nome_sub_categoria'];  

            $dados = "
                <option value='".$codSubCategoria."'>".$valorOption."</option>
            "; 
            echo($dados);                                
        }    
    }
?>    

