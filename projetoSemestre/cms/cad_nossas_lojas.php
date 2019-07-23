<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Nossas Loja";
    $title = "Cadastro Nossas Loja - CMS | Acme Tunes";
    $modo = "Salvar";

    $titulo = "";
    $loja = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $status = $_GET['status'];
        $pagina = "Atualização do Registro $id - Nossas Loja";
        $title = "Atualização Nossas Lojas - CMS | Acme Tunes";

        $_SESSION['id'] = $id;
        $_SESSION['status'] = $status;


        $sqlSelect = "SELECT * FROM tbl_nossas_lojas WHERE cod_pagina =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $titulo = $rs['titulo_lojas'];

            $sqlSelect2 = "SELECT * FROM tbl_rel_loja WHERE cod_pagina =".$id;
            $select2 = mysqli_query($conexao, $sqlSelect2);

            if($rs2 = mysqli_fetch_array($select2)){
                $loja = $rs2['cod_loja'];
                echo($loja);
            }

        }       
    }

    if(isset($_POST['btn-salvar'])) {
        $titulo = $_POST['txt-titulo'];
        $loja = $_POST['combo-lojas'];

        if($loja != 0){
            if($_POST['btn-salvar'] == "Salvar"){
            
                $sqlInsert1 = "INSERT INTO tbl_nossas_lojas (titulo_lojas, status) VALUES ('".addslashes($titulo)."', 0)";
                
                if(mysqli_query($conexao, $sqlInsert1)){

                    $sqlInsert2 = "INSERT INTO tbl_rel_loja (cod_pagina,cod_loja) VALUES ((SELECT MAX(cod_pagina) FROM tbl_nossas_lojas), '".$loja."')";
                    if(mysqli_query($conexao, $sqlInsert2)){
                        echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='nossas_lojas_cms.php';</script>");
                    }else{
                        echo("<script>alert('Erro ao salvar o Registro');</script>");
                    }
                }else{
                    echo("<script>alert('Erro ao salvar o Registro');</script>");
                }   
            }elseif($_POST['btn-salvar'] == "Editar"){
                $status = $_SESSION['status'];
                $id = $_SESSION['id'];
    
                $sqlUpdate = "UPDATE tbl_nossas_lojas SET titulo_lojas = '".addslashes($titulo)."', status = '".$status."' WHERE cod_pagina =".$id;
    
                if(mysqli_query($conexao, $sqlUpdate)){
                    $sqlUpdate = "UPDATE tbl_rel_loja SET cod_loja ='.$loja.' WHERE cod_pagina =".$id;
                    echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='nossas_lojas_cms.php';</script>");
                }else{
                    echo('<script>alert("Erro ao atualizar o Registro");</script>');
                    $modo = "Editar";
                }
            } 
        }else{
            echo('<script>alert("Para salvar o Registro é necessário selecionar uma Loja!");</script>');
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_nossas_lojas.php" method="post">
                        <div id="container-cadastro-3" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-titulo">Titulo*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" name="txt-titulo" id="txt-titulo" style="margin-left:34px;" name="txt-latitude" class="caixa-texto" required placeholder="Digite aqui o titulo da Página" value="<?php echo($titulo);?>" maxlength="20">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-longitude">Loja*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <select name="combo-lojas">
                                            <option value="0" name="lojas">Selecione alguma Loja!</option>
                                            <?php 
                                                $sqlComboSelect = "SELECT * FROM tbl_loja WHERE status = 1";
                                                $comboSelect = mysqli_query($conexao, $sqlComboSelect);

                                                while($rs = mysqli_fetch_array($comboSelect)){
                                                    $selected =  $rs['cod_loja'] == $loja ? "selected" : "";     
                                                    $endereco = $rs['rua'].", nº ".$rs['numero'].", ".$rs['cidade'];                                            
                                            ?>
                                            <option value="<?php echo($rs['cod_loja'])?>" <?php echo($selected)?> name="lojas">
                                                <?php echo($rs['cod_loja']." - ".$endereco)?>
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
                                <a href="nossas_lojas_cms.php">   
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