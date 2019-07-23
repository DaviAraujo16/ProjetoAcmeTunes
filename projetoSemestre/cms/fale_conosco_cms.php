<?php
    require_once("verificar_usuario.php");
    require_once("conexao.php");

    $conexao = conexaoMysql();

    if(isset($_GET['modo'])){
        $id = $_GET['id'];
        $nome = $_GET['nome'];
        $sqlDelete = "DELETE FROM tbl_fale_conosco WHERE cod_sugestao=".$id;

        if(mysqli_query($conexao, $sqlDelete)){
            header("location:fale_conosco_cms.php");
            echo("<script>alert('A sugestão de '".$nome."' foi apagada com sucesso!')</script>");
        }else{
            echo("<script>alert('Houve um erro durante a exclusão!')</script>"); 
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Fale Conosco - CMS | Acme Tunes</title>
        <link rel="stylesheet" type="text/css" href="css/style-padrao-cms.css"/>
        <link rel="stylesheet" type="text/css" href="css/style_cms.css"/>
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function(){
                $('.visualizar').click(function(){
                    $('#container-modal').fadeIn(800);
                });
            });

            function vizualizarDados(idItem){
                //Script feito em AJAX  para enviar o ID pelo método GET
                $.ajax({
                    //type - methodo de envio dos dados (GET e POST);
                    //url - página que irá chamar;
                    //data - cria uma parametro(invisível) na url;
                    //success -  recebe as informações(type,url,data);
                    type:"GET",
                    url:"modal_contato.php",
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
        <!--Div que alinha todo o conteúdo do CMS no meio da pagina-->
        <div id="tudo" class="center">
            <!--CMS-->
            <div id="cms">
                <?php include_once("header_cms.php");?>
                <?php include_once("menu_cms.php");?> 
                <!-- Area do Conteúdo CMS Fale conosco -->
                <section id="conteudo">
                    <div id="linha-titulo-fale-conosco" class="center">
                        <div id="titulo-fale-conosco"> Administração Fale Conosco</div>
                    </div>
                    <div id="linha-tabela" class="center">
                        <table id="tabela">
                            <tr>
                                <th class="th-titulo">Nome</th>
                                <th class="th-titulo">Email</th>
                                <th class="th-titulo">Profissão</th>
                                <th class="th-icones">Vizualizar</th>
                                <th class="th-icones">Apagar</th>
                            </tr>
                            <?php 
                                //Aqui é carregado todas as sugestões na tabela de sugestão
                                $sqlSelect = "SELECT * FROM tbl_fale_conosco";
                                $select = mysqli_query($conexao, $sqlSelect);

                                while($rs = mysqli_fetch_array($select)){
                            ?>
                            <tr class='tr-itens'>
                                <td class="td-itens"><?php echo($rs['nome']);?></td>
                                <td class="td-itens"><?php echo($rs['email']);?></td>
                                <td class="td-itens"><?php echo($rs['profissao']);?></td>
                                <td class="td-itens">
                                    <a>
                                        <figure>
                                            <img src="icones/icone-vizualizar.png"  class="visualizar" onclick="vizualizarDados(<?php echo($rs['cod_sugestao']);?>)"/>
                                        </figure>   
                                    </a>
                                </td>
                                <td class="td-itens">
                                    <a href="fale_conosco_cms.php?id=<?php echo($rs['cod_sugestao']);?>&&modo=excluir&&nome=<?php  echo($rs['nome']);?>" onclick="return confirm('Deseja excluir a sugestão de <?php echo($rs['nome']);?>?')">
                                        <figure>
                                            <img src="icones/icone-excluir.png"/>
                                        </figure>   
                                    </a>                                      
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>                    
                </section>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>   
    </body>
</html>