<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Categoria";
    $title = "Cadastro Categoria - CMS | Acme Tunes";
    $modo = "Salvar";

    $nomeCategoria = "";
    $descricao = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $pagina = "Atualização da Categoria $id - Categoria";
        $title = "Atualização Categoria - CMS | Acme Tunes";

        $_SESSION['id'] = $id;

        $sqlSelect = "SELECT * FROM tbl_categoria WHERE cod_categoria =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $nomeCategoria = $rs['nome_categoria'];
            $descricao = $rs['descricao'];
        }       
    }

    if(isset($_POST['btn-salvar'])) {
        $nomeCategoria = $_POST['txt-categoria'];
        $descricao = $_POST['txt-texto'];

        if($_POST['btn-salvar'] == "Salvar"){
            
            $sqlInsert = "INSERT INTO tbl_categoria (nome_categoria, descricao, status) VALUES ('".addslashes($nomeCategoria)."', '".addslashes($descricao)."' , 1)";     
            if(mysqli_query($conexao, $sqlInsert)){
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='categoria_cms.php';</script>"); 
            }else{
                echo("<script>alert('Erro ao salvar o Registro');</script>");
            }    

        }elseif($_POST['btn-salvar'] == "Editar"){
            $id = $_SESSION['id'];
    
            $sqlUpdate = "UPDATE tbl_categoria SET nome_categoria = '".addslashes($nomeCategoria)."', descricao = '".addslashes($descricao)."'  WHERE cod_categoria =".$id;
    
            if(mysqli_query($conexao, $sqlUpdate)){
                echo("<script>alert('Registro atualizado com Sucesso!'); window.location.href='categoria_cms.php';</script>");
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_categoria.php" method="post">
                        <div id="container-cadastro-3" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-categoria">
                                        <label for="txt-categoria">Categoria*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" name="txt-categoria" id="txt-categoria" style="margin-left:34px;" class="caixa-texto-mediana" required placeholder="Digite aqui o Nome da Categoria" value="<?php echo($nomeCategoria);?>" maxlength="60">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-texto">Descrição*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <textarea class="formatacao-txt" name="txt-texto" id="txt-texto" oninput="contadorCaracteres('txt-texto');"> <?php echo($descricao)?> </textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-texto"></span>
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
                                <a href="categoria_cms.php">   
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