<?php 
    session_start();
    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $modo = "Padrão";
    $subcategoria = "";
    $categoria = "";

    if(isset($_GET['logout'])){
        session_destroy();
    }

    if(isset($_GET['modo']) && $_GET['modo'] == "cat"){
        $categoria = $_GET['categoria'];
        $modo = "Categoria";
    }elseif(isset($_GET['modo']) && $_GET['modo'] == "subcat") {
        $categoria = $_GET['categoria'];
        $subcategoria = $_GET['subcategoria'];
        $modo = "Subcategoria";
    }elseif(isset($_GET['pesquisa'])){
        $pesquisa = $_GET['pesquisa'];
        $modo = "Pesquisa";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao.css">
        <link rel="stylesheet" type="text/css" href="css/style-slider.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/jssor.slider-27.5.0.min.js"></script>
        <script src='js/jssor.slider.min.js'></script>
        <script src='js/menuMobile.js'></script>
        <script>
            $(document).ready(function(){
                $('.detalhes').click(function(){
                    $('#container-modal').fadeIn(800);
                });
            });

            function vizualizarDados(idItem){
                $.ajax({
                    type:"GET",
                    url:"modal.php",
                    data:{codigo:idItem},
                    success: function(dados){
                        $('#modal').html(dados);                        
                    }               
                });            
            }
        </script>   
    </head>
    <body>
        <div id="container-modal">
            <div id="modal" class="center"></div>
        </div>
        <div id="all">
            <?php include_once("header.php");?>
            <div class="con"></div>
            <div id="section-slider" class="center">
                <?php include_once("slider.php");?>
                <?php include_once("redes.php");?>
            </div>
            <div id="section-foto" class="center">
                <img src="slider/slider-avengers.jpg">
            </div>
             <div class="container_conteudo center">
                <div class="section-conteudo">
                    <div id="area-itens">
                        <?php 
                            $sqlSelect = "SELECT cat.cod_categoria, cat.nome_categoria FROM tbl_categoria AS cat WHERE status = 1";
                            $select = mysqli_query($conexao, $sqlSelect);

                            while($rs = mysqli_fetch_array($select)){
                                $codCategoria = $rs['cod_categoria'];
                        ?>
                        <a href="index.php?modo=cat&&categoria=<?php echo($codCategoria)?>">
                            <div class="itens">
                                <?php echo($rs['nome_categoria']);?>
                                <div class="area-sub-itens">
                                    <?php 
                                        $sqlSelect2 = "SELECT sub.cod_sub_categoria, sub.nome_sub_categoria FROM tbl_sub_categoria AS sub WHERE sub.status = 1 AND cod_categoria = ".$codCategoria;
                                        $select2 = mysqli_query($conexao, $sqlSelect2);
    
                                        while($rs2 = mysqli_fetch_array($select2)){
                                            $codSub = $rs2['cod_sub_categoria'];
                                    ?>
                                    <a href="index.php?modo=subcat&&categoria=<?php echo($codCategoria);?>&&subcategoria=<?php echo($codSub);?>">
                                        <div class="sub-itens"><?php echo($rs2['nome_sub_categoria'])?></div>
                                    </a>       
                                    <?php }?>                     
                                </div>
                            </div>
                        </a>
                        <?php }?>
                    </div>
                    <div id="area-conteudo">
                        <div class="contaier-barra-pesquisa center">
                            <form action="index.php" method="get" name="FrmPesquisa" id="FrmPesquisa">
                                <div id="caixa-pesquisa">
                                    <input type="text" class="barra-de-pesquisa" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
                                </div>
                                <div id="caixa-btn-pesquisa">
                                    <input type="submit" class="btn-pesquisar" name="btn-pesquisar" id="btn-pesquisar" value=" ">
                                </div>
                            </form>
                        </div>
                        <?php

                            if($modo == "Padrão"){
                                //Select que pega todos os produtos
                                $sqlSelectProduto = "SELECT prod.cod_produto, prod.titulo, prod.descricao, prod.imagem_filme, prod.preco FROM tbl_produto AS prod WHERE status = 1 AND status_promocao = 0 ORDER BY RAND()";

                            }elseif($modo == "Categoria") {
                                //Select que pega os produtos baseado na Categoria
                                $sqlSelectProduto = "SELECT prod.cod_produto, prod.titulo, prod.descricao, prod.imagem_filme, prod.preco FROM tbl_produto AS prod INNER JOIN tbl_relacao_produto AS rel ON prod.cod_produto = rel.cod_produto AND rel.cod_categoria = '$categoria' WHERE prod.status = 1 AND prod.status_promocao = 0 AND rel.status = 1";

                            }elseif($modo == "Subcategoria"){
                                //Select que pega os produtos baseado na Categoria e na Subcategoria
                                $sqlSelectProduto = "SELECT prod.cod_produto, prod.titulo, prod.descricao, prod.imagem_filme, prod.preco FROM tbl_produto AS prod INNER JOIN tbl_relacao_produto AS rel ON prod.cod_produto = rel.cod_produto AND rel.cod_categoria = '$categoria' AND rel.cod_sub_categoria = '$subcategoria' WHERE prod.status = 1 AND prod.status_promocao = 0 AND rel.status = 1";

                            }elseif($modo == "Pesquisa"){
                                //Select que pega os produtos baseado na busca
                                $sqlSelectProduto = "SELECT prod.cod_produto, prod.titulo, prod.descricao, prod.imagem_filme, prod.preco FROM tbl_produto AS prod WHERE status = 1 AND prod.status_promocao = 0 AND titulo LIKE '%$pesquisa%' ";

                            }
                            
                            $selectProduto = mysqli_query($conexao, $sqlSelectProduto);
                            while($rsProduto = mysqli_fetch_array($selectProduto)){
                                $codFilme = $rsProduto['cod_produto'];
                                $titulo = $rsProduto['titulo'];
                                $descricao = $rsProduto['descricao'];
                                $imagem = $rsProduto['imagem_filme'];
                                $preco = 'R$' . number_format($rsProduto['preco'], 2, ',', '.');
                        ?>
                        <div class="filme" style="text-overflow: ellipsis; -ms-text-overflow: ellipsis; -o-text-overflow: ellipsis;">
                            <div class="foto-filme">
                                <figure>
                                    <div class="container-foto center">
                                        <img src="imagem/<?php echo($imagem)?>" alt="Aquaman">
                                    </div>    
                                </figure>
                            </div>
                            <div class="info-filme">
                                <div class="linha-info">
                                    <div class="nome">
                                        <span class="titulo">Nome:</span>
                                    </div>
                                    <div class="nome-filme">
                                        <span><?php echo($titulo)?></span>
                                    </div>
                                </div>
                                <div class="linha-info">
                                    <div class="descricao">
                                        <span class="titulo">Descrição:</span>
                                    </div>
                                    <div class="descricao-filme"><?php echo($descricao)?></div>
                                </div>
                                <div class="linha-info">
                                    <div class="preco">
                                        <span class="titulo">Preço:</span>
                                    </div>
                                    <div class="preco-filme">
                                        <span class="preco-atual"><?php echo($preco)?></span>
                                    </div>
                                </div>    
                                <div class="linha-info">
                                    <a href="#" onclick="vizualizarDados(<?php echo($codFilme)?>)">
                                        <span class="detalhes">Detalhes</span>
                                    </a>
                                </div>
                            </div> 
                        </div>
                        <?php }?>
                    </div>  
                </div>
            </div>
            <div class="con"></div>
             <?php include_once("footer.php");?>  
        </div>
    </body>
</html>