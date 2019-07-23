<?php 
    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $titulo = "Sem Titulo";
    $subtitulo = "Sem subitulo";
    $texto ="Sem texto";
    $missao = "Sem texto";
    $visao = "Sem texto";
    $valores = "Sem texto";
    $foto = "Sem foto";

    $sqlSelect = "SELECT * FROM tbl_sobre WHERE status = 1";
    $select = mysqli_query($conexao, $sqlSelect);

    if($rs = mysqli_fetch_array($select)){
        $titulo = $rs['titulo_sobre'];
        $subtitulo = $rs['sub_titulo'];
        $texto = $rs['texto'];
        $missao = $rs['texto_missao'];
        $visao = $rs['texto_visao'];
        $valores = $rs['texto_valores'];
        $foto = $rs['imagem_sobre'];
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
                    <div class="conteudo">
                        <section class="section-sobre">
                            <div class="linha-titulo formatacao-titulo-atores-filme">
                                <?php echo($titulo);?>
                                <hr id="sublinhado1">
                            </div>
                            <div class="area-sobre">
                                <div class="area-imagem">
                                    <div class="container-foto-locadora center">
                                        <figure>
                                            <img src="imagem/<?php echo($foto);?>" class="imagem" alt="imagem-locadora">
                                        </figure>   
                                    </div>
                                </div>
                                <div class="area-texto">
                                    <div class="titulo2 center">
                                        <?php echo($subtitulo);?>
                                    </div>
                                    <div id="alinha-texto-sobre" class="center texto">
                                        <?php echo(nl2br($texto))?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="section-valores">
                            <div class="area-valores" id="caixa-missao">
                                <div class="titulo2 center">
                                    <div class="icone-valores">
                                        <figure>
                                            <img src="icones/mission.png" alt="Missão">
                                        </figure>
                                    </div>
                                    <div class="titulo-valores">
                                        <span>Missão</span>
                                    </div>
                                </div>
                                <div class="alinha-texto-valores texto-valores center" style="text-align:justify;">
                                    <?php echo(nl2br($missao))?>
                                </div>
                            </div>
                            <div class="area-valores" id="caixa-visao">
                                <div class="titulo2 center">
                                    <div class="icone-valores">
                                        <figure>
                                            <img src="icones/vision.png" alt="Visão">
                                        </figure>
                                    </div>
                                    <div class="titulo-valores">
                                        <span>Visão</span>
                                    </div>
                                </div>
                                <div class="alinha-texto-valores texto-valores center" style="text-align:justify;">
                                    <?php echo(nl2br($visao));?>
                                </div>
                            </div>
                            <div class="area-valores" id="caixa-valores">
                                <div class="titulo2 center">
                                    <div class="icone-valores">
                                        <figure>
                                            <img src="icones/values.png" alt="Valores">
                                        </figure>
                                    </div>
                                    <div class="titulo-valores">
                                        <span>Valores</span>
                                    </div>
                                </div>
                                <div class="alinha-texto-valores texto-valores center" style="text-align:justify;">
                                    <?php echo(nl2br($visao));?>
                                </div>
                            </div>                           
                        </div>
                    </div>                
                </div>
            </div>
            <div class="con"></div>
             <?php include_once("footer.php");?>  
        </div>
    </body>
</html>