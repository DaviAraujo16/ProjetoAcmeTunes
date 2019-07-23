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
                    
                </div>
                <?php include_once("footer_cms.php");?>         
            </div>
        </div>    
    </body>
</html>