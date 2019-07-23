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
            $sqlUpdateStatus = "UPDATE tbl_produto SET status_destaque = 0 WHERE cod_produto =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: filme_do_mes_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            //Habilitar
            $sqlUpdateStatus1 = "UPDATE tbl_produto SET status_destaque = 0";
            if(mysqli_query($conexao, $sqlUpdateStatus1)){
                $sqlUpdateStatus2 = "UPDATE tbl_produto SET status_destaque = 1 WHERE cod_produto =".$id;
                if(mysqli_query($conexao, $sqlUpdateStatus2)){
                    header("location: filme_do_mes_cms.php");
                }else{
                    echo("<script>alert('Erro2');</script>");
                }
            }else{
                echo("<script>alert('Erro1');</script>");
            }

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
                                <th class="th-titulo">Filme</th>
                                <th class="th-titulo">Titulo</th>
                                <th class="th-titulo">Dt. Lançamento</th>
                                <th class="th-titulo">Duração</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT cod_produto, imagem_filme, titulo, dt_lancamento, duracao, status_destaque FROM tbl_produto WHERE status = 1";
                                $select = mysqli_query($conexao , $sqlSelect);

                                while($rs = mysqli_fetch_array($select)){                                
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens">
                                    <img class='img-produto' src="../imagem/<?php echo($rs['imagem_filme'])?>">
                                </td>
                                <td class="td-itens"><?php echo($rs['titulo']);?></td>
                                <td class="td-itens"><?php echo($rs['dt_lancamento']);?></td>
                                <td class="td-itens"><?php echo($rs['duracao'])?></td>
                                <td class="td-itens">
                                    <a href="filme_do_mes_cms.php?id=<?php echo($rs['cod_produto']);?>&&status=<?php echo($rs['status_destaque']);?>">
                                        <figure>
                                            <?php if($rs['status_destaque'] == 1){?>
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
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>