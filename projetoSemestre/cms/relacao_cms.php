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
            $sqlUpdateStatus = "UPDATE tbl_relacao_produto SET status = 0 WHERE cod_relacao_produto =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: relacao_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            $sqlUpdateStatus = "UPDATE tbl_relacao_produto SET status = 1 WHERE cod_relacao_produto =".$id;

            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: relacao_cms.php");
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
        <title>Relação - CMS | Acme Tunes</title>
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
                        <div id="titulo-fale-conosco">Administração Relação</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-titulo">Produto</th>
                                <th class="th-titulo">Categoria</th>
                                <th class="th-titulo">Subcategoria</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT rel.cod_relacao_produto , rel.status, prod.titulo, cat.nome_categoria, sub.nome_sub_categoria FROM tbl_relacao_produto AS rel INNER JOIN tbl_sub_categoria AS sub ON rel.cod_sub_categoria = sub.cod_sub_categoria INNER JOIN tbl_categoria AS cat ON rel.cod_categoria = cat.cod_categoria INNER JOIN tbl_produto AS prod ON rel.cod_produto = prod.cod_produto";
                                $select = mysqli_query($conexao , $sqlSelect);
                                
                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['titulo'])?></td>
                                <td class="td-itens"><?php echo($rs['nome_categoria'])?></td>
                                <td class="td-itens"><?php echo($rs['nome_sub_categoria'])?></td>
                                <td class="td-itens">
                                    <a href="cad_relacao.php?id=<?php echo($rs['cod_relacao_produto']);?>&&modo=editar">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="relacao_cms.php?id=<?php echo($rs['cod_relacao_produto']);?>&&status=<?php echo($rs['status'])?>">
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
                        <a href="produto_cms.php">
                            <input type="button" class="center" id="btn-cadastro" value="Cancelar">
                        </a>                       
                        <a href="cad_relacao.php">
                            <input type="button" class="center" id="btn-cadastro-2" value="Cadastrar Relação">
                        </a>
                    </div>                            
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>