<?php 
    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $titulo = "Sem Titulo";
    $foto = "Sem foto";
    $diretor = "Sem diretor";
    $lancamento = "00/00/0000";
    $duracao = "00:00";
    $genero = "Sem Gênero";


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
        <title>Filme do Mês | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div id="all">
            <?php include_once("header.php");?>
            <div class="con"></div>
            <div class="container_conteudo center">
                <?php 
                    $sqlFilmeDoMes = "SELECT prod.titulo, prod.diretor, prod.imagem_filme_destaque, prod.dt_lancamento, prod.duracao, sub.nome_sub_categoria FROM tbl_produto AS prod INNER JOIN tbl_relacao_produto AS rel ON prod.cod_produto = rel.cod_produto INNER JOIN tbl_sub_categoria AS sub ON rel.cod_sub_categoria = sub.cod_sub_categoria WHERE prod.status_destaque = 1";
                    $select = mysqli_query($conexao,$sqlFilmeDoMes);

                    if($rs = mysqli_fetch_array($select)){
                        $titulo = $rs['titulo'];
                        $foto = $rs['imagem_filme_destaque'];
                        $diretor = $rs['diretor'];
                        $lancamento = $rs['dt_lancamento'];
                        $duracao = $rs['duracao'];
                        $genero = $rs['nome_sub_categoria'];

                ?>
                <div class="section-conteudo-2">
                    <div class="linha-titulo">
                        <h2 class="formatacao-titulo-atores-filme">Filme do Mês: <?php echo($titulo)?></h2>
                        <hr id="sublinhado1">
                    </div>
                    <div class="linha1">
                        <div class="area-foto-ator">
                            <figure>    
                                <div class="container-foto-ator center">
                                    <img src="imagem/<?php echo($foto)?>" class="img" alt="<?php echo($titulo)?>">
                                </div>
                            </figure>                            
                        </div>
                        <div class="area-info-ator">
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Nome:</span>
                                    <span class="titulo-ator"><?php echo($titulo)?></span>
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                     <span class="titulo-ator">Diretores:</span>
                                    <span class="titulo-ator"><?php echo($diretor)?></span>                                
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                     <span class="titulo-ator">Laçamento:</span>
                                    <span class="titulo-ator"><?php echo($lancamento)?></span>
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Duração:</span>
                                    <span class="titulo-ator"><?php echo($duracao)?></span>
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Gênero:</span>
                                    <span class="titulo-ator"><?php echo($genero)?></span>
                                </div>
                            </div>
                        </div>
                    </div>                           
                </div>
                <?php }?>
            </div>
            <div class="con"></div>
             <?php include_once("footer.php");?>  
        </div>
    </body>
</html>
