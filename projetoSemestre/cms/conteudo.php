<?php 
    require_once("verificar_usuario.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>CMS | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao-cms.css">
        <link rel="stylesheet" type="text/css" href="css/style_cms.css">
        <script src="js/jquery.js"></script>
    </head>
    <body>
        <!--Div que alinha todo o conteúdo do CMS no meio da pagina-->
        <div id="tudo" class="center">
            <!--CMS-->
            <div id="cms">
                <?php include_once("header_cms.php");?>
                <?php include_once("menu_cms.php");?> 
                <!-- Area do Conteúdo CMS -->
                <div id="conteudo">
                    <div id="area-paginas">
                        <div class="coluna-paginas">
                            <div class="pagina">
                                <div class="container-icone-pagina">
                                    <figure>
                                        <a href="promocao_cms.php">
                                            <img src="icones/icone-promocoes.png"/>
                                        </a>
                                    </figure>
                                </div>
                                <div class="container-nome-pagina">
                                    <div class="nome-pagina">
                                        Promoções
                                    </div>
                                </div>
                            </div>
                            <div class="pagina">
                                <div class="container-icone-pagina">
                                    <figure>
                                        <a href='sobre_cms.php'>
                                            <img src="icones/icone-sobre-a-locadora.png">
                                        </a>
                                    </figure>
                                </div>
                                <div class="container-nome-pagina">
                                    <div class="nome-pagina-grande">
                                        Sobre a locadora
                                    </div>
                                </div>
                            </div>
                            <div class="pagina">
                                <div class="container-icone-pagina">
                                    <figure>
                                        <a href="loja_cms.php">
                                            <img src="icones/icone-loja.png">
                                        </a>
                                    </figure>
                                </div>
                                <div class="container-nome-pagina">
                                    <div class="nome-pagina">
                                       Lojas
                                    </div>
                                </div>
                            </div>
                            <div class="pagina">
                                <div class="container-icone-pagina">
                                    <figure>
                                        <a href="nossas_lojas_cms.php">
                                            <img src="icones/icone-nossas-lojas.png">
                                        </a>    
                                    </figure>
                                </div>
                                <div class="container-nome-pagina">
                                    <div class="nome-pagina">
                                        Nossas Lojas
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="coluna-paginas">
                            <div class="pagina">
                                <div class="container-icone-pagina">
                                    <figure>
                                        <a href="filme_do_mes_cms.php">
                                            <img src="icones/icone-filme-do-mes.png">
                                        </a>
                                    </figure>
                                </div>
                                <div class="container-nome-pagina">
                                    <div class="nome-pagina">
                                        Filme do Mês
                                    </div>
                                </div>
                            </div>
                            <div class="pagina">
                                <div class="container-icone-pagina">
                                    <figure>
                                        <a href="ator_cms.php">
                                            <img src="icones/icone-ator.png">
                                        </a>
                                    </figure>
                                </div>
                                <div class="container-nome-pagina">
                                    <div class="nome-pagina">
                                       Ator em Destaque
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>    
    </body>
</html>