<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Loja";
    $title = "Cadastro Loja - CMS | Acme Tunes";
    $modo = "Salvar";

    $rua = "";
    $numero= "";
    $cidade = "";
    $descricao = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $status = $_GET['status'];
        $pagina = "Atualização do Registro $id - Loja";
        $title = "Atualização Lojas - CMS | Acme Tunes";

        $_SESSION['id'] = $id;

        $sqlSelect = "SELECT * FROM tbl_loja WHERE cod_loja =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $rua = $rs['rua'];
            $numero = $rs['numero'];
            $cidade = $rs['cidade'];
            $descricao = $rs['descricao'];
        }
       
    }

    if(isset($_POST['btn-salvar'])) {
        $rua = $_POST['txt-rua'];
        $numero = $_POST['txt-numero'];
        $cidade = $_POST['txt-cidade'];
        $descricao = $_POST['txt-descricao'];

        if($_POST['btn-salvar'] == "Salvar"){
            $sqlInsert = "INSERT INTO tbl_loja (rua, numero, cidade,descricao,status) VALUES ('".addslashes($rua)."', '".addslashes($numero)."', '".addslashes($cidade)."','".addslashes($descricao)."', 0)";   
            if(mysqli_query($conexao, $sqlInsert)){
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='loja_cms.php';</script>");
            }else{
                echo("<script>alert('Erro ao salvar o Registro');</script>");
            }   
        }elseif($_POST['btn-salvar'] == "Editar"){
            $status = $_SESSION['status'];
            $id = $_SESSION['id'];
    
            $sqlUpdate = "UPDATE tbl_loja SET rua = '".addslashes($rua)."', numero = '".addslashes($numero)."', cidade = '".addslashes($cidade)."', descricao = '".addslashes($descricao)."' WHERE cod_loja =".$id;
    
            if(mysqli_query($conexao, $sqlUpdate)){
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='loja_cms.php';</script>");
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
        <script src="js/contadorChar.js"></script>
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_loja.php" method="post">
                        <div id="container-cadastro-2" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-rua">Rua*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-rua" style="margin-left:34px;" name="txt-rua" class="caixa-texto" required placeholder="Digite aqui a Rua da loja" value="<?php echo($rua);?>" maxlength="100">
                                    </div>
                                </div>
                                <div class="caixa-second2">
                                    <div class="area-label-4">
                                        <label for="txt-numero">Numero*:</label>
                                    </div>
                                    <div class="area-caixa-texto-3">
                                        <input type="text" id="txt-numero" name="txt-numero" class="caixa-texto-pequena" required placeholder="ex:22" value="<?php echo($numero);?>" maxlength="20">
                                    </div>
                                </div>
                                <div class="caixa-second2">
                                    <div class="area-label-4">
                                        <label for="txt-cidade">Cidade*:</label>
                                    </div>
                                    <div class="area-caixa-texto-3">
                                        <input type="text" id="txt-cidade" name="txt-cidade" class="caixa-texto-media" required placeholder="Digite aqui a cidade" value="<?php echo($cidade);?>">
                                    </div>
                                </div>
                            </div> 
                            <div class="linha_grande_2">
                                <div class="caixa-textarea-cms ">
                                    <div class="area-label-1">
                                        <label for="txt-missao">Descrição*:</label>
                                    </div>
                                    <div class="ajusta-textarea-cms" style="padding-left:20px;">
                                        <textarea class="formatacao-txt" style="margin-left:34px;" name="txt-descricao" id="txt-descricao" required  oninput="contadorCaracteres('txt-descricao');"><?php echo($descricao)?></textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-descricao"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>                      
                        </div>
                        <div class="container-botoes">
                            <div class="caixa-btn">
                                <input type="submit" class="btn btn-salvar center" id="btn-salvar" name="btn-salvar" value="<?php echo($modo);?>">
                            </div>
                            <div class="caixa-btn">
                                <a href="loja_cms.php">   
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