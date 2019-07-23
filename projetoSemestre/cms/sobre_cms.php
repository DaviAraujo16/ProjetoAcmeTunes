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
            $sqlUpdateStatus = "UPDATE tbl_sobre SET status = 0 WHERE cod_pagina =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: sobre_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            //Habilitar
            $sqlDesabilitarTodos = "UPDATE tbl_sobre SET status = 0";
            if(mysqli_query($conexao, $sqlDesabilitarTodos)){
                $sqlUpdateStatus = "UPDATE tbl_sobre SET status = 1 WHERE cod_pagina =".$id;
                if(mysqli_query($conexao, $sqlUpdateStatus)){
                    header("location: sobre_cms.php");
                }else{
                    echo("<script>alert('Erro');</script>");
                }
            }
        }
    }

    if(isset($_GET['id']) && isset($_GET['modo'])){
        $id = $_GET['id'];
        $sqlDelete = "DELETE FROM tbl_sobre WHERE cod_pagina =".$id;

        if(mysqli_query($conexao, $sqlDelete)){
            header("location: sobre_cms.php");
        }else{
            echo("<script>alert('Erro');</script>");
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Sobre - CMS | Acme Tunes</title>
        <link rel="stylesheet" type="text/css" href="css/style-padrao-cms.css"/>
        <link rel="stylesheet" type="text/css" href="css/style_cms.css"/>
        <script src="js/jquery.js"></script>
    </head>
    <body>
        <!--Div que alinha todo o conteúdo do CMS no meio da pagina-->
        <div id="tudo" class="center">
            <!--CMS-->
            <div id="cms">
                <?php include_once("header_cms.php");?>
                <?php include_once("menu_cms.php");?> 
                <!-- Area do Conteúdo CMS Fale conosco -->
                <section id="conteudo">
                    <div id="linha-titulo-fale-conosco" class="center">
                        <div id="titulo-fale-conosco"> Administração Sobre à Locadora</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-id">Id</th>
                                <th class="th-titulo">Titulo</th>
                                <th class="th-titulo">Subtítulo</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Apagar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT * FROM tbl_sobre";
                                $select = mysqli_query($conexao , $sqlSelect);

                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['cod_pagina']);?></td>
                                <td class="td-itens"><?php echo($rs['titulo_sobre']);?></td>
                                <td class="td-itens"><?php echo($rs['sub_titulo']);?></td>
                                <td class="td-itens">
                                    <a href="cad_sobre.php?id=<?php echo($rs['cod_pagina']);?>&&modo=editar&&status=<?php echo($rs['status']);?>">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="sobre_cms.php?id=<?php echo($rs['cod_pagina']);?>&&modo=excluir"  onclick="return confirm('Deseja realmente excluir essa Página?')">
                                        <figure>
                                            <img src="icones/icone-excluir.png"/>
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="sobre_cms.php?id=<?php echo($rs['cod_pagina']);?>&&status=<?php echo($rs['status']);?>">
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
                    <div class="container-btn">
                        <a href="cad_sobre.php">
                            <input type="button" class="center" id="btn-cadastro" value="Cadastrar Sobre">
                        </a>
                    </div>
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>