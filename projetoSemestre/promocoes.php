<?php 
    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $modo = "Padrão";

    if(isset($_GET['modo']) && $_GET['modo'] == "cat"){
        $categoria = $_GET['categoria'];
        $modo = "Categoria";
    }elseif(isset($_GET['modo']) && $_GET['modo'] == "subcat") {
        $categoria = $_GET['categoria'];
        $subcategoria = $_GET['subcategoria'];
        $modo = "Subcategoria";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Promoções | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao.css">
        <link rel="stylesheet" type="text/css" href="css/style-slider.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/style-slider.css">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/jssor.slider-27.5.0.min.js"></script>
        <script src='js/jssor.slider.min.js'></script>
    </head>
    <body>
        <div id="all">
            <?php include_once("header.php");?>
            <div class="con"></div>
            <div id="section-slider" class="center">
                <?php include_once("slider.php");?>
                <?php include_once("redes.php");?>
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
                        <a href="promocoes.php?modo=cat&&categoria=<?php echo($codCategoria)?>">
                            <div class="itens">
                                <?php echo($rs['nome_categoria']);?>
                                <div class="area-sub-itens">
                                    <?php 
                                        $sqlSelect2 = "SELECT sub.cod_sub_categoria, sub.nome_sub_categoria FROM tbl_sub_categoria AS sub WHERE sub.status = 1 AND cod_categoria = ".$codCategoria;
                                        $select2 = mysqli_query($conexao, $sqlSelect2);
    
                                        while($rs2 = mysqli_fetch_array($select2)){
                                            $codSub = $rs2['cod_sub_categoria'];
                                    ?>
                                    <a href="promocoes.php?modo=subcat&&categoria=<?php echo($codCategoria);?>&&subcategoria=<?php echo($codSub);?>">
                                        <div class="sub-itens"><?php echo($rs2['nome_sub_categoria'])?></div>
                                    </a>       
                                    <?php }?>                     
                                </div>
                            </div>
                        </a>
                        <?php }?>
                    </div>    
                    <section id="area-conteudo">
                        <div id="area-titulo">
                            <h1 id="titulo-promocoes">Promoções</h1>
                        </div>
                        <?php 
                             if($modo == "Padrão"){
                                //Select que pega todos os produtos
                               $sqlSelect = "SELECT promo.valor_promocao ,promo.valor_promocional, prod.imagem_filme, prod.titulo , prod.descricao, prod.preco FROM tbl_promocao AS promo INNER JOIN tbl_produto AS prod ON promo.cod_produto = prod.cod_produto WHERE promo.status = 1 ORDER BY RAND()";

                            }elseif($modo == "Categoria") {
                                //Select que pega os produtos baseado na Categoria
                                $sqlSelect = "SELECT promo.valor_promocao ,promo.valor_promocional, prod.cod_produto, prod.titulo, prod.descricao, prod.imagem_filme, prod.preco FROM tbl_promocao AS promo INNER JOIN tbl_produto AS prod ON promo.cod_produto = prod.cod_produto INNER JOIN tbl_relacao_produto AS rel ON prod.cod_produto = rel.cod_produto AND rel.cod_categoria = '$categoria' WHERE prod.status = 1 AND prod.status_promocao = 1 AND rel.status = 1 ";

                            }elseif($modo == "Subcategoria"){
                                //Select que pega os produtos baseado na Categoria e na Subcategoria
                                $sqlSelect = "SELECT promo.valor_promocao , promo.valor_promocional, prod.cod_produto, prod.titulo, prod.descricao, prod.imagem_filme, prod.preco FROM tbl_promocao AS promo INNER JOIN tbl_produto AS prod ON promo.cod_produto = prod.cod_produto INNER JOIN tbl_relacao_produto AS rel ON prod.cod_produto = rel.cod_produto AND rel.cod_categoria = '$categoria' AND rel.cod_sub_categoria = '$subcategoria' WHERE prod.status = 1 AND prod.status_promocao = 1 AND rel.status = 1";

                            }
                        
                            $select = mysqli_query($conexao, $sqlSelect);

                            while($rs = mysqli_fetch_array($select)){
                               $precoAntigo = 'R$' . number_format($rs['preco'], 2, ',', '.');
                               $precoNovo = 'R$' . number_format($rs['valor_promocional'], 2, ',', '.');
                               $porcentagem = $rs['valor_promocao'] . '%';
                        ?>
                        <div class="filme">
                            <div class="foto-filme">
                                <figure>
                                    <div class="container-foto center">
                                        <img src="imagem/<?php echo($rs['imagem_filme'])?>" alt="<?php echo($rs['titulo'])?>">
                                    </div>    
                                </figure>
                            </div>
                            <div class="info-filme">
                                <div class="linha-info">
                                    <div class="nome">
                                        <span class="titulo">Nome:</span>
                                    </div>
                                    <div class="nome-filme"><?php echo($rs['titulo'])?></div>
                                </div>
                                <div class="linha-info">
                                    <div class="nome">
                                        <span class="titulo">Desconto:</span>
                                    </div>
                                    <div class="nome-filme">
                                        <?php echo($porcentagem)?>                
                                    </div>                                    
                                </div>
                                <div class="linha-info">
                                    <div class="preco">
                                        <span class="titulo">Preço:</span>
                                    </div>
                                    <div class="preco-filme">
                                        De: <span class="preco-antigo"><?php echo($precoAntigo)?></span><br>
                                        Por: <span class="preco-atual"><?php echo($precoNovo)?></span>
                                    </div>                                    
                                </div>
                            </div> 
                        </div>
                        <?php }?>         
                    </section>    
                </div>
            </div>
            <div class="con"></div>
             <?php include_once("footer.php");?>  
        </div>
    </body>
</html>