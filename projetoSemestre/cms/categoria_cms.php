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
            $sqlUpdateStatus = "UPDATE tbl_categoria SET status = 0 WHERE cod_categoria =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: categoria_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            $sqlUpdateStatus = "UPDATE tbl_categoria SET status = 1 WHERE cod_categoria =".$id;

            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: categoria_cms.php");
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
        <title>Categoria - CMS | Acme Tunes</title>
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
                        <div id="titulo-fale-conosco"> Administração Categoria</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-id">Id</th>
                                <th class="th-titulo">Categoria</th>
                                <th class="th-titulo">Descrição</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT * FROM tbl_categoria";
                                $select = mysqli_query($conexao , $sqlSelect);
                                
                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['cod_categoria'])?></td>
                                <td class="td-itens"><?php echo($rs['nome_categoria'])?></td>
                                <td class="td-itens"><?php echo($rs['descricao'])?></td>
                                <td class="td-itens">
                                    <a href="cad_categoria.php?id=<?php echo($rs['cod_categoria']);?>&&modo=editar">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="categoria_cms.php?id=<?php echo($rs['cod_categoria']);?>&&status=<?php echo($rs['status'])?>">
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
                        <a href="cad_categoria.php">
                            <input type="button" class="center" id="btn-cadastro-2" value="Cadastrar Categoria">
                        </a>
                        <a href="subcategoria_cms.php">
                            <input type="button" class="center" id="btn-cadastro" value="Subcategoria">
                        </a>
                    </div>
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>