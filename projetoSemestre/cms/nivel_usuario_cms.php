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
            $sqlUpdateStatus = "UPDATE tbl_nivel_usuario SET status = 0 WHERE cod_nivel =".$id;
            
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: nivel_usuario_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }elseif($status == 0){
            //Habilitar
            $sqlUpdateStatus = "UPDATE tbl_nivel_usuario SET status = 1 WHERE cod_nivel =".$id;
            if(mysqli_query($conexao, $sqlUpdateStatus)){
                header("location: nivel_usuario_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }
        }
    }

    if(isset($_GET['id']) && isset($_GET['modo'])){
        $id = $_GET['id'];
        $essencial = $_GET['essencial'];

        if($essencial != 1){
            $sqlDelete = "DELETE FROM tbl_nivel_usuario WHERE cod_nivel =".$id;

            if(mysqli_query($conexao, $sqlDelete)){
                header("location: nivel_usuario_cms.php");
            }else{
                echo("<script>alert('Erro');</script>");
            }

        }else{
            echo("<script>alert('Não é possível excluir um nível de usuário essencial');</script>");
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Nivel de Usuário - CMS | Acme Tunes</title>
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
                        <div id="titulo-fale-conosco"> Administração Nivel de Usuário</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-titulo">Id</th>
                                <th class="th-titulo">Nome</th>
                                <th class="th-icones">Editar</th>
                                <th class="th-icones">Apagar</th>
                                <th class="th-icones">Status</th>
                            </tr>
                            <?php 
                                $sqlSelect = "SELECT * FROM tbl_nivel_usuario";
                                $select = mysqli_query($conexao , $sqlSelect);

                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['cod_nivel']);?></td>
                                <td class="td-itens"><?php echo($rs['nome_nivel']);?></td>
                                <td class="td-itens">
                                    <a href="cad_nivel.php?id=<?php echo($rs['cod_nivel']);?>&&modo=editar">
                                        <figure>
                                            <img src="icones/icone-editar.png" />
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="nivel_usuario_cms.php?id=<?php echo($rs['cod_nivel']);?>&&modo=excluir&&essencial=<?php echo($rs['essencial'])?>" onclick="return confirm('Deseja realmente excluir esse Nível de Usuário?')">
                                        <figure>
                                            <img src="icones/icone-excluir.png"/>
                                        </figure>   
                                    </a>                                      
                                </td>
                                <td class="td-itens">
                                    <a href="nivel_usuario_cms.php?id=<?php echo($rs['cod_nivel']);?>&&status=<?php echo($rs['status']);?>">
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
                    <div class="container-btns">
                        <a href="cad_nivel.php">
                            <input type="button" class="center" id="btn-cadastro" value="Cadastrar Nivel">
                        </a>
                        <a href="usuario_cms.php">
                            <input type="button" class="center" id="btn-cadastro" value="Usuários">
                        </a>    
                    </div>
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>