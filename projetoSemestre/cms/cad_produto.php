<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");
    require_once("modulo.php");

    $conexao = conexaoMysql();

    $pagina = "Cadastro de Produto";
    $title = "Cadastro Produto - CMS | Acme Tunes";
    $modo = "Salvar";

    $titulo = "";
    $descricao = "";
    $diretor = "";
    $lancamento = "";
    $duracao = "";
    $preco = "";
    $precoAjustado = "";
    $foto = "";
    $fotoDestaque = "";
    
    if(isset($_GET['modo'])){
        $modo = "Editar";
        $id = $_GET['id'];

        $pagina = "Atualização do Produto ".$id." - Produto";
        $title = "Atualização Produto - CMS | Acme Tunes";

        $sqlSelect = "SELECT * FROM tbl_produto WHERE cod_produto =".$id;
        $select = mysqli_query($conexao, $sqlSelect);

        if($rs = mysqli_fetch_array($select)){
            $titulo = $rs['titulo'];
            $descricao = $rs['descricao'];
            $diretor = $rs['diretor'];
            $lancamento = $rs['dt_lancamento'];
            $duracao = $rs['duracao'];
            $preco = $rs['preco'];
            $precoAjustado =  str_replace('.',',',$preco);
            $foto = $rs['imagem_filme'];
            $fotoDestaque = $rs['imagem_filme_destaque'];

            $_SESSION['prod'] = $id;
            $_SESSION['nome_foto'] = $foto;
            $_SESSION['foto_destaque'] = $fotoDestaque;
        }      
    }

    if(isset($_POST['btn-salvar'])) {
        
        $titulo = $_POST['txt-titulo'];
        $descricao = $_POST['txt-descricao-produto'];
        $diretor = $_POST['txt-diretor'];
        $lancamento = $_POST['txt-lancamento'];
        $duracao = $_POST['txt-duracao'];
        $preco = $_POST['txt-preco'];
        $precoAjustado =  str_replace(',','.',$preco);
        $foto = $_FILES['fl-foto'];
        $fotoDestaque = $_FILES['fl-foto-destaque'];

         if(!empty($foto['name']) && !empty($fotoDestaque['name'])){
            $fotoUpada = uparFoto($foto);
            $fotoUpadaDestaque = uparFoto($fotoDestaque);

            if($_POST['btn-salvar'] == "Salvar"){

                $sqlInsert = "INSERT INTO tbl_produto (titulo, descricao, duracao, preco, dt_lancamento, diretor, status, imagem_filme, status_promocao, status_destaque, imagem_filme_destaque) VALUES ('".addslashes($titulo)."', '".addslashes($descricao)."', '".addslashes($duracao)."', '".addslashes($precoAjustado)."', '".addslashes($lancamento)."', '".addslashes($diretor)."', 1, '".$fotoUpada."', 0, 0, '".$fotoUpadaDestaque."')";
                if(mysqli_query($conexao, $sqlInsert)){
                    $sqlInsert2 = "INSERT INTO tbl_clicks (quantidade_clicks, cod_produto) VALUES (0, (SELECT MAX(cod_produto) FROM tbl_produto))";
                    if(mysqli_query($conexao, $sqlInsert2)){
                        echo("<script>alert('Registro salvo com Sucesso!'); window.location.href='produto_cms.php';</script>");
                    }    
                }else{
                    echo("<script>alert('Erro ao salvar o Registro');</script>");
                }   
             }elseif($_POST['btn-salvar'] == "Editar"){
                $id = $_SESSION['prod'];
                $nomeFoto = $_SESSION['nome_foto'];
                $nomeFotoDestaque = $_SESSION['foto_destaque'];               

                $sqlUpdate = "UPDATE tbl_produto SET titulo = '".addslashes($titulo)."', descricao = '".addslashes($descricao)."', duracao = '".addslashes($duracao)."', preco = '".addslashes($precoAjustado)."', dt_lancamento = '".addslashes($lancamento)."', diretor = '".addslashes($diretor)."', imagem_filme = '".$fotoUpada."' , imagem_filme_destaque = '".$fotoUpadaDestaque."' WHERE cod_produto =".$id;
                echo($sqlUpdate);
                if(mysqli_query($conexao, $sqlUpdate)){
                    unlink('../imagem/'.$nomeFoto);
                    unlink('../imagem/'.$nomeFotoDestaque);
                    $_SESSION['prod'] = null;
                    $_SESSION['nome_foto'] = null;
                    $_SESSION['foto_destaque'] = null;
                    echo('<script>alert("Registro atualizado com Sucesso!!!"); window.location.href="produto_cms.php";</script>');
                }else{
                    echo("<script>alert('Erro ao atualizar o Registro');</script>");
                    $modo = "Editar";
                }
             }
         }elseif(!empty($foto['name'])){
            $id = $_SESSION['prod'];
            $nomeFotoAntiga = $_SESSION['nome_foto'];
            $fotoUpada = uparFoto($foto);

            $sqlUpdate = "UPDATE tbl_produto SET titulo = '".addslashes($titulo)."', descricao = '".addslashes($descricao)."', duracao = '".addslashes($duracao)."', preco = '".addslashes($precoAjustado)."', dt_lancamento = '".addslashes($lancamento)."', diretor = '".addslashes($diretor)."', imagem_filme = '".$fotoUpada."' WHERE cod_produto =".$id;
             
            if(mysqli_query($conexao, $sqlUpdate)){
                unlink('../imagem/'.$nomeFotoAntiga);
                $_SESSION['prod'] = null;
                $_SESSION['nome_foto'] = null;
                echo('<script>alert("Registro atualizado com Sucesso!!!"); window.location.href="produto_cms.php";</script>');
            }else{
                echo("<script>alert('Erro ao atualizar o Registro');</script>");
                $modo = "Editar";
            }

         }elseif(!empty($fotoDestaque['name'])){ 
            $id = $_SESSION['prod'];
            $nomeFotoDestaqueAntiga = $_SESSION['foto_destaque'];
            $fotoUpadaDestaque = uparFoto($fotoDestaque);

            $sqlUpdate = "UPDATE tbl_produto SET titulo = '".addslashes($titulo)."', descricao = '".addslashes($descricao)."', duracao = '".addslashes($duracao)."', preco = '".addslashes($precoAjustado)."', dt_lancamento = '".addslashes($lancamento)."', diretor = '".addslashes($diretor)."', imagem_filme_destaque = '".$fotoUpadaDestaque."' WHERE cod_produto =".$id;
            
            if(mysqli_query($conexao, $sqlUpdate)){
                unlink('../imagem/'.$nomeFotoDestaqueAntiga);
                $_SESSION['prod'] = null;
                $_SESSION['foto_destaque'] = null;
                echo('<script>alert("Registro atualizado com Sucesso!!!"); window.location.href="produto_cms.php";</script>');
            }else{
                echo("<script>alert('Erro ao atualizar o Registro');</script>");
                $modo = "Editar";
            }

         }else{
            $id = $_SESSION['prod'];
            $sqlUpdate = "UPDATE tbl_produto SET titulo = '".addslashes($titulo)."', descricao = '".addslashes($descricao)."', duracao = '".addslashes($duracao)."', preco = '".addslashes($precoAjustado)."', dt_lancamento = '".addslashes($lancamento)."', diretor = '".addslashes($diretor)."' WHERE cod_produto =".$id;
            if(mysqli_query($conexao, $sqlUpdate)){
                $_SESSION['prod'] = null;
                echo("<script>alert('Registro atualizado com Sucesso!'); window.location.href='produto_cms.php';</script>");
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
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mask.min.js"></script>
        <script src="js/contadorChar.js"></script>
        <script src="js/mascaras.js"></script>
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
                    <form id="frmCadastro" name="frmCadastro" action="cad_produto.php" method="post" enctype="multipart/form-data">
                        <div id="container-cadastro" class="center">
                            <div class='linha_grande'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-titulo">Título*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-titulo" name="txt-titulo" class="caixa-texto" required placeholder="Digite aqui o titulo do filme" value="<?php echo($titulo);?>" maxlength="50">
                                    </div>
                                </div>
                                <div class="caixa-textarea-cms ">
                                    <div class="area-label-1">
                                        <label for="txt-descricao-produto">Descrição*:</label>
                                    </div>
                                    <div class="ajusta-textarea-cms" style="padding-left:20px;">
                                        <textarea class="formatacao-txt-descricao" name="txt-descricao-produto" id="txt-descricao-produto" required  oninput="contadorCaracteres('txt-descricao-produto');"><?php echo($descricao)?></textarea><br>
                                        <div id="contador-char">
                                            <span class="caracteres" id="cont-produto"></span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class='linha-form-1'>
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-diretor">Diretor*:</label>
                                    </div>
                                    <div class="area-caixa-texto-1">
                                        <input type="text" id="txt-diretor" name="txt-diretor" class="caixa-texto" required placeholder="Digite aqui o nome do diretor do filme" value="<?php echo($diretor);?>" maxlength="50">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-categoria">
                                        <label for="txt-dt-lancamento">Lançamento*:</label>
                                    </div>
                                    <div class="area-caixa-texto-sub-categoria">
                                        <input type="text" name="txt-lancamento" id="txt-lancamento" style="margin-left:34px;" class="caixa-texto-media-lancamento" required value="<?php echo($lancamento);?>" maxlength="60">
                                    </div>
                                </div>                                
                            </div> 
                            <div class="linha-form-1">
                                <div class="caixa-first">
                                    <div class="area-label-1">
                                        <label for="txt-texto">Duração*:</label>
                                    </div>
                                    <div class="ajusta-textarea-1" >
                                        <input type="text" id="txt-duracao" name="txt-duracao" class="caixa-texto" required placeholder="Digite aqui a duração do filme" value="<?php echo($duracao);?>" maxlength="50">
                                    </div>
                                </div>
                                <div class="caixa-second">
                                    <div class="area-label-preco">
                                        <label for="txt-texto">Preço em R$:</label>
                                    </div>
                                    <div class="ajusta-textarea-1" >
                                        <input type="text" id="txt-preco" name="txt-preco" class="caixa-texto-media-preco" onkeyup="formatarMoeda(this);" required placeholder="Digite aqui o preço do filme" value="<?php echo($precoAjustado);?>" maxlength="50">
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
                            <div class='linha-fle center'>
                                <div class="caixa-first">
                                    <label style="font-size: 25px;" for="fl-foto-destaque">Destaque:</label>
                                    <input type="file" name="fl-foto-destaque" id="fl-foto-destaque" class="file"/>
                                </div>
                            </div>
                            <?php }else{?>
                            <div class='linha-fle center' style="width:1050px;">
                                <div class="caixa-third">
                                    <label class="label" for="fl-foto">Foto:</label>
                                    <input type="file" name="fl-foto" id="fl-foto" class="file"/>
                                </div>
                                <div class="caixa-third">
                                    <div class='caixa-foto-filme'>
                                        <img class="img" src="../imagem/<?php echo($_SESSION['nome_foto'])?>">
                                    </div>
                                </div>
                            </div>
                            <div class='linha-fle center' style="width:1050px;">
                                <div class="caixa-third">
                                    <label style="font-size: 25px;" for="fl-foto-destaque">Destaque:</label>
                                    <input type="file" name="fl-foto-destaque" id="fl-foto-destaque" class="file"/>
                                </div>
                                <div class="caixa-third">
                                    <div class='caixa-foto-destaque'>
                                        <img class="img" src="../imagem/<?php echo($_SESSION['foto_destaque'])?>">
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
                                <a href="produto_cms.php">   
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