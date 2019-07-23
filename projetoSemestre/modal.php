<?php
     require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    $codigo = $_GET['codigo'];
    $sqlSelectClick = "SELECT quantidade_clicks FROM tbl_clicks WHERE cod_produto =".$codigo;
    $select2 = mysqli_query($conexao, $sqlSelectClick);
    if($rs = mysqli_fetch_array($select2)){
        $quantidadeClicks = $rs['quantidade_clicks'];
        $quantidadeClicks = $quantidadeClicks + 1;

        $sqlUpdateClick = "UPDATE tbl_clicks SET quantidade_clicks = '$quantidadeClicks' WHERE cod_produto =".$codigo;
        if(mysqli_query($conexao, $sqlUpdateClick)){
            echo"<script>console.log('ok')</script>";
        }else {
            echo"<script>console.log('errou')</script>";
        }

    } 

    $sqlSelect = "SELECT prod.titulo, prod.duracao, prod.diretor, prod.preco, prod.imagem_filme, cat.nome_categoria, sub.nome_sub_categoria, prod.descricao FROM tbl_produto AS prod INNER JOIN tbl_relacao_produto AS rel ON prod.cod_produto = rel.cod_produto INNER JOIN tbl_sub_categoria AS sub ON rel.cod_sub_categoria = sub.cod_sub_categoria INNER JOIN tbl_categoria AS cat ON sub.cod_categoria = cat.cod_categoria WHERE prod.cod_produto =".$codigo;

    $select = mysqli_query($conexao, $sqlSelect);
    if($rs = mysqli_fetch_array($select)){
        $titulo = $rs['titulo'];
        $duracao = $rs['duracao'];
        $diretor = $rs['diretor'];
        $valor = $rs['preco'];
        $imagemFilme = $rs['imagem_filme'];
        $nomeCategoria = $rs['nome_categoria'];
        $nomeSubcategoria = $rs['nome_sub_categoria'];
        $sinopse = $rs['descricao'];

        $preco = 'R$' . number_format($valor, 2, ',', '.');
    }
    
?>
<meta charset="utf-8">
<script>
    $(document).ready(function(){         
        $('#link_saida').click(function(){
            $('#container-modal').fadeOut(800);
        });

        $('#container-modal').click(function(){
            $('#container-modal').fadeOut(500);
        });          
    });
</script>               
<style>
    .container-modal-1{
        width: 690px;
        height: 690px;
    }

    .linha1{
        width: inherit;
        height: 55%;
    }

    .container-foto-modal{
        width: 45%;
        height: 100%;
        float: left;
    }

    .container-conteudos-modal{
        width: 55%;
        height: 100%;
        float: left;
    }

    .linha_modal{
        height: 30px;
     }
          
     .texto_modal{
         font-size: 24px;
         color:#272727;  
     }
     
     .titulo_modal{
         font-family: Yanone;
         font-size: 28px;
         text-align: left;
     }

    .distancia{
        height:60px;
    }

    .distancia_sinopse{
        height:auto;
    }

    .td{
        padding-left: 25px;
    }

    .linha-2{
        width: inherit;
        height: 45%;
    }

    .container-sinopse{
        width:100%;
        height: 100%;
        padding: 20px;
        box-sizing: border-box;
        text-align:justify;
    }

    .imagem-modal{
        width: 95%;
        height: 100%;
        -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.404);
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.404);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 2px;
    }

</style>               
<div class="container-modal-1">
    <div class="linha1">
        <div class="container-foto-modal">
            <img class="imagem-modal" src="imagem/<?php echo($imagemFilme)?>">
        </div>
        <div class="container-conteudos-modal">
            <table>
                <tr class="distancia">
                    <td class="titulo_modal td">Titulo:</td>
                    <td class="texto_modal td"><?php echo($titulo)?></td>
                </tr>
                <tr class="distancia">
                    <td class="titulo_modal td">Duração:</td>
                    <td class="texto_modal td"><?php echo($duracao)?></td>
                </tr>
                <tr class="distancia">
                    <td class="titulo_modal td">Diretor:</td>
                    <td class="texto_modal td"><?php echo($diretor)?></td>
                </tr>
                <tr class="distancia">
                    <td class="titulo_modal td">Categoria:</td>
                    <td class="texto_modal td"><?php echo($nomeCategoria)?></td>
                </tr>
                <tr class="distancia">
                    <td class="titulo_modal td">Subcategoria:</td>
                    <td class="texto_modal td"><?php echo($nomeSubcategoria)?></td>
                </tr>
                <tr class="distancia">
                    <td class="titulo_modal td">Preço:</td>
                    <td class="texto_modal td"><?php echo($preco)?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="linha-2">
        <div class="container-sinopse">
            <table>
                <tr class="distancia">
                    <td class="titulo_modal">Sinopse:</td>
                </tr>
                <tr class="distancia_sinopse">
                    <td class="texto_modal"><?php echo($sinopse)?></td>
                </tr>
            </table>
        </div>        
    </div>
</div>