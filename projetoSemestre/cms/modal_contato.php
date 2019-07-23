<?php
    include_once("verificar_usuario.php");
    require_once("conexao.php");
    $conexao = conexaoMysql();

    $codigo = $_GET['codigo'];

    $sqlSelect = "SELECT * FROM tbl_fale_conosco WHERE cod_sugestao=".$codigo;

    $select = mysqli_query($conexao, $sqlSelect);
    if($rs = mysqli_fetch_array($select)){
        $nome = $rs['nome'];
        $telefone = $rs['telefone'];
        $celular = $rs['celular'];
        $email = $rs['email'];
        $homePage = $rs['home_page'];
        $linkFacebook = $rs['link_facebook'];
        $sugestao = $rs['sugestao'];
        $infoProdutos = $rs['info_produtos'];
        $sexo = $rs['sexo'] == 'F' ? "Feminino" : "Masculino";
        $profissao = $rs['profissao'];
    }
    
?>
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
<div>
    <a href="#" id="link_saida">
        <img src="icones/icone-fechar.png">
    </a>
</div>    
<table>
    <tr style="height:40px;">
        <td class="titulo_modal">Nome:</td>
        <td class="texto_modal espaco"><?php echo($nome);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Telefone:</td>
        <td class="texto_modal espaco"><?php echo($telefone);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Celular:</td>
        <td class="texto_modal espaco"><?php echo($celular);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Email:</td>
        <td class="texto_modal espaco"><?php echo($email);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">HomePage:</td>
        <td class="texto_modal espaco"><?php echo($homePage);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Link do Facebook:</td>
        <td class="texto_modal espaco"><?php echo($linkFacebook);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Produtos:</td>
        <td class="texto_modal espaco"><?php echo($infoProdutos);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Sexo:</td>
        <td class="texto_modal espaco"><?php echo($sexo);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Profissão:</td>
        <td class="texto_modal espaco"><?php echo($profissao);?></td>
    </tr>
    <tr style="height:40px;">
        <td class="titulo_modal">Sugestão:</td>
        <td class="texto_modal espaco"><?php echo($sugestao);?></td>
    </tr>
</table>