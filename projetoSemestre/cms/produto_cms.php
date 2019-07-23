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
            $sqlUpdateStatus = "UPDATE tbl_produto SET status = 0 WHERE cod_produto =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: produto_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            $sqlUpdateStatus = "UPDATE tbl_produto SET status = 1 WHERE cod_produto =".$id;

            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: produto_cms.php");
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
        <title>Produto - CMS | Acme Tunes</title>
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
                        <div id="titulo-fale-conosco"> Administração Produto</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-id">Id</th>
                                <th class="th-titulo">Foto</th>
                                <th class="th-titulo">Titulo</th>
                                <th class="th-titulo">Preço</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT * FROM tbl_produto";
                                $select = mysqli_query($conexao , $sqlSelect);
                                
                                while($rs = mysqli_fetch_array($select)){
                                    $valor = 'R$ '. number_format($rs['preco'], 2, ',', '.');
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['cod_produto'])?></td>
                                <td class="td-itens">
                                    <img class='img-produto' src="../imagem/<?php echo($rs['imagem_filme'])?>">
                                </td>
                                <td class="td-itens"><?php echo($rs['titulo'])?></td>
                                <td class="td-itens"><?php echo($valor)?></td>
                                <td class="td-itens">
                                    <a href="cad_produto.php?id=<?php echo($rs['cod_produto']);?>&&modo=editar">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="produto_cms.php?id=<?php echo($rs['cod_produto']);?>&&status=<?php echo($rs['status'])?>">
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
                        <a href="cad_produto.php">
                            <input type="button" class="center" id="btn-cadastro-2" value="Cadastrar Produto">
                        </a>
                        <a href="relacao_cms.php">
                            <input type="button" class="center" id="btn-cadastro" value="Relacionar">
                        </a>
                    </div>                            
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>