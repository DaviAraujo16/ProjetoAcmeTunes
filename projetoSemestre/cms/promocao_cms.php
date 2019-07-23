<?php 
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    $conexao = conexaoMysql();

    //Modo modificar status
    if(isset($_GET['id']) && isset($_GET['status'])){
        $status = $_GET['status'];
        $id = $_GET['id'];
        $produto = $_GET['produto'];

        if($status == 1){
            //Desabilitar
            $sqlUpdateStatus = "UPDATE tbl_promocao SET status = 0 WHERE cod_promocao =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){

                $sqlUpdateStatusPromocao = "UPDATE tbl_produto SET status_promocao = 0 WHERE cod_produto =".$produto;
                if(mysqli_query($conexao, $sqlUpdateStatusPromocao)){
                    header("location: promocao_cms.php");
                }else{
                    echo("<script>alert('Erro');</script>"); 
                }               
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            //Habilitar
            $sqlUpdateStatus = "UPDATE tbl_promocao SET status = 1 WHERE cod_promocao =".$id;
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                $sqlUpdateStatusPromocao = "UPDATE tbl_produto SET status_promocao = 1 WHERE cod_produto =".$produto;
                if(mysqli_query($conexao, $sqlUpdateStatusPromocao)){
                    header("location: promocao_cms.php");
                }else{
                    echo("<script>alert('Erro');</script>"); 
                } 
            }else{
                echo("<script>alert('Erro');</script>");
            }

        }
    }

    if(isset($_GET['modo'])){
        $id = $_GET['id'];
        $sqlDelete = "DELETE FROM tbl_promocao WHERE cod_promocao =".$id;

        if(mysqli_query($conexao, $sqlDelete)){
            header("location: promocao_cms.php");
        }else{
            echo("<script>alert('Erro');</script>");
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Promoção - CMS | Acme Tunes</title>
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
                        <div id="titulo-fale-conosco"> Administração Promoção</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-id">Filme</th>
                                <th class="th-titulo">Promoção</th>
                                <th class="th-titulo">Valor Final</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Apagar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT promo.cod_promocao, promo.valor_promocao, promo.status, promo.cod_produto , promo.valor_promocional, produto.titulo FROM tbl_promocao AS promo INNER JOIN tbl_produto AS produto ON promo.cod_produto = produto.cod_produto";
                                $select = mysqli_query($conexao , $sqlSelect);

                                while($rs = mysqli_fetch_array($select)){
                                    $valor = 'R$ '. number_format($rs['valor_promocional'], 2, ',', '.');                                    
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['titulo']);?></td>
                                <td class="td-itens"><?php echo($rs['valor_promocao']."%");?></td>
                                <td class="td-itens"><?php echo($valor);?></td>
                                <td class="td-itens">
                                    <a href="cad_promocao.php?id=<?php echo($rs['cod_promocao']);?>&&modo=editar&&titulo=<?php echo($rs['titulo']);?>">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="promocao_cms.php?id=<?php echo($rs['cod_promocao']);?>&&modo=excluir"  onclick="return confirm('Deseja realmente excluir essa promoção?')">
                                        <figure>
                                            <img src="icones/icone-excluir.png"/>
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="promocao_cms.php?id=<?php echo($rs['cod_promocao']);?>&&status=<?php echo($rs['status']);?>&&produto=<?php echo($rs['cod_produto'])?>">
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
                            <?php 
                                }?>
                        </table>
                    </div> 
                    <div class="container-btn">
                        <a href="cad_promocao.php">
                            <input type="button" class="center" id="btn-cadastro-2" value="Cadastrar Promoção">
                        </a>
                    </div>
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>