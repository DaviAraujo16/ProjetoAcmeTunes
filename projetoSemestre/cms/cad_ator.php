<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    require_once("modulo.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Ator";
    $title = "Cadastro Ator - CMS | Acme Tunes";
    $modo = "Salvar";

    $nome= "";
    $idade = "";
    $nacionalidade = "";
    $atividade = "";
    $sexo = "";
    $foto = "";

    //Radio Buttom Masculino
    $rdm = "";
    //Radio Buttom Feminíno
    $rdf = "";

    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $title = "Atualização do Ator - CMS | Acme Tunes";

        $sqlSelect = "SELECT * FROM tbl_ator WHERE cod_ator =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $nome = $rs['nome_ator'];
            $idade = $rs['idade'];
            $nacionalidade = $rs['nacionalidade'];
            $atividade = $rs['atividades'];
            $rs['sexo'] == 'F' ? $rdf = "checked" : $rdm = "checked";
            $nomeFoto = $rs['foto'];

            $pagina = "Atualização do Ator $nome - Ator do Mês";

            $_SESSION['ator'] = $id;
            $_SESSION['nome_foto'] = $nomeFoto;
        }
       
    }

    if(isset($_POST['btn-salvar'])) {
        
        $nome = $_POST['txt-nome'];
        $idade = $_POST['txt-idade'];
        $nacionalidade = $_POST['txt-nacionalidade'];
        $atividade = $_POST['txt-atividade'];
        $sexo = $_POST['rdo-sexo'];
        $fl = $_FILES['fl-foto'];
        
        if(!empty($fl['name'])){
            
            $foto = uparFoto($fl);

            if($_POST['btn-salvar'] == "Salvar"){
            
                $sqlInsert = "INSERT INTO tbl_ator (nome_ator, sexo, idade, nacionalidade, atividades, foto, status) VALUES ('".addslashes($nome)."', '".addslashes($sexo)."', '".addslashes($idade)."', '".addslashes($nacionalidade)."', '".addslashes($atividade)."', '".addslashes($foto)."', 0)";  
                if(mysqli_query($conexao, $sqlInsert)){
                    echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='ator_cms.php';</script>");
                }else{
                    echo("<script>alert('Erro ao salvar o Registro');</script>");
                }   
            }elseif($_POST['btn-salvar'] == "Editar"){    
                $sqlUpdate = "UPDATE tbl_ator SET nome_ator = '".addslashes($nome)."', sexo = '".addslashes($sexo)."', idade = '".addslashes($idade)."', nacionalidade = '".addslashes($nacionalidade)."', foto = '".addslashes($foto)."', atividades = '".addslashes($atividade)."' WHERE cod_ator =".$_SESSION['ator'];
                echo($sqlUpdate);
                if(mysqli_query($conexao, $sqlUpdate)){
                    unlink('../imagem/'.$_SESSION['nomeFoto']);
                    $_SESSION['ator'] = null;
                    $_SESSION['nome_foto'] = null;
                    echo("<script>alert('Registro atualizado com Sucesso!'); window.location.href='ator_cms.php';</script>");
                }else{
                    echo('<script>alert("Erro ao atualizar o Registro");</script>');
                    $modo = "Editar";
                }
            }
        }else{
            $sqlUpdate = "UPDATE tbl_ator SET nome_ator = '".addslashes($nome)."', sexo = '".addslashes($sexo)."', idade = '".addslashes($idade)."', nacionalidade = '".addslashes($nacionalidade)."' WHERE cod_ator =".$_SESSION['ator'];
            if(mysqli_query($conexao, $sqlUpdate)){
                $_SESSION['ator'] = null;
                $_SESSION['nome_foto'] = null;
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='ator_cms.php';</script>");
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_ator.php" method="post" enctype="multipart/form-data">
                        <div id="container-cadastro-ator" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-titulo">Nome*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-titulo" name="txt-nome" class="caixa-texto" required placeholder="Digite aqui o Nome do Ator" pattern="[a-z A-Z `´^~. 0-9]*" value="<?php echo($nome);?>" maxlength="50">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-1">
                                        <label for="rdo_sexo">Sexo*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="radio" class ="radio" name="rdo-sexo" id="rd_m" value="M" <?php echo($rdm)?> >Masculino
                                        <input type="radio" class ="radio" name="rdo-sexo" id="rd_f" value="F" <?php echo($rdf)?> >Feminino 
                                    </div>
                                </div>
                            </div>
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-idade">Idade*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-idade" name="txt-idade" class="caixa-texto" required placeholder="Digite aqui a idade do ator(ex.: 33)" pattern="[0-9]*" value="<?php echo($idade);?>" maxlength="3">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-nacionalidade">Nacionalidade*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2"  style="margin-left:10px;">
                                        <input type="text" id="txt-nacionalidade" name="txt-nacionalidade" class="caixa-texto" required placeholder="Digite aqui a nacionalidade do ator"  pattern="[a-z A-Z `´^~ ,.]*"  value="<?php echo($nacionalidade);?>" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="fl-foto">Foto*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="file" name="fl-foto" id="fl-foto" class="file-2"/>
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="txt-atividade">Atividades*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <input type="text" id="txt-atividade" name="txt-atividade" class="caixa-texto" required placeholder="Digite aqui as atividades do ator"  pattern="[a-z A-Z à-ú À-Ú ,.]*"  value="<?php echo($atividade);?>" maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <?php if($modo != "Salvar"){?>
                            <div class='linha-fle center'>
                                <div class='caixa-foto'>
                                    <img class="img_ator" src="../imagem/<?php echo($nomeFoto);?>">
                                </div>
                            </div>      
                            <?php }?>                   
                        </div>
                        <div class="container-botoes">
                            <div class="caixa-btn">
                                <input type="submit" class="btn btn-salvar center" id="btn-salvar" name="btn-salvar" value="<?php echo($modo);?>">
                            </div>
                            <div class="caixa-btn">
                                <a href="ator_cms.php">   
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