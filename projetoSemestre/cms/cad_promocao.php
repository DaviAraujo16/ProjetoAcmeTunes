<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Promoção";
    $title = "Cadastro de Promoção - CMS | Acme Tunes";
    $modo = "Salvar";
    $selecionado = "required";


    $valor = "";
    $filme = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];
        $titulo = $_GET['titulo'];
        $pagina = "Atualização do Promoção $titulo - Promoção";
        $title = "Atualização Promoção - CMS | Acme Tunes";

        $_SESSION['id'] = $id;
        $sqlSelect = "SELECT * FROM tbl_promocao WHERE cod_promocao =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $valor = $rs['valor_promocao'];
            $filme = $rs['cod_filme'];
        }       
    }

    if(isset($_POST['btn-salvar'])) {
        $valor = $_POST['txt-valor'];
        $atributos = explode("/" , $_POST['combo-filmes']);
        $filme = $atributos[0];
        $precoFilme = $atributos[1];
       
        $desconto = ($valor * $precoFilme) / 100;
        $precoFinal = $precoFilme - $desconto;

        if($filme  != 0){
            if($_POST['btn-salvar'] == "Salvar"){
                
                $sqlInsert = "INSERT INTO tbl_promocao (valor_promocao, status, cod_produto, valor_promocional) VALUES ('".addslashes($valor)."', 1,'$filme', '$precoFinal')";
                if(mysqli_query($conexao, $sqlInsert)){
                    $sqlUpdateStatusPromocao = "UPDATE tbl_produto SET status_promocao = 1 WHERE cod_produto =".$filme;
                    if(mysqli_query($conexao, $sqlUpdateStatusPromocao)){
                        echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='promocao_cms.php';</script>");
                    }
                }else{
                    echo("<script>alert('Erro ao salvar o Registro');</script>");
                }   

            }elseif($_POST['btn-salvar'] == "Editar"){
                $status = $_SESSION['status'];
                $id = $_SESSION['id'];
        
                $sqlUpdate = "UPDATE tbl_promocao SET valor_promocao = '".addslashes($valor)."', cod_produto = '$filme', valor_promocional = '$precoFinal' WHERE cod_promocao =".$id;
        
                if(mysqli_query($conexao, $sqlUpdate)){
                    echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='promocao_cms.php';</script>");
                }else{
                    echo('<script>alert("Erro ao atualizar o Registro");</script>');
                    $modo = "Editar";
                }
            } 
        }else{
            $status = $_SESSION['status'];
            $id = $_SESSION['id'];
        
            $sqlUpdate = "UPDATE tbl_promocao SET valor_promocao = '".addslashes($valor)."', valor_promocional = '$precoFinal' WHERE cod_promocao =".$id;
        
            if(mysqli_query($conexao, $sqlUpdate)){
                echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='promocao_cms.php';</script>");
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_promocao.php" method="post">
                        <div id="container-cadastro-3" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-valor">Valor*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" name="txt-valor" id="txt-valor" style="margin-left:34px;" name="txt-latitude" class="caixa-texto" required placeholder="Digite aqui o valor da promoção" value="<?php echo($valor);?>" maxlength="2">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="combo-filmes">Produto*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <select name="combo-filmes">
                                            <option value="0" name="filmes">Selecione algum Filme!</option>
                                            <?php 
                                                $sqlComboSelect = "SELECT * FROM tbl_produto WHERE status = 1";
                                                $comboSelect = mysqli_query($conexao, $sqlComboSelect);

                                                while($rs = mysqli_fetch_array($comboSelect)){
                                                    $selected =  $rs['cod_produto'] == $filme ? "selected" : "";     
                                                    $valores = $rs['cod_produto']."/".$rs['preco'];
                                            ?>
                                            <option value="<?php echo($valores)?>"  <?php echo($selected)?> name="filmes">
                                                <?php echo($rs['cod_produto']." - ".$rs['titulo'])?>
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
                                <a href="promocao_cms.php">   
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