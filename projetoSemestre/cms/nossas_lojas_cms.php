<?php 
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    $conexao = conexaoMysql();

    //Modo modificar status
    if(isset($_GET['id']) && isset($_GET['status'])){
        $status = $_GET['status'];
        $id = $_GET['id'];

        if($status == 1){
            //Desabilitar
            $sqlUpdateStatus = "UPDATE tbl_loja SET status = 0 WHERE cod_loja =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: nossas_lojas_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
             //Habilitar
             $sqlDesabilitarTodos = "UPDATE tbl_nossas_lojas SET status = 0";
             if(mysqli_query($conexao, $sqlDesabilitarTodos)){
                 $sqlUpdateStatus = "UPDATE tbl_nossas_lojas SET status = 1 WHERE cod_pagina =".$id;
                 if(mysqli_query($conexao, $sqlUpdateStatus)){
                     header("location: nossas_lojas_cms.php");
                 }else{
                     echo("<script>alert('Erro');</script>");
                 }
             }
        }
    }

    if(isset($_GET['id']) && isset($_GET['modo'])){
        $id = $_GET['id'];
        $sqlDelete = "DELETE FROM tbl_rel_loja WHERE cod_pagina =".$id;

        if(mysqli_query($conexao, $sqlDelete)){
            $sqlDelete = "DELETE FROM tbl_nossas_lojas WHERE cod_pagina =".$id;
            if(mysqli_query($conexao, $sqlDelete)){
                header("location: nossas_lojas_cms.php");
            }
        }else{
            echo("<script>alert('Erro');</script>");
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Nossas Loja - CMS | Acme Tunes</title>
        <link rel="stylesheet" type="text/css" href="css/style-padrao-cms.css"/>
        <link rel="stylesheet" type="text/css" href="css/style_cms.css"/>
        <script src="js/jquery.js"></script>
    </head>
    <body>
        <div id="container-modal">
            <div id="modal" class="center"></div>
        </div>
        <!--Div que alinha todo o conteúdo do CMS no meio da pagina-->
        <div id="tudo" class="center">
            <!--CMS-->
            <div id="cms">
                <?php include_once("header_cms.php");?>
                <?php include_once("menu_cms.php");?> 
                <!-- Area do Conteúdo CMS Sobre -->
                <section id="conteudo">
                    <div id="linha-titulo-fale-conosco" class="center">
                        <div id="titulo-fale-conosco"> Administração Nossas Lojas</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-id">Id</th>
                                <th class="th-titulo">Titulo</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Apagar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT * FROM tbl_nossas_lojas";
                                $select = mysqli_query($conexao , $sqlSelect);

                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['cod_pagina'])?></td>
                                <td class="td-itens"><?php echo($rs['titulo_lojas'])?></td>
                                <td class="td-itens">
                                    <a href="cad_nossas_lojas.php?id=<?php echo($rs['cod_pagina']);?>&&modo=editar&&status=<?php echo($rs['status']);?>">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="nossas_lojas_cms.php?id=<?php echo($rs['cod_pagina']);?>&&modo=excluir" onclick="return confirm('Deseja realmente excluir essa Página?')">
                                        <figure>
                                            <img src="icones/icone-excluir.png"/>
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="nossas_lojas_cms.php?id=<?php echo($rs['cod_pagina']);?>&&status=<?php echo($rs['status']);?>">
                                        <figure>
                                            <?php if($rs['status'] == 1){?>
                                                <img src="icones/icone-ativado.png"/>
                                            <?php }else{?>
                                                <img src="icones/icone-desativado.png"/>
                                            <?php }?>    
                                        </figure>   
                                    </a>                                      
                                </td>                                
                            </tr>
                            <?php }?>
                        </table>
                    </div> 
                    <div class="container-btn2">
                        <a href="cad_nossas_lojas.php">
                            <input type="button" class="center" id="btn-cadastro-2" value="Cadastrar Nossas Loja">
                        </a>
                    </div>
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>