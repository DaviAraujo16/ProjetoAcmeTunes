<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Usuario";
    $title = "Cadastro Usuario - CMS | Acme Tunes";
    $modo = "Salvar";

    $nome = "";
    $email = "";
    $senha = "";
    $nivel = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $cod = $_GET['id'];
       
        $title = "Atualização Usuario - CMS | Acme Tunes";

        $_SESSION['cod'] = $cod;

        $sqlSelect = "SELECT * FROM tbl_usuario WHERE cod_usuario =".$cod;
        $select = mysqli_query($conexao, $sqlSelect);


        if($rs = mysqli_fetch_array($select)){
            $nome = $rs['nome_usuario'];
            $email = $rs['email'];
            $nivel = $rs['cod_nivel'];
            $pagina = "Atualização do Usuário $nome - Nível Usuario";
        }       
    }

    if(isset($_POST['btn-salvar'])) {
        $nome = $_POST['txt-nome'];
        $email = $_POST['txt-email'];
        $senha = $_POST['txt-senha'];
        $senhaCriptografada = md5($senha);
        $nivel = $_POST['combo-nivel'];

        if($nivel != 0){
            if(!empty($senha)){
                if($_POST['btn-salvar'] == "Salvar"){          
                    $sqlInsert = "INSERT INTO tbl_usuario (nome_usuario, email, senha, cod_nivel, status) VALUES ('".addslashes($nome)."', '".addslashes($email)."', '".$senhaCriptografada."', '$nivel', 1)";
                    if(mysqli_query($conexao, $sqlInsert)){
                        echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='usuario_cms.php';</script>");
                    }else{
                        echo("<script>alert('Erro ao salvar o Registro');</script>");
                    }
                }elseif($_POST['btn-salvar'] == "Editar"){
                    $id = $_SESSION['cod'];
    
                    $sqlUpdate = "UPDATE tbl_usuario SET nome_usuario = '".addslashes($nome)."', email = '".addslashes($email)."', senha = '$senhaCriptografada', cod_nivel = '$nivel' WHERE cod_usuario =".$id;
                    if(mysqli_query($conexao, $sqlUpdate)){
                        echo("<script>alert('Registro editado com Sucesso!'); window.location.href='usuario_cms.php';</script>");
                    }else{
                        echo('<script>alert("Erro ao atualizar o Registro");</script>');
                        $modo = "Editar";
                    }
                }
            }else{
                $id = $_SESSION['cod'];
    
                $sqlUpdate = "UPDATE tbl_usuario SET nome_usuario = '".addslashes($nome)."', email = '".addslashes($email)."', cod_nivel = '$nivel' WHERE cod_usuario =".$id;
                if(mysqli_query($conexao, $sqlUpdate)){
                    echo("<script>alert('Registro editado com Sucesso!'); window.location.href='usuario_cms.php';</script>");
                }else{
                    echo('<script>alert("Erro ao atualizar o Registro");</script>');
                    $modo = "Editar";
                }
            }
        }else{
            echo('<script>alert("Para salvar o Registro é necessário selecionar um Nível de Usuário!");</script>');
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_usuario.php" method="post">
                        <div id="container-cadastro-4" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-titulo">Nome*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-nome" name="txt-nome" class="caixa-texto" required placeholder="Digite aqui o Nome do Usuário" value="<?php echo($nome);?>" maxlength="64">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-nacionalidade">Email*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2"  style="margin-left:10px;">
                                        <input type="email" id="txt-email" name="txt-email" class="caixa-texto" required placeholder="Digite aqui a Email do Usuário"  value="<?php echo($email);?>" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-idade">Senha*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                            <input type="password" id="txt-senha" name="txt-senha" class="caixa-texto" required placeholder="Digite aqui a Senha (Máximo 12 caractéres)" maxlength="12">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-longitude">Nível*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <select name="combo-nivel">
                                            <option value="0" name="nivel">Selecione algum Nível de Usuário!</option>
                                            <?php 
                                                $sqlComboSelect = "SELECT * FROM tbl_nivel_usuario WHERE status = 1";
                                                $comboSelect = mysqli_query($conexao, $sqlComboSelect);
                                                

                                                while($rs = mysqli_fetch_array($comboSelect)){

                                                $selected =  $rs['cod_nivel'] == $nivel ? "selected" : "";                                          
                                            ?>
                                            <option value="<?php echo($rs['cod_nivel'])?>" name="nivel" <?php echo($selected)?>>
                                                <?php echo($rs['cod_nivel']." - ".$rs['nome_nivel'])?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>                 
                        </div>
                        <div class="container-botoes">
                            <div class="caixa-btn">
                                <input type="submit" class="btn btn-salvar center" id="btn-salvar" name="btn-salvar" value="<?php echo($modo);?>">
                            </div>
                            <div class="caixa-btn">
                                <a href="usuario_cms.php">   
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