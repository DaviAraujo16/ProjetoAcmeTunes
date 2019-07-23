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
            $sqlUpdateStatus = "UPDATE tbl_sub_categoria SET status = 0 WHERE cod_sub_categoria =".$id;
            echo($sqlUpdateStatus);
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: subcategoria_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            $sqlUpdateStatus = "UPDATE tbl_sub_categoria SET status = 1 WHERE cod_sub_categoria =".$id;
            echo($sqlUpdateStatus);

            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: subcategoria_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Subcategoria - CMS | Acme Tunes</title>
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
                <!-- Area do Conteúdo CMS Sobre -->
                <section id="conteudo">
                    <div id="linha-titulo-fale-conosco" class="center">
                        <div id="titulo-fale-conosco"> Administração Subcategoria</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-id">Id</th>
                                <th class="th-titulo">Categoria</th>
                                <th class="th-titulo">Subcategoria</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT sub.cod_sub_categoria, cat.nome_categoria, sub.nome_sub_categoria, sub.status FROM tbl_sub_categoria AS sub INNER JOIN tbl_categoria AS cat ON sub.cod_categoria = cat.cod_categoria;";
                                $select = mysqli_query($conexao , $sqlSelect);
                                
                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['cod_sub_categoria'])?></td>
                                <td class="td-itens"><?php echo($rs['nome_categoria'])?></td>
                                <td class="td-itens"><?php echo($rs['nome_sub_categoria'])?></td>
                                <td class="td-itens">
                                    <a href="cad_subcategoria.php?id=<?php echo($rs['cod_sub_categoria']);?>&&modo=editar">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="subcategoria_cms.php?id=<?php echo($rs['cod_sub_categoria']);?>&&status=<?php echo($rs['status'])?>">
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
                    <div class="container-btns-g-p">
                        <a href="cad_subcategoria.php">
                            <input type="button" class="center" id="btn-cadastro-2" value="Cadastrar Subcategoria">
                        </a>
                        <a href="produto_cms.php">
                            <input type="button" class="center" id="btn-cadastro" value="Produto">
                        </a>
                    </div>
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>