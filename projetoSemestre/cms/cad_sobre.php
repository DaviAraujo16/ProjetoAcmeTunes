<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    require_once("modulo.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Página Sobre";
    $title = "Cadastro Sobre - CMS | Acme Tunes";
    $modo = "Salvar";

    $titulo = "";
    $subtitulo = "";
    $texto = "";
    $missao = "";
    $visao = "";
    $valores = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $pagina = "Atualização do Registro ".$id." - Pagina Sobre";
        $title = "Atualização Sobre - CMS | Acme Tunes";

        $sqlSelect = "SELECT * FROM tbl_sobre WHERE cod_pagina =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $titulo = $rs['titulo_sobre'];
            $subtitulo = $rs['sub_titulo'];
            $texto = $rs['texto'];
            $missao = $rs['texto_missao'];
            $visao = $rs['texto_visao'];
            $valores = $rs['texto_valores'];
            $nomeFoto = $rs['imagem_sobre'];

            $_SESSION['sobre'] = $id;
            $_SESSION['nome_foto'] = $nomeFoto;
        }
       
    }

    if(isset($_POST['btn-salvar'])) {
        
        $titulo = $_POST['txt-titulo'];
        $subtitulo = $_POST['txt-subtitulo'];
        $texto = $_POST['txt-texto'];
        $missao = $_POST['txt-missao'];
        $visao = $_POST['txt-visao'];
        $valores = $_POST['txt-valores'];
        $fl = $_FILES['fl-foto'];

        if(!empty($fl['name'])){

            $foto = uparFoto($fl);
            if($_POST['btn-salvar'] == "Salvar"){

                $sqlInsert = "INSERT INTO tbl_sobre (titulo_sobre, imagem_sobre, sub_titulo,texto_missao, texto_visao, texto_valores, status, texto) VALUES ('".addslashes($titulo)."', '".addslashes($foto)."', '".addslashes($subtitulo)."', '".addslashes($missao)."', '".addslashes($visao)."', '".addslashes($valores)."', 0, '".$texto."')";  
                if(mysqli_query($conexao, $sqlInsert)){
                    echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='sobre_cms.php';</script>");
                }else{
                    echo("<script>alert('Erro ao salvar o Registro');</script>");
                }   
            }elseif($_POST['btn-salvar'] == "Editar"){
                $status = $_GET['status'];
                $sqlUpdate = "UPDATE tbl_sobre SET titulo_sobre = '".addslashes($titulo)."', imagem_sobre = '".addslashes($foto)."', sub_titulo = '".addslashes($subtitulo)."', texto_missao = '".addslashes($missao)."', texto_visao = '".addslashes($visao)."', texto_valores = '".addslashes($valores)."', status = '.$status.', texto = '".$texto."' WHERE cod_pagina =".$_SESSION['sobre'];
    
                if(mysqli_query($conexao, $sqlUpdate)){
                    header("location:sobre_cms.php");
                    unlink('../imagem/'.$_SESSION['nomeFoto']);
                    $_SESSION['sobre'] = null;
                    $_SESSION['nome_foto'] = null;
                    echo('<script>alert("Registro atualizado com Sucesso!!!");</script>');
                }else{
                    echo('<script>alert("Erro ao atualizar o Registro");</script>');
                    $modo = "Editar";
                }
            }
        }else{
            $sqlUpdate = "UPDATE tbl_sobre SET titulo_sobre = '".addslashes($titulo)."', sub_titulo = '".addslashes($subtitulo)."', texto_missao = '".addslashes($missao)."', texto_visao = '".addslashes($visao)."', texto_valores = '".addslashes($valores)."', texto = '".$texto."' WHERE cod_pagina =".$_SESSION['sobre'];
            if(mysqli_query($conexao, $sqlUpdate)){
                $_SESSION['sobre'] = null;
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='sobre_cms.php';</script>");
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_sobre.php" method="post" enctype="multipart/form-data">
                        <div id="container-cadastro" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-titulo">Título*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-titulo" name="txt-titulo" class="caixa-texto" required placeholder="Digite aqui o titulo da página" value="<?php echo($titulo);?>" maxlength="50">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-subtitulo">Subtítulo*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <input type="text" id="txt-subtitulo" name="txt-subtitulo" class="caixa-texto" required placeholder="Digite aqui o subtítulo da página" value="<?php echo($subtitulo);?>" maxlength="50">
                                    </div>
                                </div>
                            </div> 
                            <div class="linha_grande">
                                <div class="caixa-textarea-cms">
                                    <div class="area-label-1">
                                        <label for="txt-texto">Texto*:</label>
                                    </div>
                                    <div class="ajusta-textarea-cms" >
                                        <textarea class="formatacao-txt" name="txt-texto" id="txt-texto"  required oninput="contadorCaracteres('txt-texto');"><?php echo($texto)?></textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-texto"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="caixa-textarea-cms ">
                                    <div class="area-label-1">
                                        <label for="txt-missao">Missão*:</label>
                                    </div>
                                    <div class="ajusta-textarea-cms" style="padding-left:20px;">
                                        <textarea class="formatacao-txt" name="txt-missao" id="txt-missao" required  oninput="contadorCaracteres('txt-missao');"><?php echo($missao)?></textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-missao"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="linha_grande">
                                <div class="caixa-textarea-cms">
                                    <div class="area-label-1">
                                        <label for="txt-visao">Visão*:</label>
                                    </div>
                                    <div class="ajusta-textarea-cms" >
                                        <textarea class="formatacao-txt" name="txt-visao" id="txt-visao" required oninput="contadorCaracteres('txt-visao');"><?php echo($visao)?></textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-visao"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="caixa-textarea-cms ">
                                    <div class="area-label-1">
                                        <label for="txt-valores">Valores*:</label>
                                    </div>
                                    <div class="ajusta-textarea-cms" style="padding-left:20px;">
                                        <textarea class="formatacao-txt" name="txt-valores" id="txt-valores" required oninput="contadorCaracteres('txt-valores');"><?php echo($valores)?></textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-valores"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($modo == "Salvar"){?>
                            <div class='linha-fle center'>
                                <div class="caixa-first">
                                    <label class="label" for="fl-foto">Foto:</label>
                                    <input type="file" name="fl-foto" id="fl-foto" class="file"/>
                                </div>
                            </div>
                            <?php }else{?>
                            <div class='linha-fle center' style="width:1050px;">
                                <div class="caixa-third">
                                    <label class="label" for="fl-foto">Foto:</label>
                                    <input type="file" name="fl-foto" id="fl-foto" class="file"/>
                                </div>
                                <div class="caixa-third">
                                    <div class='caixa-foto'>
                                        <img class="img" src="../imagem/<?php echo($nomeFoto);?>">
                                    </div>
                                </div>
                            </div>       
                            <?php }?>                        
                        </div>
                        <div class="container-botoes">
                            <div class="caixa-btn">
                                <input type="submit" class="btn btn-salvar center" id="btn-salvar" name="btn-salvar" value="<?php echo($modo);?>">
                            </div>
                            <div class="caixa-btn">
                                <a href="sobre_cms.php">   
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