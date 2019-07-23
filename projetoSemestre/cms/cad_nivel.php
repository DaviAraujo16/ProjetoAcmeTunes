<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Nivel de Usuario";
    $title = "Cadastro Nivel de Usuario - CMS | Acme Tunes";
    $modo = "Salvar";

    $nome = "";
    $conteudo = "";
    $contato = "";
    $produto = "";
    $usuario = "";

    //Radios
    $rdConteudoT = "";
    $rdConteudoF = "";
    $rdContatoT = ""; 
    $rdContatoF = "";
    $rdProdutoT = ""; 
    $rdProdutoF = "";
    $rdUsuarioT = ""; 
    $rdUsuarioF = "";
 
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $title = "Atualização Nivel de Usuario - CMS | Acme Tunes";

        $_SESSION['id'] = $id;

        $sqlSelect = "SELECT * FROM tbl_nivel_usuario WHERE cod_nivel =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $nome = $rs['nome_nivel'];
            $rs['adm_conteudo'] == '1' ? $rdConteudoT = "checked" : $rdConteudoF = "checked";
            $rs['adm_contato'] == '1' ? $rdContatoT = "checked" : $rdContatoF = "checked";
            $rs['adm_produto'] == '1' ? $rdProdutoT = "checked" : $rdProdutoF = "checked";
            $rs['adm_usuario'] == '1' ? $rdUsuarioT = "checked" : $rdUsuarioF = "checked";

            $pagina = "Atualização do  $nome - Nível Usuario";
        }       
    }

    if(isset($_POST['btn-salvar'])) {
        $nome = $_POST['txt-nivel'];
        $conteudo = $_POST['rdo-conteudo'];
        $contato =  $_POST['rdo-contato'];
        $produto =  $_POST['rdo-produto'];
        $usuario =  $_POST['rdo-usuario'];

        if($_POST['btn-salvar'] == "Salvar"){
            
            $sqlInsert = "INSERT INTO tbl_nivel_usuario (nome_nivel, adm_conteudo, adm_contato, adm_produto, adm_usuario, status) VALUES ('".addslashes($nome)."', '$conteudo', '$contato', '$produto', '$usuario', 1)";
            echo($sqlInsert);
            if(mysqli_query($conexao, $sqlInsert)){
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='nivel_usuario_cms.php';</script>");
            }else{
                echo("<script>alert('Erro ao salvar o Registro');</script>");
            }
           
        }elseif($_POST['btn-salvar'] == "Editar"){
            $id = $_SESSION['id'];
    
            $sqlUpdate = "UPDATE tbl_nivel_usuario SET nome_nivel = '".addslashes($nome)."', adm_conteudo = '$conteudo', adm_contato = '$contato', adm_produto = '$produto', adm_ususario = '$usuario' WHERE cod_nivel =".$id;
            echo($sqlUpdate);
    
            if(mysqli_query($conexao, $sqlUpdate)){
                //echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='nivel_usuario_cms.php';</script>");
            }else{
                echo('<script>alert("Erro ao atualizar o Registro");</script>');
                $modo = "Editar";
            }
        }            
    }         
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?php echo($title)?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao-cms.css"/>
        <link rel="stylesheet" type="text/css" href="css/style_cms.css"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
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
                    <div id="container-titulo" class="center">
                        <div id="titulo"><?php echo($pagina);?></div>
                    </div>
                    <form id="frmCadastro" name="frmCadastro" action="cad_nivel.php" method="post">
                        <div id="container-cadastro-nivel" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-nivel">Nome*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-nivel" name="txt-nivel" class="caixa-texto-grande" required placeholder="Digite aqui o Nome do Nível de Usuário" value="<?php echo($nome);?>" maxlength="40">
                                    </div>
                                </div>
                                
                            </div>
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="rdo-contatos">Adm. Conteúdo*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1 txt">
                                        <input type="radio" class ="radio" name="rdo-conteudo" id="rd-conteudo-t" value="1" <?php echo($rdConteudoT)?>>Sim
                                        <input type="radio" class ="radio" name="rdo-conteudo" id="rd-conteudo-f" value="0" <?php echo($rdConteudoF)?>>Não
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-1">
                                        <label for="rdo-conteudo">Adm. Contatos*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1 txt">
                                        <input type="radio" class ="radio" name="rdo-contato" id="rd-contato-t" value="1" <?php echo($rdContatoT)?>>Sim
                                        <input type="radio" class ="radio" name="rdo-contato" id="rd-contato-f" value="0"  <?php echo($rdContatoF)?>>Não
                                    </div>
                                </div>                                
                            </div>
                            <div class='linha-form-1 center'>
                            <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="rdo-produtos">Adm. Produtos*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1 txt">
                                        <input type="radio" class ="radio" name="rdo-produto" id="rd-produto-t" value="1"  <?php echo($rdProdutoT)?>>Sim
                                        <input type="radio" class ="radio" name="rdo-produto" id="rd-produto-f" value="0"  <?php echo($rdProdutoF)?>>Não 
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-1">
                                        <label for="rdo-usuarios">Adm. Usuários*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1 txt">
                                        <input type="radio" class ="radio" name="rdo-usuario" id="rd-usuario-t" value="1"  <?php echo($rdUsuarioT)?>>Sim
                                        <input type="radio" class ="radio" name="rdo-usuario" id="rd-usuario-f" value="0"  <?php echo($rdUsuarioF)?>>Não 
                                    </div>
                                </div>
                            </div>               
                        </div>
                        <div class="container-botoes">
                            <div class="caixa-btn">
                                <input type="submit" class="btn btn-salvar center" id="btn-salvar" name="btn-salvar" value="<?php echo($modo);?>">
                            </div>
                            <div class="caixa-btn">
                                <a href="nivel_usuario_cms.php">   
                                    <input type="button" class="btn btn-cancelar center" id="btn-cancelar" value="Cancelar">
                                </a>
                            </div>
                        </div>
                    </form>                 
                </section>        
            </div>
        </div>   
    </body>
</html>