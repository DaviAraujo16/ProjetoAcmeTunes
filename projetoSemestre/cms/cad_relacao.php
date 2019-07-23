<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    $conexao = conexaoMysql();

    $modo = "Salvar";
    $title = "Cadastrar Relação - CMS | Acme Tunes";

    $subCategoria = "";
    $categoria = "";
    $produto = "";

    if(isset($_GET['modo'])){
        $modo = "Editar";
        $codRel = $_GET['id'];
        $title = "Atualização Relação - CMS | Acme Tunes";

        $_SESSION['codRel'] = $codRel;

        $sqlSelect = "SELECT * FROM tbl_relacao_produto WHERE cod_relacao_produto =".$codRel;
        $select = mysqli_query($conexao, $sqlSelect);


        if($rs = mysqli_fetch_array($select)){
            $produto = $rs['cod_produto'];
            $categoria = $rs['cod_categoria'];
            $subCategoria = $rs['cod_sub_categoria'];
            $pagina = "Atualização Relação - Relação";
        }       
    }


    if(isset($_POST['btn-salvar'])){
        $produto = $_POST['combo-filmes'];
        $categoria = $_POST['combo-categoria'];
        $subCategoria = $_POST['combo-sub-categoria'];

        if($_POST['btn-salvar'] == "Salvar"){          
            $sqlInsert = "INSERT INTO tbl_relacao_produto (cod_sub_categoria, cod_categoria, cod_produto, status) VALUES ('$subCategoria', '$categoria', '$produto', 1)";
            if(mysqli_query($conexao, $sqlInsert)){
               echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='relacao_cms.php';</script>");
            }else{
                echo("<script>alert('Erro ao salvar o Registro');</script>");
            }
        }elseif($_POST['btn-salvar'] == "Editar"){
            $id = $_SESSION['codRel'];
            $sqlUpdate = "UPDATE tbl_relacao_produto SET cod_sub_categoria = '$subCategoria', cod_categoria = '$categoria', cod_produto = '$produto' WHERE cod_relacao_produto =".$id;
            if(mysqli_query($conexao, $sqlUpdate)){
                echo("<script>alert('Registro editado com Sucesso!'); window.location.href='relacao_cms.php';</script>");
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
        <script>
            $(document).ready(function(){
                $("#combo-categoria").change(function(){
                    $("#combo-categoria option:selected").each(function(){
                        var idCombo = $(this).val();
                        enviarCategoria(idCombo);

                        function enviarCategoria(idCategoria){
                            $.ajax({
                                type:'GET',
                                url:'trazSubcategoria.php',
                                data:{categoria:idCategoria},
                                complete: function (dados){
                                    $('#sub').html(dados.responseText);
                                }
                            });    
                        }
                    });
                });
            });            
        </script>
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
                        <div id="titulo">Relação Produto, Categoria e Subcategoria</div>
                    </div>
                    <form id="frmCadastro" name="frmCadastro" action="cad_relacao.php" method="post">
                        <div id="container-cadastro-2" class="center">
                            <div class='linha-form-1 center'>
                                <div class="caixa-first">
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
                                                    $selected =  $rs['cod_produto'] == $produto ? "selected" : "";     
                                                    $codProduto = $rs['cod_produto'];
                                            ?>
                                            <option value="<?php echo($codProduto)?>"  <?php echo($selected)?> name="filmes">
                                                <?php echo($rs['cod_produto']." - ".$rs['titulo'])?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-2">
                                        <label for="combo-filmes">Categoria*:</label>
                                    </div>
                                    <div class="area-caixa-texto-2">
                                        <select name="combo-categoria" id="combo-categoria">
                                            <option value="0" name="categoria">Selecione alguma Categoria!</option>
                                            <?php 
                                                $sqlComboSelect = "SELECT * FROM tbl_categoria WHERE status = 1";
                                                $comboSelect = mysqli_query($conexao, $sqlComboSelect);

                                                while($rs = mysqli_fetch_array($comboSelect)){
                                                    $selected =  $rs['cod_categoria'] == $categoria ? "selected" : "";     
                                                    $codCategoria = $rs['cod_categoria'];
                                            ?>
                                            <option value="<?php echo($codCategoria)?>" <?php echo($selected)?> name="categoria" class="categoria"> 
                                                <?php echo($rs['cod_categoria']." - ".$rs['nome_categoria'])?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                            <div class="linha_grande_2" style="margin-top:50px;">
                                <div class="area-label-2" style="margin-right: 40px">
                                    <label for="combo-filmes">Subcategoria*:</label>
                                </div>
                                <div class="area-caixa-texto-2">
                                    <select name="combo-sub-categoria" id="sub">
                                        <option value="0" name="sub-categoria">Selecione alguma Subcategoria!</option>
                                    </select>
                                </div>
                            </div>                         
                        </div>
                        <div class="container-botoes">
                            <div class="caixa-btn">
                                <input type="submit" class="btn btn-salvar center" id="btn-salvar" name="btn-salvar" value="<?php echo($modo);?>">
                            </div>
                            <div class="caixa-btn">
                                <a href="relacao_cms.php">   
                                    <input type="button" class="btn btn-cancelar center" id="btn-cancelar" value="Cancelar">
                                </a>
                            </div>
                        </div>
                    </form>     
                </section>
                <?php include_once("footer_cms.php")?>       
            </div>
        </div>   
    </body>
</html>