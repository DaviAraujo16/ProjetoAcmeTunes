<?php

    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $titulo = "";
    $endereco = "";
    $latitude = "";
    $longitude = "";
    $descricao = "";  

    $lati = "";
    $longi = "";
    $endereco = "";
        
    if(isset($_GET['endereco'])){  
        $endereco = $_GET['endereco'];       
    }

    $sqlSelect = "SELECT nossas.titulo_lojas, loja.rua, loja.numero, loja.cidade, loja.descricao FROM tbl_nossas_lojas AS nossas INNER JOIN tbl_rel_loja AS rel ON nossas.cod_pagina = rel.cod_pagina INNER JOIN tbl_loja AS loja ON rel.cod_loja = loja.cod_loja WHERE nossas.status = 1 ";
    $select = mysqli_query($conexao, $sqlSelect);

    if($rs = mysqli_fetch_array($select)){
        $endereco = $rs['rua'].", nº ".$rs['numero'].", ".$rs['cidade'];  
        $titulo = $rs['titulo_lojas'];
        $descricao = $rs['descricao'];       
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Sobre a Empresa | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div id="all">
            <?php include_once("header.php");?>
            <div class="con" style="margin-bottom: 50px;"></div>
            <div class="container_conteudo center">
                <div class="section-conteudo-3">
                    <div class="conteudo2">
                        <section class="section-lojas">
                            <div class="linha-titulo">
                                <h2 class="formatacao-titulo-atores-filme"><?php echo($titulo);?></h2>
                                <hr id="sublinhado1">
                            </div>
                            <div class="area-lojas">
                                <div class="area-maps">
                                    <div class="container-mapa center">
                                        <iframe id="mapa" src="https://maps.google.com/maps?width=500&amp;height=325&amp;hl=en&amp;q=<?php echo($endereco)?>&amp;ie=UTF8&amp;t=&amp;z=19&amp;iwloc=B&amp;output=embed"></iframe>
                                    </div>
                                </div>
                                    <div class="area-localizacao">
                                        <div class="localizacao">
                                            <a class="localizacao-texto"  href="lojas.php?endereco=<?php echo($endereco);?>"><?php echo($endereco ." || " . $descricao );?></a>
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </div>                
                </div>
            </div>
            <div class="con"></div>
             <?php include_once("footer.php");?>  
        </div>
    </body>
</html>