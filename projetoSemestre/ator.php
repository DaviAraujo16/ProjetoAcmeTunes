<?php 

    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $nome = "Sem nome";
    $idade ="Sem idade";
    $nacionalidade = "Sem nacionalidade";
    $atividade = "Sem atividade";
    $sexo = "Sem";
    $foto = "Sem foto";

    $sqlSelect = "SELECT * FROM tbl_ator WHERE status = 1";
    $select = (mysqli_query($conexao, $sqlSelect));

    if($rs = mysqli_fetch_array($select)){
        $nome = $rs['nome_ator'];
        $idade = $rs['idade'];
        $nacionalidade = $rs['nacionalidade'];
        $atividade = $rs['atividades'];
        $sexo = $rs['sexo'] == 'F' ? "Feminino" : "Masculino";
        $foto = $rs['foto']; 
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Ator em Destaque | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div id="all">
            <?php include_once("header.php");?>
            <div class="con"></div>
            <div class="container_conteudo center" >
                <div class="section-conteudo-2">
                    <div class="linha-titulo">
                        <h2 class="formatacao-titulo-atores-filme">Ator em Destaque: <?php echo($nome)?></h2>
                        <hr id="sublinhado1">
                    </div>
                    <div class="linha1">
                        <div class="area-foto-ator">
                            <figure>    
                                <div class="container-foto-ator center">
                                    <img src="imagem/<?php echo($foto)?>" class='img' alt="Johnny Depp">
                                </div>
                            </figure>                            
                        </div>
                        <div class="area-info-ator">
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Nome:</span>
                                    <span class="titulo-ator"><?php echo($nome)?></span>
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Sexo:</span>
                                    <span class="titulo-ator"><?php echo($sexo)?></span>                                
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Idade:</span>
                                    <span class="titulo-ator"><?php echo($idade)?> anos</span>
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Nacionalidade:</span>
                                    <span class="titulo-ator"<?php echo($nacionalidade)?></span>
                                </div>
                            </div>
                            <div class="linha-info-ator">
                                <div class="info">
                                    <span class="titulo-ator">Atividades:</span>
                                <span class="titulo-ator"><?php echo($atividade)?></span>
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