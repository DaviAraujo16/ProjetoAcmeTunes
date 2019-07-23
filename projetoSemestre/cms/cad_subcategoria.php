<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Subcategoria";
    $title = "Cadastro Subcategoria - CMS | Acme Tunes";
    $modo = "Salvar";

    $subCategoria = "";
    $categoria = "";
    $descricao = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $pagina = "Atualização da Subcategoria $id - Subcategoria";
        $title = "Atualização Subcategoria - CMS | Acme Tunes";

        $_SESSION['id'] = $id;

        $sqlSelect = "SELECT * FROM tbl_sub_categoria AS sub INNER JOIN tbl_categoria AS cat ON sub.cod_categoria = cat.cod_categoria WHERE sub.cod_sub_categoria =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $subCategoria = $rs['nome_sub_categoria'];
            $descricao = $rs['descricao'];
            $categoriaSelect = $rs['cod_categoria'];            
        }       
    }

    if(isset($_POST['btn-salvar'])) {
        $subCategoria= $_POST['txt-sub-categoria'];
        $descricao = $_POST['txt-texto'];
        $categoria = $_POST['combo-categoria'];

        if($_POST['btn-salvar'] == "Salvar"){
            
            if(!empty($categoria)){
                $sqlInsert = "INSERT INTO tbl_sub_categoria (nome_sub_categoria, descricao, cod_categoria, status) VALUES ('".addslashes($subCategoria)."', '".addslashes($descricao)."' , '$categoria', 1)";
                if(mysqli_query($conexao, $sqlInsert)){
                    header("location: subcategoria_cms.php");
                }
            }else{
                echo("<script>alert('Erro ao salvar o Registro');</script>");
            }

        }elseif($_POST['btn-salvar'] == "Editar"){
            $id = $_SESSION['id'];
    
            $sqlUpdate = "UPDATE tbl_sub_categoria SET nome_sub_categoria = '".addslashes($subCategoria)."', descricao = '".addslashes($descricao)."', cod_categoria = '$categoria' WHERE cod_sub_categoria =".$id;
            if(mysqli_query($conexao, $sqlUpdate)){
                header("location: subcategoria_cms.php");
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_subcategoria.php" method="post">
                        <div id="container-cadastro-3" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-categoria">
                                        <label for="txt-categoria">Subcategoria*:</label>
                                    </div>
                                    <div class="area-caixa-texto-sub-categoria">
                                        <input type="text" name="txt-sub-categoria" id="txt-sub-categoria" style="margin-left:34px;" class="caixa-texto-media-sub-categoria" required placeholder="Digite aqui o Nome da Subcategoria" value="<?php echo($subCategoria);?>" maxlength="60">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="combo-categoria">Categoria:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <select name="combo-categoria">
                                            <option value="0" name="categorias">Selecione alguma Categoria!</option>
                                            <?php 
                                                $sqlComboSelect = "SELECT * FROM tbl_categoria WHERE status = 1";
                                                $comboSelect = mysqli_query($conexao, $sqlComboSelect);

                                                while($rs = mysqli_fetch_array($comboSelect)){
                                                    $selected =  $rs['cod_categoria'] == $categoriaSelect ? "selected" : "";     
                                                    $categoria = $rs['cod_categoria']." - ".$rs['nome_categoria'];

                                            ?>
                                            <option value="<?php echo($rs['cod_categoria'])?>" <?php echo($selected)?> name="categorias">
                                                <?php echo($categoria)?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="linha_grande_2">
                                <div class="caixa-textarea-cms ">
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
                                <a href="subcategoria_cms.php">   
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